# Apility Form Builder for Laravel

## Installation

### Add the form builder to your composer file

```shell
$ composer require apility/form-builder
```

### Create a new Service provider that extends the `Netflex\FormBuilder\Providers\FormBuilderServiceProvider`

Basic example.

```php
<?php
namespace App\Providers;

use Netflex\FormBuilder\Fields\TextInput;
use Netflex\FormBuilder\Interfaces\FormFieldRepository;
use \Netflex\FormBuilder\Providers\FormBuilderServiceProvider as FormBuilderBaseServiceProvider;

class FormBuilderServiceProvider extends FormBuilderBaseServiceProvider
{
    
    function boot(FormFieldRepository $repo)
    {
        $repo->registerField('text', TextInput::class);
    }
}
```

The `registerField` method registers a question/field type that can be rendered by the form builder. You can implement
your own (see the section below for instructions). The class that is provided must implement
the `Netflex\FormBuilder\Interfaces\FormField` class.

We do have a basic implementation that comes with prefilled working bookkeeping 
functionality such as formModel and name injection, as well as hoisting values 
from the matrix field data into the model as attributes.

It might be quicker to use this than implementing similar functionality manually.

Check out the `Netflex\FormBuilder\Fields\BaseField` class.


#### Overrides
It is possible to override data coming from Netflex using an optional 3rd parameter to the `registerField` function.
You can supply an optional associative array to the function like this 

```php
  $repo->registerField('text', TextInput::class);
  $repo->registerField('always-required-text', TextInput::class, ['required' => true]);
```

This is merely substituting any values from Netflex with these, that way you can omit fields that are configurable in the class,
but not something the user should be able to change. Or lets you create reusable field types that can be configured when added.

It is possible to add the same class more than once.

### Add the service providers to your `bootstrap/app.php`

```php
$app->register(\App\Providers\FormBuilderServiceProvider::class);
```

One of these is the one you made yourself, the other provides views.

### Have your form model implement the FormModel interface

The `getFormAttributeKey` should be the same as the alias of the Matrix that contains the questions for the form.
The `getErrorBagName` function decides where the validation errors for FormBuilderRequests go, this should often be
something other than `default`.

```php
<?php

namespace App\Models;

use Illuminate\Routing\Router;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Traits\DefaultFormFieldName;
use Netflex\Structure\Model;

class Form extends Model implements FormModel
{
    use DefaultFormFieldName;

    /**
     * The directory_id associated with the model.
     *
     * @var int
     */
    protected $relationId = 12345;

    //
    public function getFormAttributeKey(): string
    {
        return "fields";
    }

    public function getErrorBagName(): string
    {
        return "form";
    }
    
}

```

#### `DefaultFormFieldName` trait
The model must decare some values which are considered to be menial bookkeeping and not something the developer
really should need to care about except for very  specific cases. This trait implements this functionality so the developer does not have to.

What it does is default the named prefix for all fields to be "questions".
If you want to rename this field, implement the relevant methods manually.

## Implementing custom field types

### The Class
In order to create your own field type, create a new class that extends the `Netflex\FormBuilder\Fields\BaseField` class.
This is both a Laravel view and a special field class that requires you to extends certain variables.

The BaseField class, represents a question in your form and is instantiated once for each

#### QOL tips
* As long as you don't override the constructor of the BaseField class, all the matrix content will be put on this object
automatically. In other words; If you have a "question" field in your matrix block in Netflex, then you will have access to it using `$this->question`
```php
<?php

namespace Netflex\FormBuilder\Fields;

class TextInput extends BaseField
{
    public $required;
    public $question;
    public $description;

    public function formQuestion(): string
    {
        return $this->question ?? "Question is missing";
    }

    public function formDescription(): ?string
    {
        return $this->description;
    }
    
    function formValidators(): array
    {
        return $this->required ? ['required'] : [];
    }

    function formValidationMessages(): array
    {
        return [
            'required' => "Du må fylle inn '{$this->question}' feltet",
        ];
    }

    public function render()
    {
        return view("form-builder::form-fields.text-input", [
            'question' => $this->question,
            'description' => $this->description
        ]);
    }

   
}
```

### The View
They are basically normal components
It is recommended that you use the `view()` function when rendering these components.

* If your render method returns a Laravel view object (for example using the `view()` function) then the errors for the form will be hoisted to the default viewBag so you dont have to
  manually get the correct view bag when resolving errors for a particular field.
* If your render method returns a Laravel view object, then you will also get only error messages related to your current field from the variable `$fieldErrors` 



## Usage
This package is intended to transform Netflex Structure entries into forms using a matrix field.
It provides some simple components for rendering forms components and validating them.

You must supply your own `<form>` tags and backend functionality after the form request has been
verified. The indented ide here is that we provide functionality that handles all form specific things, but does still
let's you use laravel for other non form related things in an organic way.

To get started first create a form using any structure that has a model that implements the `FormModel` interface.

```php
/// Find some entry based on whatever criteria you want
$form = MyFormModel::find(12345);
```

### Rendering forms
You can render a simple form like this.

You wrap a `<x-form-builder::form>` component in a form tag.
<br>That is it.

It is still possible to add your own input fields that are not part of the form. You will need to manually parse them,
but it is still possible.

```
<form action="{{ route('some.route-that-accepts-forms', $form) }}" method="post">
    <input type="text" name="optional_hard_coded_field">
    <x-form-builder::form :form="$form" />
    <button class="submit-button">Send this form</button>
</form>
```

### Show all errors for the form
Sometimes you want a big alert that gives you a list of all failing validation errors when a user submitted a form and it
failed to pass validation.
Use the `<x-form-builder::validation-errors>` component for that.
```php
<x-form-builder::validation-errors :form="$form" />
```

#### Slot
The `<x-form-builder::validation-errors>` component has a slot that lets you input text and similar right above the list
of validation errors, inside the alert.

```html
<x-form-builder::validation-errors :form="$form">
  Oops, something went wrong. Check the contents of your form and try again
</x-form-builder::validation-errors>
```

## Built in Form fields
The library comes with some built in **Bootstrap 5** compatible fields for quick and dirty forms.

### Text Input (`Netflex\FormBuilder\Fields\TextInput`)
All arguments can be controlled from Netflex if added to the matrix block definition

#### Arguments
| Name        | Description                                                                          |
|-------------|--------------------------------------------------------------------------------------|
| question    | The question that will be shown in the field label                                   |
| description | Help text shown beneath the input field                                              |
| required    | Boolean value that describes if the field is required                                |
| placeholder | Input placeholder value                                                              |
| formType    | sets the `type="text"` part of the tag with alternatives such as `phone` and `email` |

#### Internationalization
The following internationalization keys are used by this field
* `form-builder.question.text-input.required`
<br> This field determines the message the user sees when the field is empty. (Should not happend as it will be validated by the browser)
<br> **Following variables can be used in the form**
  * `:name` Returns the question

### Numeric Text Field (`Netflex\FormBuilder\Fields\NumericTextInput`)
This text field is forced to be a number field. It also validates number ranges on the backend
Placeholder is set to an i18n value that indicates potential top/bottom bounds of valid options. 

#### Arguments
| Name        | Description                                                                          |
|-------------|--------------------------------------------------------------------------------------|
| question    | The question that will be shown in the field label                                   |
| description | Help text shown beneath the input field                                              |
| required    | Boolean value that describes if the field is required                                |
| min         | Numeric field for a minimum value, not required                                      | 
| max         | Numeric field for a maximum value, not required                                      | 

#### Internationalization
The following internationalization keys are used by this field
* `form-builder.question.numeric-text-input.required`
  <br> This field determines the message the user sees when the field is empty. (Should not happend as it will be validated by the browser)
  <br> **Following variables can be used in the form**
  * `:name` Returns the question


* `form-builder.question.numeric-text-input.min`
  <br> Message shown to user when the number they selected is too low
  <br> **Following variables can be used in the form**
  * `:name` Returns the question
  * `:count` Returns minimum value


* `form-builder.question.numeric-text-input.max`
  <br> Message shown to user when the number they selected is too high
  <br> **Following variables can be used in the form**
  * `:name` Returns the question
  * `:count` Returns maximum value


* `form-builder.question.numeric-text-input.numeric`
  <br> Message shown to user if the number presented is not numeric
  <br> **Following variables can be used in the form**()
  * `:name` Returns the question

### TextArea  (`Netflex\FormBuilder\Fields\TextArea`)
A multiline text area


#### Arguments
Accepts all the same fields as TextInput (except from `formType`), but also

| Name    | Description                                            |
|---------|--------------------------------------------------------|
| columns | How many columns high the text area is, defaults to 10 |

#### Internationalization
The following internationalization keys are used by this field
* `form-builder.question.numeric-text-area.required`
  <br> This field determines the message the user sees when the field is empty. (Should not happend as it will be validated by the browser)
  <br> **Following variables can be used in the form**
  * `:name` Returns the question



### Checkbox  (`Netflex\FormBuilder\Fields\Checkbox`)
Displays a single checkbox. If required, the box must be checked to proceed. This is mostly used for confirmation
boxes.

#### Arguments
| Name        | Description                                                          |
|-------------|----------------------------------------------------------------------|
| question    | The question that will be shown in the field label                   |
| description | Help text shown beneath the input field                              |
| required    | Boolean value that describes if the field is required                |
| labelText   | Text that is shown next to the checkbox, uses question if left blank |

#### Internationalization
The following internationalization keys are used by this field
* `form-builder.question.checkbox.required`
  <br> This field determines the message the user sees when the field is not checked, if it is required
  <br> **Following variables can be used in the form**
  * `:name` Returns the question

### Select  (`Netflex\FormBuilder\Fields\Select`)
Shows a dropdown of preselected values

#### Arguments
| Name        | Description                                                                        |
|-------------|------------------------------------------------------------------------------------|
| question    | The question that will be shown in the field label                                 |
| description | Help text shown beneath the input field                                            |
| required    | Boolean value that describes if the field is required                              |
| labelText   | Text that is shown next to the checkbox, uses question if left blank               |
| options     | List of options separated by newline, potentially use the TextArea type in netflex | 

#### Internationalization
The following internationalization keys are used by this field
* `form-builder.question.select.required`
  <br> This field determines the message the user sees when no value has been selected (if required is set)
  <br> **Following variables can be used in the form**
  * `:name` Returns the question

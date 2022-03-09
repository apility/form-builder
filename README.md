# Apility Form Builder for Laravel

## Installation

### Add the form builder to your composer file

```shell
$ composer require apility/form-builder
```

### Create a new Service provider that extends the `Netflex\FormBuilder\Providers\FormBuilderServiceProvider`

Basic example.

```injectablephp
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
your own
(see the section below for instructions). The class that is provided must extend
the `Netflex\FormBuilder\Fields\BaseField` class.

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

```injectablephp
$app->register(\App\Providers\FormBuilderServiceProvider::class);
$app->register(\Netflex\FormBuilder\Providers\BaseProvider::class);
```

One of these is the one you made yourself, the other provides views.

### Have your form model implement the FormModel interface

The `getFormAttributeKey` should be the same as the alias of the Matrix that contains the questions for the form.
The `getErrorBagName` function decides where the validation errors for FormBuilderRequests go, this should often be
something other than `default`.

```injectablephp
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

### Use form in blade template

```injectablephp
<x-form-builder::form :form="$form" />
```

### Show all errors for the form

```injectablephp
<x-form-builder::validation-errors :form="$form" />
```

## Implementing custom field types

### The Class
In order to create your own field type, create a new class that extends the `Netflex\FormBuilder\Fields\BaseField` class.
This is both a Laravel view and a special field class that requires you to extends certain variables.

The BaseField class, represents a question in your form and is instantiated once for each

#### QOL tips
* As long as you don't override the constructor of the BaseField class, all the matrix content will be put on this object
automatically. In other words; If you have a "question" field in your matrix block in Netflex, then you will have access to it using `$this->question`
```injectablephp
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
            'formName' => $this->formName(),
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

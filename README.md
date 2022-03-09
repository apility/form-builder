# Apility Form Builder for Laravel

## Installation

### Add the form builder to your composer file
```shell
$ composer require apility/form-builder
```

### Create a new Service provider that extends the `Netflex\FormBuilder\ComponentProvider`

We have some simple prebuilt forms available if you dont need any custom functionality

```injectablephp
<?php
namespace App\Providers;

use Netflex\FormBuilder\ComponentProvider;
use Netflex\FormBuilder\Fields\TextInput;
use Netflex\FormBuilder\Fields\TextArea;
use Netflex\FormBuilder\Scaffolds\Bootstrap5;

class FormProvider extends ComponentProvider {
    public function register() {
        $this->registerRenderer('bootstrap', Bootstrap5::class);
        $this->registerField('input', TextInput::class);
        $this->registerField('area', TextArea::class);
    }
}
```
### Add the Service provider to your list of service providers

TODO: Explain how

### Have your form model implement the FormModel interface

```injectablephp
<?php
namespace App\Models;

use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\Structure\Model;

class MyFormModel extends Model implements FormModel {
    
    /**
    * The name of the matrix field in Netflex where the form data is located
    * @return string
    */
    public function getFormAttributeKey(): string {
        return "my-form-key";
    }
}

```

### Use form in blade template

```injectablephp
<nf::form-builder :form="$form" renderer="bootstrap" />
```

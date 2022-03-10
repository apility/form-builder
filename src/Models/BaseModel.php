<?php

namespace Netflex\FormBuilder\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Interfaces\NameResolvableFormField;
use Netflex\FormBuilder\Requests\FormBuilderRequest;
use Netflex\FormBuilder\Traits\DefaultFormFieldName;
use Netflex\FormBuilder\Traits\ModelFormFieldsResolver;
use Netflex\FormBuilder\Traits\ResolveFormModelFields;
use Netflex\Structure\Model;

abstract class BaseModel extends Model implements FormModel
{
    use DefaultFormFieldName;
    use ResolveFormModelFields;
    use ModelFormFieldsResolver;


    abstract function getFormAttributeKey(): string;
    abstract function getErrorBagName(): string;
}

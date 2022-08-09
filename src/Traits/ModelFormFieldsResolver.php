<?php

namespace Netflex\FormBuilder\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Interfaces\NameResolvableFormField;
use Netflex\FormBuilder\Repositories\FormFieldRepository;
use Netflex\FormBuilder\Requests\FormBuilderRequest;

trait ModelFormFieldsResolver
{

    abstract public function resolveFormModelFields(FormModel $model, ?FormFieldRepository $repo = null): Collection;
    abstract public function getFormFieldRuleName(int $index, FormField $field): string;

    public function getFormFields(): Collection {
        return $this->resolveFormModelFields($this, null);
    }

    public function getFormWithAnswers(?FormBuilderRequest $request = null): Collection {
        /** @var Request $request */
        $request = $request ?? request();

        return $this->getFormFields()
            ->mapWithKeys(function(FormField $field, $i) use ($request) {
                $payload = (object)[
                    'field' => $field,
                    'value' => $request->input($this->getFormFieldRuleName($i, $field)),
                ];

                if($field instanceof NameResolvableFormField) {
                    return [ $field->getResolveByName() => $payload];
                } else {
                    return [$i => $payload];
                }


            });
    }
}

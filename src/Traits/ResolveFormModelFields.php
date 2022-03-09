<?php

namespace Netflex\FormBuilder\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Repositories\FormFieldRepository;

trait ResolveFormModelFields
{

    public function resolveFormModelFields(FormModel $model, ?FormFieldRepository $repo = null): Collection {
        $repo = $repo ?? Container::getInstance()->get(\Netflex\FormBuilder\Interfaces\FormFieldRepository::class);
        return collect($model[$model->getFormAttributeKey()])
            ->map(fn($data, $index) => $repo->transform($data)->setFormModel($model)->setFormName($model->getFormFieldName($index)));
    }
}

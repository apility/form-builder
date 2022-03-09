<?php

namespace Netflex\FormBuilder\Traits;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Netflex\FormBuilder\Interfaces\FormModel;

trait ErrorBagResolver
{

    public function getErrorBag(FormModel $formModel): MessageBag {
        return Session::get('errors', new ViewErrorBag)->getBag($formModel->getErrorBagName());
    }
}

<?php

namespace Netflex\FormBuilder\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Traits\ErrorBagResolver;

class ValidationErrors extends Component
{

    use ErrorBagResolver;

    protected ?FormModel $form = null;

    public function __construct(FormModel $form)
    {
        $this->form = $form;
    }


    public function render()
    {
        $errors = $this->getErrorBag($this->form);
        return view('form-builder::components.validation-errors')->with('errors', $errors);
    }
}

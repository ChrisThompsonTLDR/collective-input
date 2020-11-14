<?php

namespace Christhompsontldr\CollectiveInput\View\Components;

class Tw extends Base
{
    public $inputWrapperClass;

    /**
     * Used by checkbox and radios
     * @var string
     */
    public $labelWrapperClass;

    protected $framework = 'tw';

    protected function classes()
    {

        // Input

        // load from config
        if (is_null($this->groupClass)) {
            $this->groupClass = config('form.tailwind.group.class');
        }
        if (is_null($this->inputClass)) {
            $this->inputClass = config('form.tailwind.input.class');
        }
        if (is_null($this->labelClass)) {
            $this->labelClass = config('form.tailwind.label.class');
        }
        if (is_null($this->helperClass)) {
            $this->helperClass = config('form.tailwind.helper.class');
        }
        if (is_null($this->inputWrapperClass)) {
            $this->inputWrapperClass = config('form.tailwind.input.wrapper');
        }

        // nothing set by application
        if ($this->inputClass === config('form.tailwind.input.class')) {
            //  do input specific logic
            switch ($this->type) {
                case 'hidden':
                    $this->inputClass = '';
                    break;
                case 'select':
                    $this->inputClass = str_replace('form-input', 'form-select', $this->inputClass);
                    break;
                case 'checkbox':
                    $this->inputClass = str_replace(['form-input', 'block w-full'], ['form-checkbox', 'h-4 w-4'], $this->inputClass);
                    break;
                case 'radio':
                    $this->inputClass = str_replace(['form-input', 'block w-full'], ['form-radio', 'h-4 w-4'], $this->inputClass);
                    break;
            }
        }

        // SELECT

        // nothing set by application
        if (in_array($this->type, ['checkbox', 'radio'])) {
            if ($this->groupClass === config('form.tailwind.group.class')) {
                $this->groupClass = 'relative flex items-start';
            }
            if ($this->inputWrapperClass === config('form.tailwind.input.wrapper')) {
                $this->inputWrapperClass = 'flex items-center h-5';
            }
            if ($this->labelWrapperClass === config('form.tailwind.label.wrapper')) {
                $this->labelWrapperClass = 'ml-3 text-sm leading-5';
            }
        }


        if (!empty($this->inputClass)) {
            $this->inputClasses[] = $this->inputClass;
        }


        if ($this->type !== 'hidden') {
            $this->formGroup = isset($this->options['form-group']) && $this->options['form-group'] === false
                ? false
                : $this->formGroup;

            $this->groupClass = isset($this->options['form-group']) && isset($this->options['form-group']['class'])
                ? $this->options['form-group']['class']
                : $this->groupClass;

            if ($this->groupClass) {
                unset($this->options['form-group']);
            }
        }

        // validation errors in session
        if (optional(optional(session()->get('errors'))->getBag('default'))->get($this->dotName)) {
            $this->inputClasses[] = config('form.tailwind.invalid.class');
        }
        // validation errors in livewire
        if (optional(optional(view()->getShared()['errors'])->getBag('default'))->get($this->dotName)) {
            $this->inputClasses[] = config('form.tailwind.invalid.class');
        }

/*        if ($this->type === 'file') {
            $this->inputClasses[] = 'custom-file-input';

            // remove the default Bootstrap class
            if (($key = array_search('form-control', $this->options, true)) !== false) {
                unset($this->inputClasses[$key]);
            }
        }*/


        // Group

        // nothing set by application
/*        if (in_array($this->type, ['checkbox', 'radio']) && $this->groupClass === config('form.tailwind.group.class')) {
            $this->groupClass .= ' form-check';
        }*/

        if (!empty($this->groupClass)) {
            $this->groupClasses[] = $this->groupClass;
        }

/*        if ($this->type === 'file') {
            $this->groupClasses[] = 'custom-file';

            // remove the default Bootstrap class
            if (($key = array_search('form-group', $this->options, true)) !== false) {
                unset($this->inputClasses[$key]);
            }
        }*/


        // Label

        // nothing set by application
/*        if (empty($this->labelClass)) {
            if (in_array($this->type, ['checkbox', 'radio'])) {
                $this->labelClasses[] = 'form-check-label';
            }
            elseif ($this->type === 'file') {
                $this->labelClasses[] = 'custom-file-label';
            }
        }*/
    }
}

<?php

namespace Christhompsontldr\CollectiveInput\View\Components;

class Bs extends Base
{

    protected $framework = 'bs';

    /**
     * Classes to apply to the wrapper div
     */
    public $groupClass = 'form-group';

    /**
     * Classes to apply to the input.
     */
    public $inputClass = 'form-control';

    /**
     * The class to apply to labels.
     * Empty by default per Bootstrap.
     */
    public $labelClass;

    public function classes()
    {
        // Input

        // nothing set by application
        if ($this->inputClass === 'form-control') {
            //  do input specific logic
            switch ($this->type) {
                case 'checkbox':
                case 'radio':
                    $this->inputClass = 'form-check-input';
                    break;
                case 'hidden':
                    $this->inputClass = '';
                    break;
            }
        }

        if (!empty($this->inputClass)) {
            $this->inputClasses[] = $this->inputClass;
        }

        // backwards compatibility with v2
        if (isset($this->options['class'])) {
            $this->inputClasses[] = $this->options['class'];
            unset($this->options['class']);
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
            $this->inputClasses[] = 'is-invalid';
        }
        // validation errors in livewire
        if (optional(optional(view()->getShared()['errors'])->getBag('default'))->get($this->dotName)) {
            $this->inputClasses[] = 'is-invalid';
        }

        if ($this->type === 'file') {
            $this->inputClasses[] = 'custom-file-input';

            // remove the default Bootstrap class
            if (($key = array_search('form-control', $this->options, true)) !== false) {
                unset($this->inputClasses[$key]);
            }
        }


        // Group

        // nothing set by application
        if (in_array($this->type, ['checkbox', 'radio']) && $this->groupClass === 'form-group') {
            $this->groupClass .= ' form-check';
        }

        if (!empty($this->groupClass)) {
            $this->groupClasses[] = $this->groupClass;
        }

        if ($this->type === 'file') {
            $this->groupClasses[] = 'custom-file';

            // remove the default Bootstrap class
            if (($key = array_search('form-group', $this->options, true)) !== false) {
                unset($this->inputClasses[$key]);
            }
        }


        // Label

        // nothing set by application
        if (empty($this->labelClass)) {
            if (in_array($this->type, ['checkbox', 'radio'])) {
                $this->labelClasses[] = 'form-check-label';
            }
            elseif ($this->type === 'file') {
                $this->labelClasses[] = 'custom-file-label';
            }
        }
    }
}

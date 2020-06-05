<?php

namespace Christhompsontldr\CollectiveInput\View\Components;

use Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use ReflectionClass;

class Bs extends Component
{
    public $before;

    public $after;

    public $value;

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

    /**
     * Include the jQuery JS lib.
     *
     * @var boolean
     */
    public $jquery = false;

    /**
     * Label for the input
     *
     * @var string|boolean
     */
    public $label = '';

    /**
     * Some inputs need their labels to
     * render after the input DOM
     *
     * @see https://getbootstrap.com/docs/4.5/components/forms/#checkboxes-and-radios
     * @var string|boolean
     */
    public $labelAfter = '';

    /**
     * Display the input helper
     *
     * @see https://getbootstrap.com/docs/4.5/components/forms/#help-text
     * @var string
     */
    public $helper = '';

    /**
     * The input name
     *
     * @var string
     */
    public $name;

    /**
     * The input options, not the select options
     *
     * @var array
     */
    public $options = [];

    /**
     * The input type
     *
     * @var string
     */
    public $type = 'text';

    /**
     * Display the form-group wrapper div
     *
     * @var boolean
     */
    public $formGroup = true;

    /**
     * Converts user[first_name] to user.first_name
     * This helps with find errors in the MessageBag
     */
    public $dotName;

    /**
     * Array of states for the address dropdown
     *
     * @var array
     */
    public $states = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AR' => 'Arkansas',
        'AZ' => 'Arizona',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
        // Commonwealth/Territory and Military
        'AS' => 'American Samoa',
        'DC' => 'District of Columbia',
        'FM' => 'Federated States of Micronesia',
        'GU' => 'Guam',
        'MH' => 'Marshall Islands',
        'MP' => 'Northern Mariana Islands',
        'PW' => 'Palau',
        'PR' => 'Puerto Rico',
        'VI' => 'Virgin Islands',
        'AE' => 'Armed Forces Africa',
        'AA' => 'Armed Forces Americas',
        'AE' => 'Armed Forces Canada',
        'AE' => 'Armed Forces Europe',
        'AE' => 'Armed Forces Middle East',
        'AP' => 'Armed Forces Pacific',
    ];

    /**
     * Array of options for a <select> input
     *
     * @var array
     */
    public $selectOptions = [];

    /**
     * Array of classes for the input
     *
     * @var array
     */
    private $inputClasses = [];

    /**
     * Array of classes for the wrapper div
     *
     * @var array
     */
    private $groupClasses = [];

    /**
     * Array of classes for the label
     *
     * @var array
     */
    private $labelClasses = [];

    /**
     * Whether or not the radio/checkbox is checked
     *
     * @var boolean
     */
    public $checked;

    /**
     * Create the component instance.
     *
     * @param  string  $name
     * @param  string  $type
     * @param  array  $options
     * @return void
     */
    public function __construct($name, $type = 'text', $options = [], $required = null, $label = null, $selected = null, $selectOptions = null, $checked = null, $placeholder = null, $formGroup = null, $groupClass = null, $labelClass = null, $dusk = null, $helper = null)
    {
        // convert from dot syntax to HTML syntax
        $name = str_replace('.', '[', $name) . ((Str::of($name)->contains('.')) ? ']' : '');

        $this->name    = $name;
        $this->type    = $type;
        $this->options = $options;

        // overload options
        foreach (Arr::except(get_defined_vars(), ['name', 'type', 'options']) as $key => $val) {
            if (!is_null($key) && !isset($this->options[$key])) {
                $this->options[$key] = $val;
            }
        }

        $this->dotName = (string) Str::of($name)->replace(['[', ']'], ['.', '']);

        // change the type if appropriate
        if (isset($this->options['selectOptions'])) {
            $this->type = 'select';
            $this->options['options'] = $this->options['selectOptions'];
        }

        // build the label
        $this->label();

        // build the id
        $this->id();

        $this->booleans();

        $this->classes();

        $this->livewireModel();

        // build the value
        $this->value();

        // determine if checked
        $this->checked();

        // inject jquery
        $this->jquery();

        $this->parameters();

        // clean up
        $this->clean();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render($component = false)
    {
        $blade = $this->type;

        //  do input specific logic
        switch ($this->type) {
            case 'email':
                $blade = 'email';
                break;

            case 'html':
                $this->options['required'] = false; // Summernote had a validation/js bug
                break;

            case 'datetime':
                $blade = 'datetime';

                // add .datetime to the input if it hasn't been already
                if ($this->class !== 'datetime' && !Str::of($this->class)->contains([' datetime', 'datetime '])) {
                    $this->class .= ' datetime';
                }
                break;

            case 'address':
                $blade = 'address';
                break;

            case 'checkbox':
            case 'radio':
                $this->labelAfter = $this->label;
                $this->label = false;
                break;
        }

        $this->options['class'] = implode(' ', array_map('trim', $this->inputClasses));
        $this->labelClass       = implode(' ', array_map('trim', $this->labelClasses));
        $this->groupClass       = implode(' ', array_map('trim', $this->groupClasses));

        // remove dusk selectors
        if (!config('form.dusk')) {
            unset($this->options['dusk']);
        }

        // default to using the text blade
        if (!view()->exists('form::bs.' . $blade)) {
            $blade = 'text';
        }

        if ($component) {
            return view('form::bs.' . $blade, get_object_vars($this));
        }

        return view('form::bs.' . $blade);
    }

    private function classes()
    {

        // Input

        // nothing set by application
        if (in_array($this->type, ['checkbox', 'radio']) && $this->inputClass === 'form-control') {
            $this->inputClass = 'form-check-input';
        }

        if (!empty($this->inputClass)) {
            $this->inputClasses[] = $this->inputClass;
        }

        // validation errors
        if (optional(optional(session()->get('errors'))->getBag('default'))->get($this->dotName)) {
            $this->inputClasses[] = 'is-invalid';
        }

        if ($this->type === 'file') {
            $this->inputClasses[] = 'custom-file-input';

            // remove the default Bootstrap class
            if (($key = array_search('form-control', $this->options)) !== false) {
                unset($this->inputClasses[$key]);
            }
        }


        // Group

        // nothing set by application
        if (in_array($this->type, ['checkbox', 'radio']) && $this->groupClass === 'form-group') {
            $this->groupClass = 'form-check';
        }

        if (!empty($this->groupClass)) {
            $this->groupClasses[] = $this->groupClass;
        }

        if ($this->type === 'file') {
            $this->groupClasses[] = 'custom-file';

            // remove the default Bootstrap class
            if (($key = array_search('form-group', $this->options)) !== false) {
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

    /**
     * Convert options values to key => boolean
     */
    private function booleans()
    {
        foreach (['required', 'checked', 'selected', 'placeholder', 'dusk'] as $key) {
            // check if 'required' is a value, convert it to a key => true
            if (in_array($key, $this->options, true)) {
                $this->options[$key] = true;

                // remove the 'required' value
                if (($int = array_search($key, $this->options)) !== false) {
                    unset($this->options[$int]);
                }
            }
        }

        if ($this->options['placeholder'] === true) {
            $this->options['placeholder'] = (($this->type === 'select') ? 'Select ' : '') . $this->label;
        }

        if ($this->options['dusk'] === true) {
            $this->options['dusk'] = $this->options['id'] . '-' . $this->type;
        }
    }

    /**
     * Convert livewire key to key => value
     */
    private function livewireModel()
    {
        if (in_array('livewire', $this->options, true)) {
            $this->options['wire:model'] = $this->name;
        }
    }

    /**
     * Build the input label
     */
    private function label()
    {
        $label = Arr::get($this->options, 'label', null);

        // nothing passed
        if (is_null($label) || $label === true) {
            $label = Str::of($this->name);

            // remove _id from the end
            if ($label->endsWith('_id')) {
                $label = $label->substr(0, -3);
            }

            $label = $label->replace(['_', '[', ']', '.'], ' ');

            $this->label = trim(ucwords((string) $label));
        } else {
            $this->label = $label;
        }
    }

    /**
     * Generate the input id
     */
    private function id()
    {
        if ($id = Arr::get($this->options, 'id', true)) {
            // auto generate label
            if ($id === true) {
                $id = Str::of($this->name);

                $id = $id->replace(['_', '[', ']', '.'], ' ');

                $this->options['id'] = trim((string) $id->slug());
            }
            // string was passed, not modify it
            else {
                $this->options['id'] = $id;
            }
        }
    }

    /**
     * Generate the input value
     */
    private function value()
    {
        // start with the old() value
        $value = old($this->name, null);

        // allow the blade to set it
        $value = Arr::get($this->options, 'value', $value);

        // use the model value
        if (is_null($value)) {
            optional(Form::getModel())->{$this->name};
        }

        // no value set yet
        if (is_null($value)) {
            // default the value to true
            if (in_array($this->type, ['checkbox', 'radio'])) {
                $value = true;
            }
        }

        // overload the value
        if (!is_null($value)) {
            $this->value = $value;
        }
    }

    private function jquery()
    {
        if (in_array('jquery', $this->options, true) || (isset($this->options['jquery']) && $this->options['jquery'] === true)) {
            $this->jquery = true;
        }
    }

    private function checked()
    {
        if (in_array($this->type, ['checkbox', 'radio'])) {
            //  if these fields don't have a value, make it true
            if (empty($this->value)) {
                $this->value = true;
            }

            //  if checked is not set, set it if needed
            if (optional(Form::getModel())->{$this->name} === $this->value) {
                $options['checked'] = true;
            }
        }
    }

    /**
     * Remove option keys and values that we
     * do not want to pass to Form::text()
     */
    private function clean()
    {
        foreach (['label', 'jquery', 'helper', 'states', 'selectOptions', 'livewire', 'options', 'checked'] as $val) {
            // is array value
            if (($key = array_search($val, $this->options)) !== false) {
                unset($this->options[$key]);
            }

            // is array key
            unset($this->options[$val]);
        }
    }

    /**
     * Move options from the options array
     * to their own parameter
     */
    private function parameters()
    {
        if (isset($this->options['options'])) {
            $this->selectOptions = $this->options['options'];
        }

        foreach (['states', 'helper', 'after', 'before', 'checked'] as $key) {
            if (isset($this->options[$key])) {
                $this->{$key} = $this->options[$key];
            }
        }
    }
}

<?php
$dotName = str_replace(['[', ']'], ['.', ''], $name);

$name = str_replace('.', '[', $name) . ((Str::contains($name, '.')) ? ']' : '');

if (!isset($type)) {
    $type = 'text';
}

//  add the invalid class
if (!isset($options['class'])) {
    if (in_array($type, ['checkbox', 'radio'])) {
        $options['class'] = ' form-check-input';
    }
    elseif ($type == 'file') {
        $options['class'] = 'form-control-file';
    }
    else {
        $options['class'] = 'form-control';
    }
}
if(isset($errors)) {
    $options['class'] .= (($errors->has($dotName)) ? ' is-invalid' : '');
}

// check if 'required' is a value, convert it to a key => true
if (in_array('required', $options, true)) {
    $options['required'] = true;
} else {
    $options['required'] = false;
}

//  unset checked if not true
if (isset($options['checked']) && $options['checked'] != true) {
    unset($options['checked']);
}

$selected = null;
if (isset($options['selected'])) {
    $selected = $options['selected'];
    unset($options['selected']);
}
$selectOptions = [];
if (isset($options['options'])) {
    $selectOptions = $options['options'];
    unset($options['options']);
}
$after = '';
if (isset($options['after'])) {
    $after = $options['after'];
    unset($options['after']);
}
$states = false;
if (isset($options['states'])) {
    $states = $options['states'];
    unset($options['states']);
} else {
    $states = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
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
}


$label = false;
if (isset($options['label']) && $options['label'] !== false) {
    $label = $options['label'];
} elseif (!isset($options['label'])) {
    $label = trim(ucwords(str_replace(['_id', '_', '[', ']'], ['', ' ', ' ', ''], $name)));
}
unset($options['label']);


if (!isset($options['id'])) {
    $options['id'] = $name;

    $options['id'] = Str::slug(str_replace(['[', ']'], ['_', ''], $options['id']));
}


$formGroupClass = 'form-group';
$formGroup = true;

if (isset($options['form-group'])) {
    if (isset($options['form-group']['class'])) {
        $formGroupClass = trim($options['form-group']['class']);
    }

    if ($options['form-group'] == false) {
        $formGroup = false;
    }

    unset($options['form-group']);
}


$formCheckClass = 'form-check';
$formCheck = true;

if (isset($options['form-check'])) {
    if (isset($options['form-check']['class'])) {
        $formCheckClass = trim($options['form-check']['class']);
    }

    if ($options['form-check'] == false) {
        $formCheck = false;
    }

    unset($options['form-check']);
}


if (in_array($type, ['checkbox', 'radio'])) {
    //  if these fields don't have a value, make it true
    if (!isset($options['value'])) {
        $options['value'] = true;
    }

    //  if checked is not set, set it if needed
    if (!isset($options['checked'])) {
        if (method_exists('Form', 'getModel') && Form::getModel()->{$name} == $options['value']) {
            $options['checked'] = true;
        }
    }
}

$value = old($name, optional(Form::getModel())->{$name});
if (isset($options['value'])) {
    $value = $options['value'];
}


$fieldType = $type;

//  switch field type to textarea for type=html
switch ($type) {
    case 'html':
        $fieldType = 'textarea';
        $options['required'] = false;
        break;
    case 'markdown':
        $fieldType = 'textarea';
        break;
    case 'datetime':
        $fieldType = 'text';
        $options['class'] .= ' datetime';
        break;
    case 'checkbox':
    case 'radio':
        $options['checked'] = isset($options['checked']) ? $options['checked'] : false;
        break;
}


// livewire
if (in_array('livewire', $options)) {
    $options['wire:model'] = $name;

    if (($key = array_search('livewire', $options)) !== false) {
        unset($options[$key]);
    }
}


if (isset($options['class'])) {
    $options['class'] = trim($options['class']);
}
?>
@if ($formGroup)<div class="{{ $formGroupClass }}">@endif
    @if ($label !== false && !in_array($type, ['checkbox', 'radio', 'address']))
    {{ Form::label($name, $label) }}
    @endif

    @if ($fieldType == 'select')
    {{ Form::{$fieldType}($name, $selectOptions, $selected, $options) }}

    @elseif (in_array($type, ['checkbox', 'radio']))
        @if ($formCheck)<div class="{{ $formCheckClass }}">@endif
        {{ Form::{$fieldType}($name, $options['value'], $options['checked'], $options) }}
        @if ($label !== false)
            {{ Form::label($options['id'], $label, ['class' => 'form-check-label'], false) }}
        @endif
        @if ($formCheck)</div>@endif

    @elseif ($fieldType == 'address')
    @php
    $tmpOptions = $options;
    $tmpOptions['class'] .= ' mb-1';
    @endphp
    @if ($label !== false)
    <label for="{{ $options['id'] . '_' . 'address' }}">Address</label>
    @endif
    {{ Form::text('address', optional($value)->address, array_merge($tmpOptions, ['id' => $options['id'] . '_' . 'address'])) }}
    @php
    $tmpOptions = $options;
    $tmpOptions['id'] .= $options['id'] . '_' . 'address_2';
    if (($key = array_search('required', $tmpOptions)) !== false) {
        unset($tmpOptions[$key]);
    }
    @endphp
    {{ Form::text('address_2', optional($value)->address_2, $tmpOptions) }}
    @if ($formGroup)</div><div class="{{ $formGroupClass }}">@endif

    <div class="form-row">
        <div class="col-sm">
            @if ($label !== false)
            <label for="{{ $options['id'] . '_' . 'city' }}">City</label>
            @endif
            {{ Form::text('city', optional($value)->city, array_merge($options, ['id' => $options['id'] . '_' . 'city'])) }}
        </div>
        <div class="col-sm">
            @if ($label !== false)
            <label for="{{ $options['id'] . '_' . 'state' }}">State</label>
            @endif
            @if ($states)
            {{ Form::select('state', $states, optional($value)->state, array_merge($options, ['placeholder' => '', 'id' => $options['id'] . '_' . 'state'])) }}
            @else
            {{ Form::text('state', optional($value)->state, array_merge($options, ['id' => $options['id'] . '_' . 'state'])) }}
            @endif
        </div>
        <div class="col-sm">
            @if ($label !== false)
            <label for="{{ $options['id'] . '_' . 'zip' }}">Zip</label>
            @endif
            {{ Form::text('zip', optional($value)->zip, array_merge($options, ['id' => $options['id'] . '_' . 'zip'])) }}
        </div>
    </div>

    @elseif($type == 'datetime')
    <div class="input-group date" id="{{ $options['id'] }}" data-target-input="nearest">
        <input type="text" name="{{ $name }}" class="{{ $options['class'] }}" data-target="#{{ $options['id'] }}">
        <div class="input-group-append" data-target="#{{ $options['id'] }}" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fal fa-calendar-alt"></i></div>
        </div>
    </div>

    @elseif(in_array($type, ['password', 'file']))
    {{ Form::{$fieldType}($name, $options) }}

    @else
    {{ Form::{$fieldType}($name, $value, $options) }}
    @endif

    @if ($after)
        {!! $after !!}
    @endif

    @if(isset($errors))
        {!! $errors->first($dotName, '<small class="invalid-feedback">:message</small>') !!}
    @endif
@if ($formGroup)</div>@endif

@if ($type == 'html')
    @pushonce('after-styles:summernote')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.css" integrity="sha256-fPUAOwSYkVTnL8xdLidCEi5IxW+ZVfcmNJ4m/+EGVI8=" crossorigin="anonymous" />
    @endpushonce

    @pushonce('after-scripts:summernote')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.min.js" integrity="sha256-o5hEO6rl7yksLT3gTjQcYYDt03Lx9VwNu81FrO82Ofw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.min.js" integrity="sha256-uzabfEBBxmdH/zDxYYF2N7MyYYGkkerVpVwRixL92xM=" crossorigin="anonymous"></script>
    @endpushonce

    @push('after-scripts')
    <script>
    $(function() {
        $('#{{ $options['id'] }}').summernote({
            height: {{ isset($options['height']) ? $options['height'] : 400 }},
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['link', ['link']]
            ]
        });
    });
    </script>
    @endpush
@endif

@if ($type == 'datetime')
    @pushonce('after-styles:datetime')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
    @endpushonce

    @pushonce('after-scripts:datetime')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
        $(function () {
            $('.datetime').datetimepicker({
                icons: {
                    time: "fal fa-clock",
                    date: "fal fa-calendar-alt",
                    up: "fal fa-arrow-up",
                    down: "fal fa-arrow-down"
                },
                defaultDate: "{{ $value }}",
            });
        });
    </script>
    @endpushonce
@endif

@if ($type == 'markdown')
    @pushonce('after-styles:markdown')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css" integrity="sha256-Is0XNfNX8KF/70J2nv8Qe6BWyiXrtFxKfJBHoDgNAEM=" crossorigin="anonymous" />
    @endpushonce

    @pushonce('after-scripts:markdown')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js" integrity="sha256-6sZs7OGP0Uzcl7UDsLaNsy1K0KTZx1+6yEVrRJMn2IM=" crossorigin="anonymous"></script>
    @endpushonce
    @push('after-scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var simplemde = new SimpleMDE({
                element: document.getElementById("{{ $options['id'] }}"),
	            toolbar: ["bold", "italic", "heading-3", "|", "quote", "|", "unordered-list", "ordered-list", "|", "link", "image"],
            });
        });
    </script>
    @endpush
@endif

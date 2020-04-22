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

$options['id'] = Str::slug(str_replace(['[', ']'], '', $options['id']) . $label);

$value = old($name, optional(Form::getModel())->{$name});
if (isset($options['value'])) {
    $value = $options['value'];
}


//  switch field type to textarea for type=html
switch ($type) {
    case 'html':
        $fieldType = 'textarea';
        $options['required'] = false;
        break;
    case 'datetime':
        $fieldType = 'text';
        $options['class'] .= ' datetime';
        break;
    case 'checkbox':
    case 'radio':
        $options['checked'] = isset($options['checked']) ? $options['checked'] : false;
    default:
        $fieldType = $type;
}

if (isset($options['class'])) {
    $options['class'] = trim($options['class']);
}
?>
@if ($formGroup)<div class="{{ $formGroupClass }}">@endif
    @if ($label !== false && !in_array($type, ['checkbox', 'radio']))
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
    {{ Form::text('address', optional($value)->address, $tmpOptions) }}
    {{ Form::text('address_2', optional($value)->address_2, $options) }}
    @if ($formGroup)</div><div class="{{ $formGroupClass }}">@endif

    <div class="form-row">
        <div class="col-sm">
            @if ($label !== false)
            {{ Form::label('city', 'City') }}
            @endif
            {{ Form::text('city', optional($value)->city, $options) }}
        </div>
        <div class="col-sm">
            @if ($label !== false)
            {{ Form::label('state', 'State') }}
            @endif
            @if ($states)
            {{ Form::select('state', $states, optional($value)->state, array_merge(['placeholder' => ''], $options)) }}
            @else
            {{ Form::text('state', optional($value)->state, $options) }}
            @endif
        </div>
        <div class="col-sm">
            @if ($label !== false)
            {{ Form::label('zip', 'Zip') }}
            @endif
            {{ Form::text('zip', optional($value)->zip, $options) }}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css">
    @endpushonce

    @pushonce('after-scripts:datetime')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" integrity="sha256-CutOzxCRucUsn6C6TcEYsauvvYilEniTXldPa6/wu0k=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
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

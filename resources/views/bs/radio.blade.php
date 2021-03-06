@extends('form::bs.input')

@section('input')
{{-- https://stackoverflow.com/questions/155291/can-html-checkboxes-be-set-to-readonly --}}
@if (Arr::get($options, 'readonly', false))
    {{ Form::hidden($name, $value) }}
    @php
        $name = '_tmp_' . $name;

        $options['disabled'] = true;
    @endphp
@endif

{{ Form::radio($name, $value, $checked, $options) }}
@overwrite

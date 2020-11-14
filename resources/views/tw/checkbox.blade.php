@extends('form::tw.input')

@section('input')
{{-- https://stackoverflow.com/questions/155291/can-html-checkboxes-be-set-to-readonly --}}
@if (Arr::get($options, 'readonly', false))
    {{ Form::hidden($name, $value) }}
    @php
        $name = '_tmp_' . $name;

        $options['disabled'] = true;
    @endphp
@endif

{{ Form::checkbox($name, $value, $checked, $options) }}
@overwrite

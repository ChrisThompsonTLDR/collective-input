@extends('form::bs.input')

@section('input')
{{ Form::checkbox($name, $value, $checked, $options) }}
@overwrite
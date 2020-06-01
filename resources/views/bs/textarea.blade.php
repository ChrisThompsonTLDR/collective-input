@extends('form::bs.input')

@section('input')
{{ Form::textarea($name, $value, $options) }}
@overwrite

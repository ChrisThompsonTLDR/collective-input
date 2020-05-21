@extends('form::bs.input')

@section('input')
{{ Form::email($name, $value, $options) }}
@overwrite

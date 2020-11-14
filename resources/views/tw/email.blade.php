@extends('form::tw.input')

@section('input')
{{ Form::email($name, $value, $options) }}
@overwrite

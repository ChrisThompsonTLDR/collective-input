@extends('form::bs.input')

@section('input')
{{ Form::text($name, $value, $options) }}
@overwrite

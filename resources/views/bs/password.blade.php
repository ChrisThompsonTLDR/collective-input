@extends('form::bs.input')

@section('input')
{{ Form::password($name, $options) }}
@overwrite

@extends('form::tw.input')

@section('input')
{{ Form::password($name, $options) }}
@overwrite

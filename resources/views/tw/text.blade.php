@extends('form::tw.input')

@section('input')
{{ Form::{$type}($name, $value, $options) }}
@overwrite

@extends('form::bs.input')

@section('input')
{{ Form::{$type}($name, $value, $options) }}
@overwrite

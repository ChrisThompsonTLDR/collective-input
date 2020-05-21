@extends('form::base')

@section('input')
    @if($formGroup)<div @if ($groupClass){!! 'class="' . $groupClass . '"' !!}@endif>@endif
        {{ $before }}
        @if($label)<label for="{{ $name }}" @if ($labelClass){!! 'class="' . $labelClass . '"' !!}@endif>{{ $label }}</label>@endif
        @yield('input')
        @if($labelAfter)<label for="{{ $name }}" @if ($labelClass){!! 'class="' . $labelClass . '"' !!}@endif>{{ $labelAfter }}</label>@endif
        @if($helper)<small id="{{ $name }}Help" class="form-text text-muted">{{ $helper }}</small>@endif
        @error($dotName)<small class="invalid-feedback">{{ $message }}</small>@endif
        {{ $after }}
    @if($formGroup)</div>@endif
@overwrite

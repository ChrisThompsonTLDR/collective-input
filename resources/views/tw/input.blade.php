@extends('form::base')

@section('input')
    @if($formGroup)<div @if ($groupClass){!! 'class="' . $groupClass . '"' !!}@endif>@endif
        {!! $before !!}
        @if($label && !$labelAfter)<label for="{{ $options['id'] }}" @if ($labelClass){!! 'class="' . $labelClass . '"' !!}@endif>{!! $label !!}</label>@endif

        <div @if ($inputWrapperClass){!! 'class="' . $inputWrapperClass . '"' !!}@endif>
        @yield('input')
        </div>
        @if($label && $labelAfter)<div class="{{ $labelWrapperClass }}"><label for="{{ $options['id'] }}" @if ($labelClass){!! 'class="' . $labelClass . '"' !!}@endif>{!! $label !!}</label></div>@endif
        @if($helper)<small id="{{ $name }}-help" class="form-text text-muted">{{ $helper }}</small>@endif
        @error($dotName)<small class="invalid-feedback">{{ $message }}</small>@enderror
        {!! $after !!}
    @if($formGroup)</div>@endif
@overwrite

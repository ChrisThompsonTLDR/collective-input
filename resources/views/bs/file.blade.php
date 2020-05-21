@extends('form::bs.base')

@section('input')
{{ Form::file($name, $options) }}
@overwrite

@pushonce($afterScriptsOnceFile)
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
$(function() {
    bsCustomFileInput.init();
});
</script>
@endpushonce

@extends('form::bs.input')

@section('input')
<div class="input-group date" id="{{ $id }}" data-target-input="nearest">
    <input type="text" name="{{ $name }}" class="{{ $class }}" data-target="#{{ $id }}">
    <div class="input-group-append" data-target="#{{ $id }}" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fal fa-calendar-alt"></i></div>
    </div>
</div>
@overwrite

@pushonce($afterStylesOnceDatetime)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
@endpushonce

@pushonce($afterScriptsOnceDatetime)
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script>
    $(function () {
        $('.datetime').datetimepicker({
            icons: {
                time: "fal fa-clock",
                date: "fal fa-calendar-alt",
                up: "fal fa-arrow-up",
                down: "fal fa-arrow-down"
            },
            defaultDate: "{{ $value }}",
        });
    });
</script>
@endpushonce

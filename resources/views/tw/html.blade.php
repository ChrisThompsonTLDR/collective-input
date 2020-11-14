@extends('form::tw.textarea')

@pushonce('after-styles:summernote')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.css" integrity="sha256-fPUAOwSYkVTnL8xdLidCEi5IxW+ZVfcmNJ4m/+EGVI8=" crossorigin="anonymous" />
@endpushonce

@pushonce('after-scripts:summernote')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote-bs4.min.js" integrity="sha256-o5hEO6rl7yksLT3gTjQcYYDt03Lx9VwNu81FrO82Ofw=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.min.js" integrity="sha256-uzabfEBBxmdH/zDxYYF2N7MyYYGkkerVpVwRixL92xM=" crossorigin="anonymous"></script>
@endpushonce

@push('after-scripts')
<script>
$(function() {
    $('#{{ $options['id'] }}').summernote({
        height: {{ isset($options['height']) ? $options['height'] : 400 }},
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol']],
            ['link', ['link']]
        ]
    });
});
</script>
@endpush

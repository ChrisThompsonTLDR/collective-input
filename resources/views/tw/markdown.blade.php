@include('form::tw.textarea')

<!-- markdown -->
@pushonce('after-styles:markdown')
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css" />
@endpushonce

@pushonce('after-scripts:markdown')
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
@endpushonce
@push(config('form.after-scripts'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new EasyMDE({
            element: document.getElementById("{{ $options['id'] }}"),
            toolbar: ["bold", "italic", "heading-3", "|", "quote", "|", "unordered-list", "ordered-list", "|", "link", "image"],
        });
    });
</script>
@endpush

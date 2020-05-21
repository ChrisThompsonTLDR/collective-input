@include('form::bs.textarea')

<!-- markdown -->
@pushonce($afterStylesOnceMarkdown)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css" integrity="sha256-Is0XNfNX8KF/70J2nv8Qe6BWyiXrtFxKfJBHoDgNAEM=" crossorigin="anonymous" />
@endpushonce

@pushonce($afterScriptsOnceMarkdown)
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js" integrity="sha256-6sZs7OGP0Uzcl7UDsLaNsy1K0KTZx1+6yEVrRJMn2IM=" crossorigin="anonymous"></script>
@endpushonce
@push(config('form.after-scripts'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var simplemde = new SimpleMDE({
            element: document.getElementById("{{ $id }}"),
            toolbar: ["bold", "italic", "heading-3", "|", "quote", "|", "unordered-list", "ordered-list", "|", "link", "image"],
        });
    });
</script>
@endpush

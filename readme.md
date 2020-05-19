This package extends [Laravel Collective](https://github.com/LaravelCollective/html) and adds a new method to help build a [Bootstrap 4 inputs](https://getbootstrap.com/docs/4.3/components/forms/).

```
{{ Form::bs('name', 'text']) }}
```

becomes

```
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name">
</div>
```

## Installation

`composer require christhompsontldr/collective-input`

## Usage

### Assets

This package requires that you add `@stack('after-styles')` to your `<head>` and `@stack('after-scripts')` to the end of your `<body>`.

### Boolean Attributes

All HTML boolean attributes are supported.

```
{{ Form::bs('name', 'text', ['required']) }}
```

### form-group

The form-group wrapper div can be removed with

```
{{ Form::bs('name', 'text', ['form-group' => false]) }}
```

### select options

```
{{ Form::bs('tacos', 'select', ['options' => ['yes' => 'I like tacos', 'no' => 'I do not like tacos']]) }}
```

### HTML input

This package has an HTML textarea that will build a [Summernote](https://summernote.org/) WYSIWYG editor.

`height` is the attribute used to set the height of this textarea.

```
{{ Form::bs('description', 'html', ['height' => 200]) }}
```

### Datetime input

This package has datetime input that will build a datetime picker.

```
{{ Form::bs('description', 'datetime') }}
```

### Inject after the input, inside the form-group

```
{{ Form::bs('name', 'text', ['after' => '<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>']) }}
```

### Addresses

An entire mailing address form can be built with `address` type.

```
{{ Form::bs('billing_address', 'address') }}
```


## Options

### livewire
```
{{ Form::bs('email', 'email', ['livewire']) }}
```
This will add `wire:model="email"` to the input, utilizing the first parameter of `bs()` to generate the [livewire](https://github.com/livewire/livewire) property name.

### jQuery
```
{{ Form::bs('description', 'html', ['jquery']) }}
```
This will add the jQuery package to the DOM.  It is assumed that you already have jQuery included, so generally, you won't use this option.


## Automagical

### Laravel errors

The Laravel error bag will be used to add the correct classes and validation messages.


### Email

If the first parameter is `email`, the input type will be set to email.

```
{{ Form::bs('email') }}
```

becomes

```
<div class="form-group">
    <label for="name">Email</label>
    <input type="email" class="form-control" id="email">
</div>
```

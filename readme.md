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

```
{{ Form::bs('description', 'html') }}
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

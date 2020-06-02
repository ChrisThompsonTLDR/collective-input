This package extends [Laravel Collective](https://github.com/LaravelCollective/html) and adds a new method to help build a [Bootstrap 4 inputs](https://getbootstrap.com/docs/4.5/components/forms/).

### Laravel 5+
```
{{ Form::bs('first_name') }}
```

### Laravel 7

Laravel's new [Component markup](https://laravel.com/docs/7.x/blade#components) is supported.

```
<x-form-bs name="first_name"/>
```

### Generated DOM
```
<div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name">
</div>
```

# Usage

## Attributes and Options

Configuration of the HTML inputs can be accomplished with either attributes or via an "options" array.

### Attributes

#### Mixed

The following are attributes can be boolean or a string: `label` and `placeholder`

If `false` is set as th value, the `label` or `placeholder` will be disabled/not displayed.
```
<x-form-bs name="first_name" label="Your First Name"/>

<x-form-bs name="first_name" :label="false"/>
```

#### Boolean

The following are attributes can be boolean: `checked`, `placeholder`, `selected` and `required`
```
<x-form-bs name="terms_of_service" type="checkbox" checked label="I agree to the Terms of Service"/>
```

The `placeholder` options, when used as a boolean, will attempt to intelligently create a placeholder.

### Options

Or if you find it easier to use a large array of options, that works as well
```
<x-form-bs name="email" type="email" :options="['label' => 'Your Email', 'required']"/>
```

### Shorthand Options

A few options can be passed as a value to make setting them easier.  These include: `required`, `livewire`, `checked`

The following generate the same DOM:
```
<x-form-bs name="first_name" required/>

<x-form-bs name="first_name" :options="['required']"/>

<x-form-bs name="first_name" :options="['required' => true]"/>

{{ Form::bs('first_name', 'text', ['required']) }}

{{ Form::bs('first_name', 'text', ['required' => true]) }}
```

## Dot Syntax

Dot syntax will be automatically converted as needed.

```
<x-form-bs name="user.first_name"/>

<x-form-bs name="user[first_name]"/>
```
Both will create the same DOM.
```
<div class="form-group">
    <label for="user[first_name]">First Name</label>
    <input type="text" class="form-control" id="user-first_name" name="user[first_name]">
</div>
```

# Field Types

All field types are supported, not just the following list.

## Text

Text will be used by default if the `type` is not specified.

## Email
If the `name` attribute is `email`, the email input type will automatically be used.
```
<x-form-bs name="email"/>
```
generates
```
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email">
</div>
```

## Select

```
<x-form-bs name="timezone" :select_options="$timezones" required placeholder/>
```

## WYSIWYG Editor

If the type is set to `html`, the input will be converted to a [Summernote editor](https://github.com/summernote/summernote).
```
<x-form-bs name="description" type="html"/>
```

The `height` option needs to be entered as an integer.

## Markdown Editor

If the type is set to `markdown`, the input will be converted to a [SimpleMDE editor](https://github.com/sparksuite/simplemde-markdown-editor).
```
<x-form-bs name="description" type="markdown"/>
```

## File

If the type is set to `file`, the input will be converted to a [bs-custom-file-input](https://github.com/Johann-S/bs-custom-file-input).

The generated DOM will be [Bootstrap's markup](https://getbootstrap.com/docs/4.5/components/forms/#file-browser).

## Form Group

### Remove

It is possible to remove the wrapper div.
```
<x-form-bs name="first_name" :form-group="false"/>
```

### Class

Add a class to the wrapper div. Make sure to include Bootstrap's default.
```
<x-form-bs name="first_name" group-class="form-group custom-class"/>
```

## Labels

### Automatic

```
<x-form-bs name="role_id"/>
...
<div class="form-group">
    <label for="role_id">Role</label>
    <input type="text" class="form-control" id="role_id" name="role_id">
</div>
```
or
```
<x-form-bs name="user[first_name]"/>
...
<div class="form-group">
    <label for="user-first_name">User First Name</label>
    <input type="text" class="form-control" id="user-first_name" name="user[first_name]">
</div>
```
You can specify the label if you want.
```
<x-form-bs name="role_id" label="Pick a role"/>
...
<div class="form-group">
    <label for="role_id">Pick a role</label>
    <input type="text" class="form-control" id="role_id" name="role_id">
</div>
```

This package will auto generate a human readable `<label>` or you can set your own.

### Remove

It is possible to remove the label.
```
<x-form-bs name="first_name" :label="false"/>
```

### Class

Add a class to the label.
```
<x-form-bs name="first_name" label-class="custom-class"/>
```

## Optional Second Parameter

If using the `Form` class, the second parameter is optional.
```
{{ Form::bs('first_name', ['required']) }}

{{ Form::bs('first_name', 'text', ['required']) }}
```

# Dusk

[Dusk selectors](https://laravel.com/docs/7.x/dusk#dusk-selectors) are enabled by default in any environment other than `production`.  This can by changed in `config/form.php`

# Slots

This package provides two [Blade slots](https://laravel.com/docs/master/blade#slots) for injecting DOM before and after the input.

## Before
```
<x-form-bs name="first_name">
    <x-slot name="before">
        <p>Please enter your full first name.</p>
    </x-slot>
</x-form-bs>
```
will generate
```
<div class="form-group">
    <p>Please enter your full first name.</p>
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name" name="first_name">
</div>
```

## After
```
<x-form-bs name="last_name">
    <x-slot name="after">
        <p>Please enter your full last name.</p>
    </x-slot>
</x-form-bs>
```
will generate
```
<div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" id="last_name" name="last_name">
    <p>Please enter your full last name.</p>
</div>
```

# Assets

If you use `markdown`, `html`, `file` or `datetime` types, you will need to include the following stacks in your layouts.

```
    ...
    @stack('after-styles')
</head>
<body>
    ...
    @stack('after-scripts')
</body>
```

The names of these slots can be configured as part of this package.  Because of the way Laravel Blade/View caching works, you will need to run `php artisan view:clear` if you change these config parameters.

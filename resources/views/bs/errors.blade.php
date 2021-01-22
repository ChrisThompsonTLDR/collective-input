@php
if (isset($options)) {
    if ($found = Arr::get($options, 'wire:model')) {
        $errorName = $found;
    }
    elseif ($found = Arr::get($options, 'wire:model.defer')) {
        $errorName = $found;
    }
    elseif ($found = Arr::get($options, 'wire:model.lazy')) {
        $errorName = $found;
    }
}
@endphp
@error($errorName)<small class="invalid-feedback">{{ $message }}</small>@enderror

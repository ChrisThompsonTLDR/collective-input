@extends('form::base')

@section('input')
    {{ $before }}

    @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '') !!}>@endif
        @if($label)<label for="{{ $name }}">{{ $label }}</label>@endif

        @php
        $addressOptions = $options;
        $addressOptions['class'] .= ' mb-1';
        @endphp

        {{ Form::text($name, $value, $addressOptions) }}

        @php
        $address2Options = $options;
        $address2Options['id'] .= '_address_2';
        if (($key = array_search('required', $address2Options, true)) !== false) {
            unset($address2Options[$key]);
        }
        unset($address2Options['required']);

        if (isset($options['wire:model'])) {
            $address2Options['wire:model'] = 'address_2';
        }

        $address2Name = Str::of($name)->replace('[address]', '[address_2]');
        if ($address2Name->is('address')) {
            $address2Name = 'address_2';
        }
        @endphp

        {{ Form::text($address2Name, optional($value)->address_2, $address2Options) }}
        @if($helper)<small id="{{ $name }}Help" class="form-text text-muted">{{ $helper }}</small>@endif
        @error($dotName)<small class="invalid-feedback">{{ $message }}</small>@endif
    @if($formGroup)</div>@endif

    <div class="form-row">
        <div class="col-sm">
            @php
                if (isset($options['wire:model'])) {
                    $options['wire:model'] = 'city';
                }

                $cityName = Str::of($name)->replace('[address]', '[city]');
                if ($cityName->is('address')) {
                    $cityName = 'city';
                }
            @endphp

            @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '') !!}>@endif
                @if ($label)<label for="{{ $options['id'] . '_' . 'city' }}">City</label>@endif
                {{ Form::text($cityName, optional($value)->city, array_merge($options, ['id' => $options['id'] . '_' . 'city'])) }}
                @error('city')<small class="invalid-feedback">{{ $message }}</small>@endif
            @if($formGroup)</div>@endif
        </div>
        <div class="col-sm">
            @php
                if (isset($options['wire:model'])) {
                    $options['wire:model'] = 'state';
                }

                $stateName = Str::of($name)->replace('[address]', '[state]');
                if ($stateName->is('address')) {
                    $stateName = 'state';
                }
            @endphp
            @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '')  !!}>@endif
                @if ($label)<label for="{{ $options['id'] . '_' . 'state' }}">State</label>@endif
                @if ($states)
                {{ Form::select($stateName, $states, optional($value)->state, array_merge($options, ['placeholder' => '', 'id' => $options['id'] . '_' . 'state'])) }}
                @else
                {{ Form::text($stateName, optional($value)->state, array_merge($options, ['id' => $options['id'] . '_' . 'state'])) }}
                @endif
                @error('state')<small class="invalid-feedback">{{ $message }}</small>@endif
            @if($formGroup)</div>@endif
        </div>
        <div class="col-sm">
            @php
                if (isset($options['wire:model'])) {
                    $options['wire:model'] = 'zip';
                }

                $zipName = Str::of($name)->replace('[address]', '[zip]');
                if ($zipName->is('address')) {
                    $zipName = 'zip';
                }
            @endphp
            @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '') !!}>@endif
                @if ($label !== false)<label for="{{ $options['id'] . '_' . 'zip' }}">Zip</label>@endif
                {{ Form::text($zipName, optional($value)->zip, array_merge($options, ['id' => $options['id'] . '_' . 'zip'])) }}
                @error('zip')<small class="invalid-feedback">{{ $message }}</small>@endif
            @if($formGroup)</div>@endif
        </div>
    </div>

    {{ $after }}
@overwrite

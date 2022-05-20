@extends('form::base')

@section('input')
    {{ $before }}

    @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '') !!}>@endif
        @if($label)<label for="{{ $name }}">{!! $label !!}</label>@endif

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
        elseif (isset($options['wire:model.defer'])) {
            $address2Options['wire:model.defer'] = str_replace('_address', '_address_2', $options['wire:model.defer']);
        }
        elseif (isset($options['wire:model.lazy'])) {
            $address2Options['wire:model.lazy'] = str_replace('_address', '_address_2', $options['wire:model.lazy']);
        }

        $address2Name = Str::of($name)->replace('[address]', '[address_2]');
        if ($address2Name->is('address')) {
            $address2Name = 'address_2';
        }
        @endphp

        {{ Form::text($address2Name, optional($value)->address_2, $address2Options) }}
        @if($helper)<small id="{{ $name }}Help" class="form-text text-muted">{{ $helper }}</small>@endif
        @include('form::bs.errors', ['errorName' => $dotName])
    @if($formGroup)</div>@endif

    <div class="form-row">
        <div class="col-sm">
            @php
                if (isset($options['wire:model'])) {
                    $options['wire:model'] = 'city';
                }
                elseif (isset($options['wire:model.defer'])) {
                    $options['wire:model.defer'] = str_replace('_address', '_city', $options['wire:model.defer']);
                }
                elseif (isset($options['wire:model.lazy'])) {
                    $options['wire:model.lazy'] = str_replace('_address', '_city', $options['wire:model.lazy']);
                }

                $cityName = Str::of($name)->replace('[address]', '[city]');
                if ($cityName->is('address')) {
                    $cityName = 'city';
                }
            @endphp

            @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '') !!}>@endif
                @if ($label)<label for="{{ $options['id'] . '_' . 'city' }}">City{!! ((isset($options['required']) && $options['required']) ? config('form.required.helper') : '') !!}</label>@endif
                {{ Form::text($cityName, optional($value)->city, array_merge($options, ['id' => $options['id'] . '_' . 'city'])) }}
                @include('form::bs.errors', ['errorName' => $cityName])
            @if($formGroup)</div>@endif
        </div>
        <div class="col-sm">
            @php
                if (isset($options['wire:model'])) {
                    $options['wire:model'] = 'state';
                }
                elseif (isset($options['wire:model.defer'])) {
                    $options['wire:model.defer'] = str_replace('_city', '_state', $options['wire:model.defer']);
                }
                elseif (isset($options['wire:model.lazy'])) {
                    $options['wire:model.lazy'] = str_replace('_city', '_state', $options['wire:model.lazy']);
                }

                $stateName = Str::of($name)->replace('[address]', '[state]');
                if ($stateName->is('address')) {
                    $stateName = 'state';
                }
            @endphp
            @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '')  !!}>@endif
                @if ($label)<label for="{{ $options['id'] . '_' . 'state' }}">State{!! ((isset($options['required']) && $options['required']) ? config('form.required.helper') : '') !!}</label>@endif
                @if ($states)
                {{ Form::select($stateName, $states, optional($value)->state, array_merge($options, ['placeholder' => '', 'id' => $options['id'] . '_' . 'state'])) }}
                @else
                {{ Form::text($stateName, optional($value)->state, array_merge($options, ['id' => $options['id'] . '_' . 'state'])) }}
                @endif
                @include('form::bs.errors', ['errorName' => $stateName])
            @if($formGroup)</div>@endif
        </div>
        <div class="col-sm">
            @php
                if (isset($options['wire:model'])) {
                    $options['wire:model'] = 'zip';
                }
                elseif (isset($options['wire:model.defer'])) {
                    $options['wire:model.defer'] = str_replace('_state', '_zip', $options['wire:model.defer']);
                }
                elseif (isset($options['wire:model.lazy'])) {
                    $options['wire:model.lazy'] = str_replace('_state', '_zip', $options['wire:model.lazy']);
                }

                $zipName = Str::of($name)->replace('[address]', '[zip]');
                if ($zipName->is('address')) {
                    $zipName = 'zip';
                }
            @endphp
            @if($formGroup)<div {!! ((isset($groupClass)) ? 'class="' . $groupClass . '"' : '') !!}>@endif
                @if ($label !== false)<label for="{{ $options['id'] . '_' . 'zip' }}">Zip{!! ((isset($options['required']) && $options['required']) ? config('form.required.helper') : '') !!}</label>@endif
                {{ Form::text($zipName, optional($value)->zip, array_merge($options, ['id' => $options['id'] . '_' . 'zip'])) }}
                @include('form::bs.errors', ['errorName' => $zipName])
            @if($formGroup)</div>@endif
        </div>
    </div>

    {{ $after }}
@overwrite

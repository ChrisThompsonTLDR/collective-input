<?php
return [
    'jquery' => '',

    'after-scripts' => 'after-scripts',

    'after-styles' => 'after-styles',

    'dusk' => env('app.env') !== 'production', // whether or not to display dusk selectors: https://laravel.com/docs/7.x/dusk#dusk-selectors

    'tailwind' => [
        'label' => [
            'class' => 'block text-sm font-medium leading-5 text-gray-700',
            'wrapper' => null,
        ],
        'input' => [
            'class'   => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 text-gray-900',
            'wrapper' => 'mt-1 rounded-md shadow-sm',
        ],
        'invalid' => [
            'class' => 'border-red-500'
        ],
        'helper' => [
            'class' => 'text-xs text-gray-400'
        ]
    ]
];

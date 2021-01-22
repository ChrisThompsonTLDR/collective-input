<?php
return [
    'jquery' => '',

    'after-scripts' => 'after-scripts',

    'after-styles' => 'after-styles',

    'dusk' => env('app.env') !== 'production', // whether or not to display dusk selectors: https://laravel.com/docs/7.x/dusk#dusk-selectors

    'required' => [
        'class' => 'required',
        'helper' => '<sup>*</sup>',
    ],
];

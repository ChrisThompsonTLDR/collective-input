<?php

namespace Christhompsontldr\CollectiveInput;

use Blade;
use Form;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot() {
        Form::component('bs', 'collective::input', ['name', 'type', 'options']);

        //  https://stackoverflow.com/questions/38135455/how-to-have-one-time-push-in-laravel-blade
        Blade::directive('pushonce', function ($expression) {
            $domain = explode(':', trim(substr($expression, 1, -1)));
            $push_name = $domain[0];
            $push_sub = isset($domain[1]) ? $domain[1] : '';
            $isDisplayed = '__pushonce_' . md5($push_name.'_'.$push_sub);
            return "<?php if(!isset(\$__env->{$isDisplayed})): \$__env->{$isDisplayed} = true; \$__env->startPush('{$push_name}'); ?>";
        });

        Blade::directive('endpushonce', function ($expression) {
            return '<?php $__env->stopPush(); endif; ?>';
        });

        //  hintpath views
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'collective');

        $this->publishes([
            realpath(__DIR__ . '/resources/views') => resource_path('views/vendor/collective'),
        ]);
    }
}
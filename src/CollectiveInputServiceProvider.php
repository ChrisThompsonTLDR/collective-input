<?php

namespace Christhompsontldr\CollectiveInput;

use Christhompsontldr\CollectiveInput\View\Components\Bs;
use Christhompsontldr\CollectiveInput\View\Components\Tw;
use Form;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CollectiveInputServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewComponentsAs('form', [Bs::class]);

        $this->loadViewComponentsAs('form', [Tw::class]);

        // maintain backwards compatability with Form::bs()
        Form::macro('bs', function ($name, $type = 'text',  $options = null) {
            // shorthand was used
            if (is_array($type) && is_null($options)) {
                $options = $type;
                $type    = 'text';
            }

            return (new Bs($name, $type, $options))->render(true);
        });

        //  https://stackoverflow.com/questions/38135455/how-to-have-one-time-push-in-laravel-blade
        Blade::directive('pushonce', function ($expression) {
            $expression = str_replace(['after-scripts', 'after-styles'], [config('form.after-scripts'), config('form.after-styles')], $expression);

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
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'form');

        // publish views
        $this->publishes([dirname(__DIR__) . '/resources/views' => resource_path('views/vendor/form')]);

        $this->publishes([dirname(__DIR__) . '/config/form.php' => config_path('form.php')]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/form.php', 'form');
    }
}

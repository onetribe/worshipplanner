<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'sets._form_fields', 'App\Http\ViewComposers\SetsFormFieldsComposer'
        );
        View::composer(
            'authors._select', 'App\Http\ViewComposers\AuthorSelectComposer'
        );
        View::composer(
            'songs._select_options', 'App\Http\ViewComposers\SongSelectComposer'
        );

//        // Using Closure based composers...
//        View::composer('dashboard', function ($view) {
//            //
//        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
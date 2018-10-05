<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        View::composer('*', function($view) {
            $year = \App\Year::where('is_current', '1')->first();
            //$camper = \App\Camper::where('email', Auth::user()->email)->first();
            $view->with('year', $year);
            //$view->with('logged_in', $camper);
            //$view->with('registered', \App\Yearattending::where('camperid', $camper->id)->where('year', $year->year)->first());
        });

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
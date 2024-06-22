<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Company;
use App\Models\ExtraSettings;
use App\Models\Information;
use App\Models\Screen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $informations = Information::first();
        View::share('informations', $informations);

        $companies = Company::all();
        View::share('companies', $companies);

        $system = Admin::FindOrFail(1);
        View::share('system', $system);

        View::composer('*', function ($view) {
            if (Auth::check()) {
                if (Auth::guard('client-web')->check()) {
                    $user = Auth::user();
                    $package = $user->company->subscription->type->package;
                    View::share('user', $user);
                    View::share('package', $package);
                    $company_id = Auth::user()->company_id;
                    $auth_id = Auth::user()->id;
                    $client = Client::FindOrFail($auth_id);
                    $branch_id = $client->branch_id;
                    if ($branch_id != "") {
                        $screen_settings = Screen::where('company_id', $company_id)
                            ->where('branch_id', $branch_id)
                            ->first();
                    } else {
                        $screen_settings = Screen::where('company_id', $company_id)
                            ->first();
                    }
                    View::share('screen_settings', $screen_settings);
                    $extra_settings = ExtraSettings::where('company_id', $company_id)
                        ->first();
                    View::share('extra', $extra_settings);

                }
            }
        });
    }
}

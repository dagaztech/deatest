<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use App\Models\Passport\AuthCode;
use App\Models\Passport\Client;
use App\Models\Passport\PersonalAccessClient;
use App\Models\Passport\RefreshToken;
use App\Models\Passport\Token;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        // Schema::defaultStringLength(191);
        Passport::loadKeysFrom(__DIR__.'/../');
        

        //Paginator::useBootstrapFive();
        //Passport::hashClientSecrets();
        //Passport::useTokenModel(Token::class);
        //Passport::useRefreshTokenModel(RefreshToken::class);
        //Passport::useAuthCodeModel(AuthCode::class);
        //Passport::useClientModel(Client::class);
        //Passport::usePersonalAccessClientModel(PersonalAccessClient::class);


        // if (env('APP_ENV') !== 'local') {
           //\URL::forceScheme('https');
           \URL::forceScheme('http');
        // }

    
    }
}
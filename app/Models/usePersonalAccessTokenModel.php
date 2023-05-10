<?php

use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
 
/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot()
{
    Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('image_url', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/\.(jpg|jpeg|png)$/i', $value);
        });

        Validator::extend('image_mime', function ($attribute, $value, $parameters, $validator) {
            $allowedMimes = ['image/jpeg', 'image/png'];
            $urlParts = parse_url($value);
            $imageUrl = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'];
            try {
                $headers = get_headers($imageUrl, 1);
                if (isset($headers['Content-Type'])) {
                    $contentType = is_array($headers['Content-Type']) ? end($headers['Content-Type']) : $headers['Content-Type'];
                    return in_array($contentType, $allowedMimes);
                }
            } catch (\Exception $e) {
                return false;
            }
            return false;
        });

    }
}

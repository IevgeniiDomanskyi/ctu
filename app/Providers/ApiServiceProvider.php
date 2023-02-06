<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiServiceProvider extends ServiceProvider
{
    protected $code = 200;
    protected $messages = [];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('result', function ($data = [], $message = '') {
            $messages = response()->messages();
            if (!empty($messages)) {
                $data = null;
            }

            if (empty($messages) && !empty($message)) {
                response()->message($message, 'success');
                $messages = response()->messages();
            }

            $version = config('version.current');

            $response = compact('data', 'messages', 'version');
            return response()->json($response, response()->status());
        });

        Response::macro('missingModelBehavior', function () {
            response()->message(__('The URL is incorrect'), 'error', 404);

            $data = null;
            $messages = response()->messages();
            $version = config('version.current');
            $response = compact('data', 'messages', 'version');
            return response()->json($response, response()->status());
        });

        Response::macro('message', function ($key, $type = 'error', $code = 200) {
            if (empty($this->messages)) {
                $this->messages = [];
            }

            $replace = [];
            if (is_array($key)) {
                $replace = $key[1];
                $key = $key[0];
            }

            $this->messages[] = [
                'text' => __($key, $replace),
                'type' => $type,
            ];

            $this->code = $code;
        });

        Response::macro('messages', function () {
            if (empty($this->messages)) {
                $this->messages = [];
            }

            return $this->messages;
        });

        Response::macro('status', function () {
            if (empty($this->code)) {
                $this->code = 200;
            }

            return $this->code;
        });
    }
}
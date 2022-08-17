<?php

namespace App\Services\Traits;

use App\Tenant\Models\Attachment;
use Illuminate\Cache\RateLimiter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

trait TAttemptsThrottle
{
    /**
     * The throttle key.
     *
     * @var string
     */
    protected $key ;

    /**
     * The maximum number of attempts a user can perform.
     *
     * @var int
     */
    protected $maxAttempts = 1;

    /**
     * The amount of minutes to restrict the requests by.
     *
     * @var int
     */
    protected $decayInMinutes = 10;

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @return bool
     */
    protected function hasTooManyAttempts()
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey(), $this->maxAttempts
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @return void
     */
    protected function incrementAttempts()
    {
        $this->limiter()->hit(
            $this->throttleKey(), $this->decayInMinutes * 60
        );
    }

    /**
     * Get the throttle key for the given request.
     *
     * @return string
     */
    protected function throttleKey()
    {
        return $this->key . '|' . request()->ip();
    }

    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the current HTTP request.
     *
     * @return \Illuminate\Http\Request
     */
    protected function request()
    {
        return app(Request::class);
    }
}

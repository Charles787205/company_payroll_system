<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Get the current number of attempts
        $attempts = RateLimiter::attempts($this->throttleKey());
        
        // Define our tiered lockout system
        if ($attempts >= 3 && $attempts < 4) {
            // After 3 failed attempts - 30 seconds lockout
            $this->checkRateLimit(1, 30);
        } elseif ($attempts >= 4 && $attempts < 5) {
            // After 4 failed attempts - 1 minute lockout
            $this->checkRateLimit(1, 60);
        } elseif ($attempts >= 5) {
            // After 5 failed attempts - 30 minutes lockout
            $this->checkRateLimit(1, 1800);
        }
    }

    /**
     * Check if the request is rate limited and throw an exception if it is.
     *
     * @param int $maxAttempts
     * @param int $decaySeconds
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkRateLimit(int $maxAttempts, int $decaySeconds): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $maxAttempts)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $message = '';
        if ($decaySeconds == 30) {
            $message = 'Too many login attempts. Please wait 30 seconds.';
        } elseif ($decaySeconds == 60) {
            $message = 'Too many login attempts. Please wait 1 minute.';
        } elseif ($decaySeconds == 1800) {
            $message = 'Too many login attempts. Please wait 30 minutes.';
        } else {
            $message = trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]);
        }

        throw ValidationException::withMessages([
            'email' => $message,
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}

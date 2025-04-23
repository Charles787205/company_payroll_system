<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}"
        class="bg-gradient-to-r bg-gray-200 border my-auto p-6 w-[400px] h-[500px] flex flex-col rounded-lg shadow-lg shadow-neutral-200 ">
        @csrf
        <div class="flex justify-center mb-4">
            <h1 class="font-bold text-4xl text-neutral-900 text-center">Company Payroll System</h1>
        </div>
        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class=" font-semibold" />

            <x-text-input id="email" class="block mt-1 w-full bg-gray-100 border border-black" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-yellow-200" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class=" font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-100 border border-black" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-yellow-200" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-800   shadow-sm " name="remember">
                <span class="ms-2 text-sm ">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-auto">
            @if (Route::has('password.request'))
            <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
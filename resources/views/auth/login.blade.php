<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-white">Welcome Back!</h2>
            <p class="text-sm text-gray-400">Please sign in to your account</p>
        </div>

        <div>
            {{-- Ubah warna label jadi text-gray-300 --}}
            <x-input-label for="email" :value="__('Email')" class="text-indigo-500" />
            
            {{-- Pastikan input teksnya putih dan background gelap --}}
            <x-text-input id="email" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" 
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-indigo-500" />

            <x-text-input id="password" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-900 border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                {{-- Link Forgot Password dibuat lebih terang --}}
                <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 font-bold px-6 py-2">
                {{ __('LOG IN') }}
            </x-primary-button>
        </div>
        
        <div class="mt-8 text-center text-sm text-gray-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-indigo-400 hover:text-indigo-300 hover:underline">Register here</a>
        </div>
    </form>
</x-guest-layout>
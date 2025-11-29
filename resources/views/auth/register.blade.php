<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-white">Create Account</h2>
            <p class="text-sm text-gray-400">Join the creative revolution at AdoArt</p>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-indigo-500" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-indigo-500" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('I want to register as...')" class="text-indigo-500 mb-2" />
            
            <div class="grid grid-cols-2 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="member" class="peer sr-only" checked>
                    <div class="rounded-lg border border-gray-600 bg-gray-800 p-4 text-center hover:bg-gray-700 peer-checked:border-indigo-500 peer-checked:bg-indigo-900/30 peer-checked:text-indigo-400 transition-all">
                        <div class="font-bold text-gray-200 peer-checked:text-indigo-400">Member</div>
                        <div class="text-xs text-gray-500 mt-1">I want to showcase art</div>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="curator" class="peer sr-only">
                    <div class="rounded-lg border border-gray-600 bg-gray-800 p-4 text-center hover:bg-gray-700 peer-checked:border-indigo-500 peer-checked:bg-indigo-900/30 peer-checked:text-indigo-400 transition-all">
                        <div class="font-bold text-gray-200 peer-checked:text-indigo-400">Curator</div>
                        <div class="text-xs text-gray-500 mt-1">I want to host challenges</div>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-indigo-500" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-indigo-500" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 font-bold px-6 py-2">
                {{ __('REGISTER') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
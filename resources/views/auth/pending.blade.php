<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Account Under Review</h2>
        <p>
            Thanks for signing up as a Curator on AdoArt! Your account is currently <strong>pending approval</strong>.
            Our admins are reviewing your request. You will be able to access the Curator Dashboard once approved.
        </p>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
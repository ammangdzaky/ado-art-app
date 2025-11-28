<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200">User Management</h3>
                    <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">{{ $pendingCurators }}</p>
                    <p class="text-sm text-gray-500">Pending Curators</p>
                    <a href="{{ route('admin.users') }}" class="mt-4 inline-block text-blue-600 hover:underline">Manage Users &rarr;</a>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-red-500">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200">Moderation Queue</h3>
                    <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">{{ $pendingReports }}</p>
                    <p class="text-sm text-gray-500">Pending Reports</p>
                    <a href="{{ route('admin.reports') }}" class="mt-4 inline-block text-red-600 hover:underline">Review Reports &rarr;</a>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-green-500">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200">Categories</h3>
                    <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">Master</p>
                    <p class="text-sm text-gray-500">Manage Categories</p>
                    <a href="{{ route('categories.index') }}" class="mt-4 inline-block text-green-600 hover:underline">Edit Categories &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
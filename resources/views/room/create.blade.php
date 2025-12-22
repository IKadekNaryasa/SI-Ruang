<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('rooms.index') }}"
                class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Room') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Room Information') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Fill in the details below to create a new room.') }}
                        </p>
                    </div>

                    <x-room-create-form :action="route('rooms.store')" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
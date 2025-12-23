<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Bidang Management') }}
            </h2>
            <a href="{{ route('bidang.create') }}"
                class="inline-flex items-center px-2 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('+ New Bidang') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 border border-red-400 text-red-700 dark:bg-red-900 dark:border-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                            <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">Total Bidang</div>
                            <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $bidangs->count() }}</div>
                        </div>
                    </div>
                    <x-bidang-data-table :bidangs="$bidangs" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@props(['bidang' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="w-full mx-auto">
    @csrf
    @if($method !== 'POST')
    @method($method)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
        <div>
            <x-input-label for="code" :value="__('Bidang Code')" />
            <x-text-input
                id="code"
                class="block mt-1 w-full"
                type="text"
                name="code"
                :value="old('code', $bidang?->code)"
                required
                autofocus
                placeholder="e.g., BID-I" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
    </div>
    <div class="mb-6">
        <x-input-label for="name" :value="__('Bidang Name')" />
        <x-text-input
            id="name"
            class="block mt-1 w-full"
            type="text"
            name="name"
            :value="old('name', $bidang?->name)"
            required
            placeholder="e.g., Bidang xxx" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>


    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('bidang.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Cancel') }}
        </a>

        <x-primary-button>
            {{ $bidang ? __('Update Bidang') : __('Create Bidang') }}
        </x-primary-button>
    </div>
</form>
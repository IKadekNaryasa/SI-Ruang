@props(['room' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="w-full mx-auto">
    @csrf
    @if($method !== 'POST')
    @method($method)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <x-input-label for="code" :value="__('Room Code')" />
            <x-text-input
                id="code"
                class="block mt-1 w-full"
                type="text"
                name="code"
                :value="old('code', $room?->code)"
                required
                autofocus
                placeholder="e.g., R-001" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select
                id="status"
                name="status"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="active" {{ old('status', $room?->status ?? 'active') === 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ old('status', $room?->status) === 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    </div>

    <div class="mb-6">
        <x-input-label for="name" :value="__('Room Name')" />
        <x-text-input
            id="name"
            class="block mt-1 w-full"
            type="text"
            name="name"
            :value="old('name', $room?->name)"
            required
            placeholder="e.g., Meeting Room A" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('rooms.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Cancel') }}
        </a>

        <x-primary-button>
            {{ $room ? __('Update Room') : __('Create Room') }}
        </x-primary-button>
    </div>
</form>
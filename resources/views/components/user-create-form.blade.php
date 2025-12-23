@props(['user' => null, 'action', 'method' => 'POST', 'bidangs' => []])

<form method="POST" action="{{ $action }}" class="w-full mx-auto">
    @csrf
    @if($method !== 'POST')
    @method($method)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name', $user?->name)"
                required
                autofocus
                placeholder="e.g., John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email', $user?->email)"
                required
                placeholder="e.g., john@siruang.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select
                id="role"
                name="role"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required>
                <option value="">{{ __('Select Role') }}</option>
                <option value="admin" {{ old('role', $user?->role) === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
                <option value="operator" {{ old('role', $user?->role) === 'operator' ? 'selected' : '' }}>
                    Operator
                </option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="bidang_id" :value="__('Bidang')" />
            <select
                id="bidang_id"
                name="bidang_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required>
                <option value="">{{ __('Select Bidang') }}</option>
                @foreach($bidangs as $bidang)
                <option value="{{ $bidang->id }}" {{ old('bidang_id', $user?->bidang_id) == $bidang->id ? 'selected' : '' }}>
                    {{ $bidang->name }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('bidang_id')" class="mt-2" />
        </div>
    </div>
    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('user.index') }}"
            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Cancel') }}
        </a>

        <x-primary-button>
            {{ $user ? __('Update User') : __('Create User') }}
        </x-primary-button>
    </div>
</form>
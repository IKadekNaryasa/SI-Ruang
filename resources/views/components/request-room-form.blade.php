@props(['rooms' => []])

<form action="{{ route('opt.request-store') }}" method="POST" class="w-full mx-auto mb-6" id="requestForm">
    @csrf

    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Request Ruangan
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
            <x-input-label for="room_id" :value="__('Ruangan')" />
            <select
                id="room_id"
                name="room_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required>
                <option value="">{{ __('Pilih Ruangan') }}</option>
                @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                    {{ $room->name }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="date" :value="__('Tanggal')" />
            <x-text-input
                id="date"
                class="block mt-1 w-full"
                type="date"
                name="date"
                :value="old('date')"
                required />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>

        <div id="timeRangeContainer" style="display: none;">
            <x-input-label :value="__('Waktu')" />
            <div class="grid grid-cols-2 gap-2 mt-1">
                <x-text-input
                    id="start_time"
                    type="time"
                    name="start_time"
                    :value="old('start_time')"
                    placeholder="Mulai"
                    required />
                <x-text-input
                    id="end_time"
                    type="time"
                    name="end_time"
                    :value="old('end_time')"
                    placeholder="Selesai"
                    required />
            </div>
            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm transition duration-150 ease-in-out">
            Request Ruangan
        </button>
    </div>
</form>
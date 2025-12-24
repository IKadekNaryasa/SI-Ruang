<x-operator-layout>
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
                    <!-- Form Request -->
                    <x-request-room-form :rooms="$rooms" />

                    <!-- Divider -->
                    <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="hidden text-center py-8">
                        <svg class="animate-spin h-8 w-8 mx-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Memuat data...</p>
                    </div>

                    <!-- Header Jadwal -->
                    <div id="scheduleHeader" class="hidden mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Jadwal Booking: <span id="roomName" class="text-blue-600"></span>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400" id="selectedDate"></p>
                    </div>

                    <!-- Data Booking -->
                    <div id="bookingList" class="hidden">
                        <div id="bookingContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="hidden text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2">Tidak ada booking pada tanggal ini</p>
                    </div>

                    <!-- Initial State -->
                    <div id="initialState" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2">Pilih ruangan dan tanggal untuk melihat jadwal booking</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const roomSelect = document.getElementById('room_id');
        const dateInput = document.getElementById('date');
        const timeRangeContainer = document.getElementById('timeRangeContainer');

        const loadingIndicator = document.getElementById('loadingIndicator');
        const scheduleHeader = document.getElementById('scheduleHeader');
        const bookingList = document.getElementById('bookingList');
        const emptyState = document.getElementById('emptyState');
        const initialState = document.getElementById('initialState');
        const bookingContainer = document.getElementById('bookingContainer');
        const roomName = document.getElementById('roomName');
        const selectedDate = document.getElementById('selectedDate');

        dateInput.addEventListener('change', function() {
            const room = roomSelect.value;
            const date = this.value;

            if (room && date) {
                checkRoom(room, date);
                timeRangeContainer.style.display = 'block';
            }
        });

        roomSelect.addEventListener('change', function() {
            const room = this.value;
            const date = dateInput.value;

            if (room && date) {
                checkRoom(room, date);
            }
        });

        function checkRoom(room_id, date) {
            loadingIndicator.classList.remove('hidden');
            scheduleHeader.classList.add('hidden');
            bookingList.classList.add('hidden');
            emptyState.classList.add('hidden');
            initialState.classList.add('hidden');

            axios.post('{{ route("opt.room-check") }}', {
                    room_id: room_id,
                    date: date
                })
                .then(response => {
                    const data = response.data;
                    loadingIndicator.classList.add('hidden');

                    if (data.success) {
                        roomName.textContent = data.room_name;
                        selectedDate.textContent = data.date;
                        scheduleHeader.classList.remove('hidden');

                        if (data.bookings.length > 0) {
                            displayBookings(data.bookings);
                            bookingList.classList.remove('hidden');
                        } else {
                            emptyState.classList.remove('hidden');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingIndicator.classList.add('hidden');

                    if (error.response) {
                        console.error('Response data:', error.response.data);
                        console.error('Response status:', error.response.status);
                        alert('Error: ' + (error.response.data.message || 'Terjadi kesalahan'));
                    } else {
                        alert('Terjadi kesalahan: ' + error.message);
                    }
                });
        }

        function displayBookings(bookings) {
            bookingContainer.innerHTML = '';

            bookings.forEach(booking => {
                const borderColor = booking.is_mine ?
                    'border-blue-500 bg-blue-50 dark:bg-blue-900/20' :
                    'border-gray-200 bg-gray-50 dark:bg-gray-900/20';

                const card = `
                    <div class="rounded-lg p-4 border-2 ${borderColor}">
                        <div class="mb-2">
                            <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                ${booking.bidang_name}
                                ${booking.is_mine ? '<span class="text-xs text-blue-600 dark:text-blue-400">(Anda)</span>' : ''}
                            </div>
                        </div>
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Waktu:</span> ${booking.start} - ${booking.end}
                        </div>
                    </div>
                `;

                bookingContainer.innerHTML += card;
            });
        }
    </script>
    @endpush
</x-operator-layout>
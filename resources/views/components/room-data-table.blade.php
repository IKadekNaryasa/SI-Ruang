@props(['rooms'])

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Code
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                @if (auth()->user()->isAdmin())
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Actions
                </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $index => $room)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
                    {{ $index + 1 }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                    {{ $room->code }}
                </td>
                <td class="px-6 py-4">
                    {{ $room->name }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $room->status === 'active' 
                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' 
                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' 
                            }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </td>
                @if (auth()->user()->isAdmin())
                <td class="px-6 py-4">
                    {{ $room->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('rooms.edit', $room->id) }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this room?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No rooms data available.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
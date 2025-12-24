<?php

namespace App\Http\Controllers\Operator;

use App\Models\Room;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RequestRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('operator.room.request', compact('rooms'));
    }

    public function roomCheck(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
        ]);

        try {
            $usages = Usage::with(['bidang', 'room'])
                ->where('room_id', $validated['room_id'])
                ->whereDate('date', $validated['date'])
                ->orderBy('start', 'asc')
                ->get();

            $bookings = $usages->map(function ($usage) {
                return [
                    'id' => $usage->id,
                    'bidang_name' => $usage->bidang->name ?? 'Unknown',
                    'start' => \Carbon\Carbon::parse($usage->start)->format('H:i'),
                    'end' => \Carbon\Carbon::parse($usage->end)->format('H:i'),
                    'date' => \Carbon\Carbon::parse($usage->date)->format('d M Y'),
                    'is_mine' => $usage->bidang_id === Auth::user()->bidang_id,
                ];
            });

            $room = Room::find($validated['room_id']);

            return response()->json([
                'success' => true,
                'bookings' => $bookings,
                'room_name' => $room->name ?? 'Unknown',
                'date' => Carbon::parse($validated['date'])->translatedFormat('d F Y'),
                'total' => $bookings->count(),
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $isBooked = Usage::where('room_id', $validated['room_id'])
            ->where('date', $validated['date'])
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start', '<=', $validated['start_time'])
                        ->where('end', '>', $validated['start_time']);
                })
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start', '<', $validated['end_time'])
                            ->where('end', '>=', $validated['end_time']);
                    })
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start', '>=', $validated['start_time'])
                            ->where('end', '<=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($isBooked) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ruangan sudah dibooking pada waktu tersebut. Silakan pilih waktu lain.');
        }

        Usage::create([
            'room_id' => $validated['room_id'],
            'bidang_id' => Auth::user()->bidang_id,
            'date' => $validated['date'],
            'start' => $validated['start_time'],
            'end' => $validated['end_time'],
            'status' => 'pending',
        ]);

        return redirect()->route('opt.room-request')
            ->with('success', 'Request ruangan berhasil dibuat');
    }
}

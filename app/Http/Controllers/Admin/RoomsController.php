<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:rooms,code',
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            Room::create($validated);
            return redirect()->route('rooms.index')->with('success', 'Room Created Successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed to Create new room. Please try again!'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:rooms,code' . $room->id,
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $room->update($validated);
            return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to update room. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();

            return redirect()->route('rooms.index')
                ->with('success', 'Room deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('room.index')
                ->with('error', 'Failed to delete room. Room may be in use.');
        }
    }
}

<?php

namespace App\Http\Controllers\Operator;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('operator.room.index', compact('rooms'));
    }
}

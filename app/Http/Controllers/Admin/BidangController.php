<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Exception;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bidangs = Bidang::all();
        return view('bidang.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bidang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:bidangs,code',
            'name' => 'required|string|max:255|unique:bidangs,name'
        ]);

        try {
            Bidang::create($validated);
            return redirect()->route('bidang.index')->with('success', 'Bidang created successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed created new bidang. Please try again!'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        return view('bidang.edit', compact('bidang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:bidangs,code' . $bidang->id,
            'name' => 'required|string|max:255|unique:bidangs,name' . $bidang->id
        ]);

        try {
            $bidang->update($validated);
            return redirect()->route('bidang.index')->with('success', 'Bidang updated successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed update bidang. Please try again!'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        try {
            $bidang->delete();
            return back()->with('success', 'Bidang deleted successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed deleted bidang. Please try again!']);
        }
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Models\Room;
use App\Exports\RoomExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('client.assets.rooms.index', compact('rooms'));
    }
    public function exportExcel()
    {
        return Excel::download(new RoomExport, 'rooms.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestRoome = Room::orderBy('code', 'desc')->first();
        $newCode = $latestRoome ? sprintf('%03d', $latestRoome->code + 1) : '001';

        return view('client.assets.rooms.create', compact('newCode'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description_ar' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'code' => 'required|string|max:3',
        ]);

        Room::create($request->all());
        return redirect()->route('rooms.index')->with('success', 'Roome created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('Room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'code' => 'required|string|max:3',
        ]);

        $room->update($request->all());
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}

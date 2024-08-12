<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('type')->latest('id')->paginate('2');
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::pluck('name', 'id');
        return view('rooms.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = [
                    'name' => $request->name,
                    'describe' => $request->describe,
                    'type_id' => $request->type_id,
                ];

                if ($request->hasFile('image')) {
                    $data['image'] = Storage::put('rooms', $request->file('image'));
                }

                Room::create($data);
            });
            return redirect()->route('rooms.index')->with('success', 'Thao tác thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
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
        $room->load('type');
        $types = Type::pluck('name', 'id');
        return view('rooms.edit', compact('room', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        try {
            DB::transaction(function () use ($request, $room) {
                $data = [
                    'name' => $request->name,
                    'describe' => $request->describe,
                    'type_id' => $request->type_id,
                    'is_active' => $request->is_active,
                ];
                $room->update($data);
                if ($request->hasFile('image')) {
                    $data['image'] = Storage::put('rooms', $request->file('image'));
                }
            });


            return redirect()->route('rooms.index')->with('success', 'Thao tác thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            DB::transaction(function () use ( $room) {
                $room->delete();
                if($room->image && Storage::exists($room->image)){
                    Storage::delete($room->image);
                }
            });


            return redirect()->route('rooms.index')->with('success', 'Thao tác thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
}

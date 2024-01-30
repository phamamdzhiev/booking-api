<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRoomRequest;
use App\Http\Resources\V1\RoomCollection;
use App\Http\Resources\V1\RoomResource;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return new RoomCollection(Room::all());
    }

    public function store(StoreRoomRequest $request): RoomResource
    {
        return new RoomResource(Room::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room): RoomResource
    {
        return new RoomResource($room);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Rooms;
use App\Http\Controllers\RoomTypeController;

use Illuminate\Support\Facades\Log;

class RoomsController extends Controller
{
    public function assignRoomTypes(RoomType $roomType)
    {
        Rooms::whereNull('id_room_type')
            ->limit($roomType->number_of_room)
            ->update(['id_room_type' => $roomType->id_room_type]);

        Log::info('Room types have been successfully assigned to the rooms.');
    }

    public function countRoom()
    {
        $count = Rooms::whereNull('id_room_type')->count();
        Log::info('Room count:', ['count' => $count]);

        return $count;
    }

    public function isFull($id){
        $roomType = RoomType::find($id);
        $roomCount = Rooms::where('id_room_type', $id)
            ->where ('status', 0)
            ->count();
        
        if($roomCount == 0){
            return false;
        }else{
            return true;
        }
    }

    public function destroyRoomTypeId($id)
    {
        $updated = Rooms::where('id_room_type', $id)->update(['id_room_type' => null, 'status' => 0]);

        if ($updated) {
            return response()->json(['message' => 'Room type has been set to null for the specified rooms.'], 200);
        }

        return response()->json(['message' => 'No rooms found with the specified room type.'], 404);
    }

    public function changeStatus($id){
        $room = Rooms::find($id);
        $room->update([
            'status' => 1,
        ]);

        return response()->json(['message' => 'Room status has been successfully updated.'], 200);
    }



}

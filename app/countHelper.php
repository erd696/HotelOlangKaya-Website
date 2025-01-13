<?php

use App\Models\Rooms;

if (!function_exists('isFull')) {
    function isFull($id)
    {
        $roomCount = Rooms::where('id_room_type', $id)
            ->where('status', 0)
            ->count();
        
        if($roomCount == 0){
            return -1;
        }

        return 1;
    }
}

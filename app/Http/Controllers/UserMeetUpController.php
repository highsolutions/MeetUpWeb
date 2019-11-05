<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetUp\SignUpRequest;
use App\Models\MeetUp;

class UserMeetUpController
{
    public function create(MeetUp $meetUp, SignUpRequest $request)
    {
        $user = $this->userRepository->findOrFail($request->get('user_id'));

        if ($meetUp->sumSoldTickets + $request->get('quantity') > $meetUp->capacity) {
            throw new \Exception('Too many tickets');
        }

        $user->meetUps()->attach($meetUp->id, ['quantity' => $request->get('quantity')]);

        return response()->json();
    }
}

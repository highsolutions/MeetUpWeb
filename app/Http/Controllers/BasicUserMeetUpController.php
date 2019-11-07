<?php

namespace App\Http\Controllers;

use App\Models\MeetUp;
use \Illuminate\Http\Request;

class UserMeetUpController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $meetUpId, Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required|int',
        ]);

        $meetUp = MeetUp::findOrFail($meetUpId);

        if ($meetUp->sumSoldTickets + $request->get('quantity') > $meetUp->capacity) {
            throw new \Exception('Too many tickets');
        }

        auth()
            ->user()
            ->meetUps()
            ->attach($meetUp->id, ['quantity' => $request->get('quantity')]);

        return response()->json($meetUp->toArray());
    }
}

<?php

namespace App\Http\Controllers;

use App\MeetUp;
use App\User;
use Illuminate\Http\Request;

class MeetUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meetUps = MeetUp::all();

        return response()->json($meetUps->toArray());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:8',
            'starts_at' => 'required|datetime',
            'ends_at' => 'required|datetime|after:starts_at',
            'capacity' => 'required|int',
        ]);

        $meetUp = new MeetUp($request->all());

        return response()->json($meetUp->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MeetUp  $meetUp
     * @return \Illuminate\Http\Response
     */
    public function show(MeetUp $meetUp)
    {
        return response()->json($meetUp->toArray());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MeetUp  $meetUp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeetUp $meetUp)
    {
        $meetUp->update($request->all());

        return response()->json($meetUp->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MeetUp  $meetUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeetUp $meetUp)
    {
        $meetUp->delete();

        return response()->json();
    }

    public function signup($id, Request $rq)
    {
        $e = MeetUp::find($id);
        if ($e === null) {
            abort(404);
        }

        $this->validate($rq, [
            'user_id' => 'required|int',
            'quantity' => 'required|int',
        ]);

        $user = User::find($rq->get('user_id'));

        if ($user === null) {
            abort(404);
        }

        $s = 0;
        foreach ($e->users as $user) {
            $s += $user->pivot->quantity;
        }

        if ($s + $rq->get('quantity') > $e->capacity) {
            abort(403);
        }

        $user->meetUps()->attach($e->id, ['quantity' => $rq->get('quantity')]);

        return response()->json();
    }
}

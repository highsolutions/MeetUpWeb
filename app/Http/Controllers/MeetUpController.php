<?php

namespace App\Http\Controllers;

use App\Models\MeetUp;
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
}

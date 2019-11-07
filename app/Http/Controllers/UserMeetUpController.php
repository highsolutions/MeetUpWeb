<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetUp\SignUpRequest;
use App\Models\MeetUp;
use App\Repositories\MeetUpRepository;
use Symfony\Component\HttpFoundation\Response;

class UserMeetUpController
{
    public function __construct(MeetUpRepository $meetUpRepository)
    {
        $this->meetUpRepository = $meetUpRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\MeetUp $meetUp
     * @param \App\Http\Requests\MeetUp\SignUpRequest $request
     * @return \Illuminate\Http\Response|Exception
     */

    public function store(MeetUp $meetUp, SignUpRequest $request)
    {
        $quantity = $request->get('quantity');

        $this->meetUpRepository->canUserEnroll($meetUp, $quantity);

        $this->meetUpRepository->enrollUser(auth()->user(), 
                                            $quantity
                                        );

        return response()->json([
                                    'status' => true,
                                    'message' => 'Well done!',
                                ], Response::HTTP_CREATED);
    }
}

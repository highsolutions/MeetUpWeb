<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\MeetUp;

class MeetUpRepository
{
    public function canEnroll(MeetUp $meetUp, int $quantity)
    {
        $this->ifTooManyTickets($meetUp->sumSoldTickets, $quantity, $meetUp->capacity);
    }

    public function enrollUser(MeetUp $meetUp, User $user, int $quantity): void
    {
        $user->meetUps()->attach(
                                    $meetUp->id, 
                                    [
                                        'quantity' => $quantity
                                    ]
                                );
    }

    protected function ifTooManyTickets(int $sumSoldTickets, int $quantity, int $capacity)
    {
        if($sumSoldTickets + $quantity > $capacity) {
            throw \Exception('Too many tickets');
        }
    }
}
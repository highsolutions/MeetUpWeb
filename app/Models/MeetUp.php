<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MeetUp extends Model
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getSumSoldTicketsAttribute(): int
    {
        return $this->users->reduce(function (User $user) {
            $user->pivot->quantity;
        });
    }
}

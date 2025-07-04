<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Couple extends Model
{
    protected $fillable = [
        'user1_id',
        'user2_id',
        'partner_email_invite',
        'wedding_date',
    ];

    // Define the inverse relationship to the User who created it
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    // Define the inverse relationship to the Partner who joined
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
}

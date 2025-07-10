<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerInvite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'couple_id',
        'email',
        'token',
        'expires_at',
        'status',
    ];

    /**
     * Get the couple that this invitation belongs to.
     */
    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }
}

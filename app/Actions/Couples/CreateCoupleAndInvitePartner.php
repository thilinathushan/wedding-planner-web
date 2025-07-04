<?php

namespace App\Actions\Couples;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateCoupleAndInvitePartner
{
    public function handle(User $user, array $data)
    {
        // We wrap this in a transaction to ensure data integrity.
        // If sending the invite fails, the couple creation is rolled back.
        return DB::transaction(function () use ($user, $data) {
            $couple = $user->couple()->create([
                'wedding_date' => $data['wedding_date'],
                'partner_email_invite' => $data['partner_email'],
            ]);

            // TODO: Logic to send an invitation email to $data['partner_email']
            // We'll use Laravel's Mail & Notifications for this later.
            // For now, the core data is saved.

            return $couple;
        });
    }
}

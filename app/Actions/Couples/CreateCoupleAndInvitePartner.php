<?php

namespace App\Actions\Couples;

use App\Jobs\SendPartnerInvite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateCoupleAndInvitePartner
{
    public function handle(User $user, array $data)
    {
        // We wrap this in a transaction to ensure data integrity.
        // If sending the invite fails, the couple creation is rolled back.
        return DB::transaction(function () use ($user, $data) {
            // 1. Create the couple record
            $couple = $user->couple()->create([
                'wedding_date' => $data['wedding_date'],
                'partner_email_invite' => $data['partner_email'],
            ]);

            // 2. Create the secure invitation token
            $token = Str::random(40);

            // 3. Create the invitation record in the database
            $couple->invitation()->create([
                'couple_id' => $couple->id,
                'email' => $data['partner_email'],
                'token' => $token,
                'expires_at' => now()->addDays(3),
                'status' => 'pending',
            ]);

            // 4. Dispatch the job to send the email
            SendPartnerInvite::dispatch(
                $data['partner_email'], // The recipient's email
                $token,                 // The unique token for the URL
                $user->name             // The name of the person sending the invite
            );
        });
    }
}

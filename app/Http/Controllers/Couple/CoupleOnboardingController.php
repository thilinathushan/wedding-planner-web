<?php

namespace App\Http\Controllers\Couple;

use App\Actions\Couples\CreateCoupleAndInvitePartner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoupleOnboardingController extends Controller
{
    // Show the form to the user
    public function create()
    {
        return Inertia::render('Onboarding/CreateCouple');
    }

    // Store the submitted data
    public function store(Request $request, CreateCoupleAndInvitePartner $action)
    {
        dd($request->all());
        $validated = $request->validate([
            'wedding_date' => ['required', 'date', 'after:today'],
            'partner_email' => ['required', 'email'],
        ]);

        $action->handle($request->user(), $validated);

        // Redirect to the dashboard after successful submission
        return redirect()->route('dashboard')->with('success', 'Great! Your partner has been invited.');
    }
}

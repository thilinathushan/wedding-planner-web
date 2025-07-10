<?php

namespace App\Http\Controllers\Couple;

use App\Actions\Couples\CreateCoupleAndInvitePartner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        // Define the validation rules as before
        $rules = [
            'wedding_date' => ['required', 'date', 'after:today'],
            'partner_email' => [
                'required',
                'email',
                // Rule: The email cannot be the same as the authenticated user's email.
                Rule::notIn([Auth::user()->email]),
                // Rule: The email must not already exist in the 'users' table.
                Rule::unique('users', 'email'),
            ],
        ];

        // Define our user-friendly custom messages
        $messages = [
            // Custom message for the 'not_in' rule on the 'partner_email' field
            'partner_email.not_in' => 'You cannot invite yourself as a partner. Please enter a different email address.',

            // Custom message for the 'unique' rule on the 'partner_email' field
            'partner_email.unique' => 'This email address is already registered. Please enter a different email.',
        ];

        // Perform the validation with the rules and custom messages
        $validated = $request->validate($rules, $messages);

        $action->handle($request->user(), $validated);

        // Redirect to the dashboard after successful submission
        return redirect()->route('dashboard')->with('success', 'Great! Your partner has been invited.');
    }
}

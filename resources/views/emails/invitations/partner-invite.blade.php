<x-mail::message>
# You're Invited!

Hello,

**{{ $inviterName }}** has invited you to join them in planning your wedding on our platform.

Create your account and start your journey together by clicking the button below. This link is valid for 3 days.

<x-mail::button :url="$invitationUrl">
Accept Invitation
</x-mail::button>

If you were not expecting this invitation, you can safely ignore this email.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>

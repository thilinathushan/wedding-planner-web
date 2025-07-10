<?php

namespace App\Jobs;

use App\Mail\PartnerInvitationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPartnerInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $partnerEmail,
        public string $token,
        public string $inviterName
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // The job's only responsibility is to build and send the Mailable.
        Mail::to($this->partnerEmail)->send(new PartnerInvitationMail($this->token, $this->inviterName));
    }
}

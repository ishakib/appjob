<?php

namespace App\Emails;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @param Tenant $tenant
     */
    public function __construct(protected Tenant $tenant)
    {
    }

    /**
     * @return $this
     */
    public function build(): self
    {
    $contents = $this->getEmailContents();
    return $this->subject($contents['subject'])
        ->from(config('jobapp.email.from'))
        ->to($this->tenant->email)
        ->view('emails.admin-notification-on-new-application', compact('contents'))->mailer('smtp');
}

    protected function getEmailContents(): array
{
    return [
        'body' => config('jobapp.email.candidate_notification.body'),
        'subject' => config('jobapp.email.candidate_notification.subject')
    ];
}
}

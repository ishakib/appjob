<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Emails\CandidateNotificationEmail;
use App\Models\Tenant;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AfterApplicationNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;
    use Queueable;

    public int $timeout = 0;

    /**
     * @param Tenant $tenant
     */
    public function __construct(protected Tenant $tenant)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            Mail::send(new CandidateNotificationEmail($this->tenant));
        } catch (Exception $e) {
            logger("Error in AfterAuthenticateJob: " . $e->getMessage());
        }
    }
}

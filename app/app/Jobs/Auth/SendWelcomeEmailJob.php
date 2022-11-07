<?php

namespace App\Jobs\Auth;

use App\Http\Services\Auth\ActivationAccount\ActivationAccountServiceInterface;
use App\Http\Services\Auth\Register\RegisterServiceInterface;
use App\Models\User;
use App\Notifications\Auth\WelcomeVerificationEmailNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly User $user,
        private readonly array $data
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->user, new WelcomeVerificationEmailNotification(data: $this->data));
    }
}

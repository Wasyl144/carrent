<?php

namespace App\Listeners\Auth;

use App\Http\Services\Auth\ActivationAccount\ActivationAccountServiceInterface;
use Illuminate\Auth\Events\Registered;

class SendWelcomeEmailEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private readonly ActivationAccountServiceInterface $activationAccountService,
    )
    {
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->activationAccountService->sendActivationEmail($event->user);
    }
}

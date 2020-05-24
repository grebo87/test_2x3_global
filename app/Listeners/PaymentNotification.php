<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PaymentSaved;
use Illuminate\Support\Facades\Mail;
use App\Mail\Payment;

class PaymentNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserSavingEvent $event
     * @return mixed
     */
    public function handle(PaymentSaved $event)
    {
        Mail::to($event->payment->client)->queue(new Payment($event->payment->client));
    }
}

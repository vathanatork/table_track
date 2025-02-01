<?php

namespace App\Notifications;

use App\Models\EmailSetting;
use App\Models\GlobalSetting;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class BaseNotification extends Notification implements ShouldQueue
{

    use Queueable, Dispatchable;

    public function build()
    {
        $globalSetting = GlobalSetting::first();

        // Retrieve SMTP settings
        $smtpSetting = EmailSetting::first();

        // Initialize a mail message instance
        $build = (new MailMessage);

        // Set default reply name and email to SMTP settings
        $replyName = $companyName = $smtpSetting->mail_from_name;
        $replyEmail = $companyEmail = $smtpSetting->mail_from_email;

        // Set the application logo URL from the global settings
        Config::set('app.logo', $globalSetting->logoUrl);
        Config::set('app.name', $companyName);

        // Ensure that the company email and name are used if mail verification is successful
        $companyEmail = config('mail.verified') === true ? $companyEmail : $replyEmail;
//        $companyName = config('mail.verified') === true ? $companyName : $replyName;

        // Return the mail message with configured from and replyTo settings
        return $build->from($companyEmail, $replyName)->replyTo($replyEmail, $replyName);
    }

}

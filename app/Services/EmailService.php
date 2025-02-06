<?php

namespace App\Services;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send Email
     * @param array $attributes
     * @return void
     */
    public function send(array $attributes): ?object
    {
        $mailCredential = $this->credential();

        if ($mailCredential->status != "success") {
            return $mailCredential;
        }

        try {
            Mail::to($attributes['to'])->send(new SendEmail(
                $attributes['title'],
                $attributes['subject'],
                $attributes['htmlData']
            ));
            return (object) ['status' => 'success'];
        } catch (\Throwable $th) {
            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

    private function credential(): ?object
    {
        $mailMailer      = env('MAIL_MAILER') ?? null;
        $mailHost        = env('MAIL_HOST') ?? null;
        $mailPort        = env('MAIL_PORT') ?? null;
        $mailUserName    = env('MAIL_USERNAME') ?? null;
        $mailPassword    = env('MAIL_PASSWORD') ?? null;
        $mailEncryption  = env('MAIL_ENCRYPTION') ?? null;
        $mailFromAddress = env('MAIL_FROM_ADDRESS') ?? null;
        $mailFromName    = env('MAIL_FROM_NAME') ?? null;

        if (
            $mailMailer === null ||
            $mailHost === null ||
            $mailPort === null ||
            $mailUserName === null ||
            $mailPassword === null ||
            $mailEncryption === null ||
            $mailFromAddress === null ||
            $mailFromName === null
        ) {
            return (object) ['status' => 'error', 'message' => 'Email configuration is not set up'];
        }

        return (object) ['status' => 'success'];
    }

}

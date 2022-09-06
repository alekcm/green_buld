<?php

namespace App\Services\Feedbacks;

use App\Models\Config;
use Exception;
use Illuminate\Support\Facades\Mail;

class FeedbackService
{
    public function send(array $data): bool
    {
        try {
            $configEmails = Config::first()->emails;
            Mail::send('mail.feedback', $data, function ($message) use ($configEmails, $data) {
                $message->to($configEmails)->subject(
                    trans('message.feedback.email.subject', [
                        'purchasing_category' => $data['purchasing_category'],
                    ])
                );
            });
            return true;

        } catch (Exception $ex) {
            return false;
        }
    }
}

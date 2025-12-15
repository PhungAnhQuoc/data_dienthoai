<?php

namespace App\Services;

use App\Mail\NewsletterPromotion;
use App\Mail\NewsletterWelcome;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class NewsletterService
{
    /**
     * Send welcome email to new subscriber
     */
    public static function sendWelcomeEmail(Subscriber $subscriber)
    {
        Mail::send(new NewsletterWelcome($subscriber));
    }

    /**
     * Send promotion email to all active subscribers
     */
    public static function sendPromotion($title, $content, $buttonUrl, $buttonText)
    {
        $subscribers = Subscriber::where('is_active', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::queue(new NewsletterPromotion(
                $title,
                $content,
                $buttonUrl,
                $buttonText,
                $subscriber->unsubscribe_token,
            ), $subscriber->email);
        }

        return [
            'success' => true,
            'sent_to' => $subscribers->count(),
        ];
    }

    /**
     * Send batch newsletter
     */
    public static function sendBatch($emails, $subject, $content)
    {
        foreach ($emails as $email) {
            $subscriber = Subscriber::where('email', $email)
                ->where('is_active', true)
                ->first();

            if ($subscriber) {
                Mail::queue(new NewsletterPromotion(
                    $subject,
                    $content,
                    '#',
                    'Xem chi tiết',
                    $subscriber->unsubscribe_token,
                ), $email);
            }
        }
    }

    /**
     * Get subscriber count
     */
    public static function getSubscriberCount()
    {
        return Subscriber::where('is_active', true)->count();
    }
}

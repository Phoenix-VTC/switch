<?php

namespace App\Notifications\Discord;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class ErroredJobTransfer extends Notification implements ShouldQueue
{
    use Queueable;

    public User $user;
    public array $error;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param array $error
     */
    public function __construct(User $user, array $error)
    {
        $this->user = $user;
        $this->error = $error;
    }

    public function via($notifiable): array
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable): DiscordMessage
    {
        $body = "<@&786316945522819073>"; // @Development Team

        $embed = [
            'title' => 'Errored Job Transfer',
            'color' => 15680580, // #EF4444
            'timestamp' => Carbon::now(),
            'author' => [
                'name' => config('app.name'),
                'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
            ],
            'fields' => [
                [
                    'name' => 'Base Username',
                    'value' => $this->user->username,
                ],
                [
                    'name' => 'Error Class',
                    'value' => '> ' . $this->error['class'],
                ],
                [
                    'name' => 'Error Message',
                    'value' => '```' . $this->error['message'] . '```',
                ],
            ]
        ];

        return DiscordMessage::create($body, $embed);
    }
}

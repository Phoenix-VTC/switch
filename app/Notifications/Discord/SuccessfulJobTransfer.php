<?php

namespace App\Notifications\Discord;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class SuccessfulJobTransfer extends Notification implements ShouldQueue
{
    use Queueable;

    public User $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable): DiscordMessage
    {
        $embed = [
            'title' => 'Successful Job Transfer',
            'color' => 1096065, // #10B981
            'timestamp' => Carbon::now(),
            'author' => [
                'name' => config('app.name'),
                'icon_url' => 'https://base.phoenixvtc.com/img/logo.png'
            ],
            'fields' => [
                [
                    'name' => 'Base Username',
                    'value' => $this->user->username,
                ]
            ]
        ];

        return DiscordMessage::create('', $embed);
    }
}

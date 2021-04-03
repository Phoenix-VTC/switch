<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Job extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Route notifications for the Discord channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.development_updates_channel_id');
    }
}

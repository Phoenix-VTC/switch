<?php

namespace App\Observers;

use App\Models\BaseJob;

class BaseJobObserver
{
    /**
     * Handle the BaseJob "created" event.
     *
     * @param  \App\Models\BaseJob  $baseJob
     * @return void
     */
    public function created(BaseJob $baseJob)
    {
        $baseJob->user->deposit($baseJob->total_income, ['description' => 'PhoenixSwitch job', 'job_id' => $baseJob->id]);
    }
}

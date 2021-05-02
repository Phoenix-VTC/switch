<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseJob extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'base';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';
}

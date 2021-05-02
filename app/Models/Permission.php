<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'base';
}

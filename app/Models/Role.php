<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'base';
}

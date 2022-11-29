<?php
namespace App\Models;

use App\ModelOld;

class Task extends ModelOld
{
    protected $log_timestamp = true;
    protected $table = 'tasks';
}
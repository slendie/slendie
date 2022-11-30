<?php
namespace App\Models;

use Slendie\Framework\Database\Model;

class Task extends ModelOld
{
    protected $table = 'tasks';
    protected $log_timestamp = true;
}
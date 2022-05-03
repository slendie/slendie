<?php
namespace App\Models;

use App\Model;

class Task extends Model
{
    protected $log_timestamp = true;
    protected $table = 'tasks';
}
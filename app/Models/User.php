<?php
namespace App\Models;

use App\Model;

class User extends Model
{
    protected $log_timestamp = true;
    protected $table = 'users';
}
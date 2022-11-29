<?php
namespace App\Models;

use Slendie\Framework\Database\Model;

class User extends Model
{
    protected $table = 'users';
    protected $log_timestamp = true;
}
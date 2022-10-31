<?php
namespace App;

class Model extends \Slendie\Framework\Database\Model
{
    protected static $table = NULL;
    protected $log_timestamp = true;
    protected $soft_deletes = true;
}
<?php
namespace App;

class Model extends \Slendie\Framework\Database\Model
{
    protected $log_timestamp = true;
    protected $soft_deletes = true;
    protected $table = NULL;
}
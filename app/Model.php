<?php
namespace App;

use Slendie\Framework\Database\ActiveRecord;

class Model extends ActiveRecord
{
    protected $log_timestamp = true;
    protected $soft_deletes = true;
    protected $table = NULL;
}
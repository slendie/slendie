<?php
namespace App;

use Slendie\Framework\Model\ActiveRecord;

class Model extends ActiveRecord
{
    protected $log_timestamp = true;
    protected $soft_deletes = true;
}
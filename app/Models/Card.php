<?php
namespace App\Models;

use Slendie\Framework\Database\Model;
use Slendie\Framework\Database\Sql;

class Card extends Model
{
    protected $table = 'cards';
    protected $log_timestamp = true;

    public function fromSlug( $slug )
    {
        $sql = new Sql( $this->getTable() );
        $select = $sql->select()->where('slug', $slug)->get();

        return $this->fetch( $select );
    }

    public function exclusiveSlug( $slug, $id )
    {
        $sql = new Sql( $this->getTable() );
        $select = $sql->select()->where('slug', $slug)->where('id', $id, '<>')->get();

        return $this->fetch( $select );
    }
}
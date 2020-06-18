<?php

namespace Sitebill\Entity\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use CrudTrait;


    protected $table = 'table';
    protected $primaryKey = 'table_id';

    public $timestamps = true;

    public function column()
    {
        return $this->hasMany('Columns', 'table_id');
    }

}

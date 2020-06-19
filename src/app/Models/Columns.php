<?php

namespace Sitebill\Entity\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Columns extends Model
{
    use CrudTrait;

    protected $table = 'columns';
    protected $primaryKey = 'columns_id';
    protected $fillable = ['name', 'title'];

    public function table()
    {
        return $this->belongsTo('Sitebill\Entity\app\Models\Table', 'table_id');
    }


}

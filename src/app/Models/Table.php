<?php

namespace Sitebill\Entity\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use CrudTrait;


    protected $table = 'table';
    protected $primaryKey = 'table_id';
    protected $fillable = ['name', 'description'];


    public $timestamps = true;

    public function column()
    {
        return $this->hasMany('Columns', 'table_id');
    }
    
    public function openColumns($crud = false)
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="'.url($crud->route.'/'.$this->table_id.'/columns').'"><i class="la la-list"></i> Список свойств</a>';
    }

}

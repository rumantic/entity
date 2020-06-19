<?php

namespace Sitebill\Entity\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class TableGrids extends Model
{
    use CrudTrait;

    protected $table = 'table_grids';
    protected $primaryKey = 'action_code';
    protected $fillable = ['grid_fiels', 'meta'];
}

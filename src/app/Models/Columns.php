<?php

namespace Sitebill\Entity\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Sitebill\Entity\app\Models\Meta\EntityItem;

class Columns extends Model
{
    use CrudTrait;
    use \Sitebill\Entity\app\Models\Traits\Meta;

    protected $table = 'columns';
    protected $primaryKey = 'columns_id';
    protected $guarded = ['columns_id'];

    public function get_all_columns () {
        $result = collect();

        $column_items = [
            'columns_id' => [
                'name' => 'columns_id',
                'title' => 'ID',
                'type' => 'primary_key',
            ],
            'active' => [
                'name' => 'active',
                'title' => 'Колонка активна',
                'type' => 'checkbox',
                'required' => 'off',
            ],
            'sort_order' => [
                'name' => 'sort_order',
                'title' => 'Порядок сортировки',
                'type' => 'hidden',
                'required' => 'off',
            ],
            'table_id' => [
                'name' => 'table_id',
                'title' => 'Таблица',
                'type' => 'select_by_query',
                'required' => 'on',
                'primary_key_name' => 'table_id',
                'primary_key_table' => 'table',
                'value_name' => 'name',
                'title_default' => 'выбрать таблицу',
                'value_default' => 0,
            ],
            'name' => [
                'name' => 'name',
                'title' => 'Название колонки (системное только латиница)',
                'type' => 'safe_string',
                'required' => 'on',
            ],
        ];
        foreach ( $column_items as $column_name => $column_item ) {
            $entity_item = new EntityItem($column_item);
            $result->put($column_name, $entity_item);
        }

        return $result;
    }

    public function table_id_rel()
    {
        return $this->belongsTo('Sitebill\Entity\app\Models\Table', 'table_id');
    }


}

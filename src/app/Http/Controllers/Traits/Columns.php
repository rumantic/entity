<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Facade\Ignition\Tabs\Tab;
use Illuminate\Support\Facades\DB;
use Sitebill\Entity\app\Models\Meta\Entity;
use Sitebill\Entity\app\Models\TableGrids;

trait Columns {

    public function getEntityColumns () {
        $model = $this->crud->getModel();
        $user = auth()->user();
        $user_id = $user->id;
        if ( !$model->is_meta_loaded() ) {
            $model->load_sitebill();
        }

        $grid_columns = $this->get_grid_columns($model->getTable(), $user_id);
        if ( !$grid_columns ) {
            return false;
        }
        //dd($grid_columns);

        foreach ( $grid_columns['grid_fields'] as $column ) {
            //$this->column

            $entity = $model->get_entity($column);

            $this->crud->addColumn([
                    'name' => $entity->name(),
                    'label' => $entity->title(),
                    'type' => 'text',
                ]
            );
        }

        /*
        $this->crud->addColumn('id');
        $this->crud->addColumn([
            'name' => 'date_added',
            'label' => 'Date',
            'type' => 'date',
        ]);
        $this->crud->addColumn('active');
        $this->crud->addColumn('text');
        $this->crud->addColumn([
            'label' => 'Topic',
            'type' => 'select',
            'name' => 'topic_id',
            'entity' => 'topic',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('topic/'.$related_key.'/show');
                },
            ],
        ]);
        */
    }

    private function get_grid_columns($model_name, $user_id) {
        $used_fields = array();
        $action_code = $this->get_grid_action_code($model_name, $user_id);
        $rows = DB::table('table_grids')->where('action_code', $action_code)->first();
        if ($rows) {
            $ar = (array)$rows;
            $used_fields = json_decode($ar['grid_fields']);
            $meta_fields = (array) json_decode($ar['meta']);
            if (count($used_fields) > 0) {
                $ra['grid_fields'] = $used_fields;
                $ra['meta'] = $meta_fields;
                return $ra;
            }
        }
        return false;
    }


    private function get_grid_action_code($model_name, $user_id) {
        $action = $model_name . '_user_' . $user_id;
        return $action;
    }

    public function get_action_code () {
        $model = $this->crud->getModel();
        $user = auth()->user();
        $user_id = $user->id;
        return $this->get_grid_action_code($model->getTable(), $user_id);
    }

}

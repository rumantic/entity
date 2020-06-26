<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Clockwork\Request\Log;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Support\Facades\DB;
use Sitebill\Entity\app\Models\Meta\Entity;
use Sitebill\Entity\app\Models\Meta\EntityItem;
use Sitebill\Entity\app\Models\TableGrids;

trait Columns {
    use TypeMapper;

    public function getEntityColumns () {
        $model = $this->crud->getModel();
        $user = auth()->user();
        $user_id = $user->id;
        $columns = $model->get_all_columns();

        $grid_columns = $this->get_grid_columns($model->getTable(), $user_id);
        if ( !$grid_columns ) {
            return false;
        }
        //dd($grid_columns);

        foreach ( $grid_columns['grid_fields'] as $column ) {
            //$this->column

            $entity = $model->get_entity($column);

            $this->crud->addColumn($this->get_mapped_entity_item($entity));
        }
    }

    protected function getEntityFormFields () {
        $model = $this->crud->getModel();
        $columns = $model->get_all_columns();
        foreach ( $columns as $key => $entity_item ) {
            $this->crud->addField($this->get_mapped_entity_item($entity_item));
        }
    }

    protected function get_mapped_entity_item ( EntityItem $entity_item ) {
        $method_map_name = $entity_item->type().'_map';
        if ( method_exists($this, $method_map_name) ) {
            $mapped_column = $this->$method_map_name($entity_item);
        } else {
            \Illuminate\Support\Facades\Log::info('$method_map_name = '.$method_map_name);
            $mapped_column = $this->default_map($entity_item);
        }
        return $mapped_column;
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

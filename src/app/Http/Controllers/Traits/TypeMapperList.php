<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Sitebill\Entity\app\Models\Meta\EntityItem;

trait TypeMapperList {
    protected function select_by_query_map_list ( EntityItem $entity_item ) {

        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),

            'type'    => 'select',
            //'type'    => 'view',
            //'view'    => 'sitebill_entity::list.select_by_query',

            'entity'    => $entity_item->name().'_rel',
            'attribute'    => $entity_item->value_name(),
            //'model'   => 'Sitebill\Realty\app\Models\region',
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
        /*

        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'type'    => 'view',
            'view'    => 'sitebill_entity::fields.geodata',
            'entity'    => $entity_item->name().'_rel',
            'attribute'    => $entity_item->value_name(),
            'model'   => 'Sitebill\Realty\app\Models\region',
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
        */
        return $item;
    }

    protected function select_box_structure_map_list ( EntityItem $entity_item ) {

        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),

            'type'    => 'select',
            'entity'    => $entity_item->name().'_rel',
            'attribute'    => 'name',
            'attributes' => [
                'placeholder' => $entity_item->title(),
            ],
        ];
        return $item;
    }

}

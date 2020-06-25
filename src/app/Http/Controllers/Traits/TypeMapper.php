<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Sitebill\Entity\app\Models\Meta\EntityItem;

trait TypeMapper {
    protected function dtdatetime_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'datetime_picker',
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
    }

    protected function primary_key_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'text',
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
    }

    protected function safe_string_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'text',
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
    }

    protected function select_box_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'select_from_array',
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            'options' => $entity_item->select_data(),
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
    }




    protected function date_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'type'    => 'date',
            'tab'  => $entity_item->tab(),
        ];
    }

    protected function textarea_editor_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'type'    => 'ckeditor',
            'tab'  => $entity_item->tab(),
        ];
    }


    protected function default_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'type'    => 'text',
            'tab'  => $entity_item->tab(),
        ];
    }
}

<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Clockwork\Request\Log;
use Sitebill\Entity\app\Models\Meta\EntityItem;

trait TypeMapper {
    use TypeMapperList;

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


    protected function checkbox_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'checkbox',
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

    protected function price_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'number',
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            //'prefix' => 'руб.',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                "step" => "1000",
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
    }

    protected function textarea_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'textarea',
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

    protected function uploads_map ( EntityItem $entity_item ) {
        return [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'upload_multiple',
            'upload'  => true,
            'disk'    => 'uploads',
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

    protected function select_by_query_map ( EntityItem $entity_item ) {
        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            'default' => $entity_item->value(),
            'type'    => 'select2',
            'entity'    => $entity_item->name().'_rel',
            'attribute'    => $entity_item->value_name(),
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            //'ajax'          => true,
            //'inline_create'      => true,
            //'options'   => (function ($query) {
            //    return $query->get();
            //}), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select

            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
        //\Illuminate\Support\Facades\Log::info($item);
        return $item;
    }

    protected function geodata_map ( EntityItem $entity_item ) {
        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            //'default' => $entity_item->value(),
            'type'    => 'view',
            'view'    => 'sitebill_entity::fields.geodata',
            //'entity'    => $entity_item->name().'_rel',
            //'attribute'    => $entity_item->value_name(),
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            'fake' => true,
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
        //\Illuminate\Support\Facades\Log::info($item);
        return $item;
    }

    protected function compose_map ( EntityItem $entity_item ) {
        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            //'default' => $entity_item->value(),
            'type'    => 'text',
            //'entity'    => $entity_item->name().'_rel',
            //'attribute'    => $entity_item->value_name(),
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            'fake' => true,
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
        //\Illuminate\Support\Facades\Log::info($item);
        return $item;
    }

    protected function injector_map ( EntityItem $entity_item ) {
        $item = [
            'name'    => $entity_item->name(),
            'label'   => $entity_item->title(),
            //'default' => $entity_item->value(),
            'type'    => 'text',
            //'entity'    => $entity_item->name().'_rel',
            //'attribute'    => $entity_item->value_name(),
            'tab'  => $entity_item->tab(),
            'hint' => $entity_item->hint(),
            'fake' => true,
            //'prefix' => '',
            //'suffix' => '',
            'attributes' => [
                'placeholder' => $entity_item->title(),
                //'class'       => 'form-control some-class',
                //'readonly'    => 'readonly',
                //'disabled'    => 'disabled',
            ],
        ];
        //\Illuminate\Support\Facades\Log::info($item);
        return $item;
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

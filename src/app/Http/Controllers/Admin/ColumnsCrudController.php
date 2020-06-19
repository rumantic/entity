<?php

namespace Sitebill\Entity\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Sitebill\Realty\app\Http\Requests\TopicRequest;

class ColumnsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    public function setup()
    {
        CRUD::setModel("Sitebill\Entity\app\Models\Columns");
        CRUD::setRoute(config('backpack.base.route_prefix', 'admin').'/columns');
        CRUD::setEntityNameStrings('column', 'columns');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn('name');
        CRUD::addColumn([
            'label' => 'table_id',
            'type' => 'select',
            'name' => 'table_id',
            'entity' => 'table',
            'attribute' => 'name',
        ]);

        //CRUD::addColumn('url');
        //CRUD::addColumn('parent');
        /*
        CRUD::addColumn([   // select_multiple: n-n relationship (with pivot table)
            'label'     => 'Articles', // Table column heading
            'type'      => 'relationship_count',
            'name'      => 'articles', // the method that defines the relationship in your Model
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('article?category_id='.$entry->getKey());
                },
            ],
        ]);
        */
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();

        CRUD::addColumn('created_at');
        CRUD::addColumn('updated_at');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TopicRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label' => 'Name',
        ]);
        CRUD::addField([
            'label' => 'table_id',
            'type' => 'select',
            'name' => 'table_id',
            'entity' => 'table',
            'attribute' => 'name',
        ]);

        /*
        CRUD::addField([
            'name' => 'url',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your name, if left empty.',
            // 'disabled' => 'disabled'
        ]);
        CRUD::addField([
            'label' => 'Parent',
            'type' => 'select2_nested',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
        ]);
        */
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'name');
        CRUD::set('reorder.max_level', 2);
    }
}

<?php

namespace Sitebill\Entity\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Sitebill\Entity\app\Http\Requests\EntityRequest;
use Sitebill\Realty\app\Http\Requests\TopicRequest;

class ColumnsCrudController extends EntityCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    use \Sitebill\Entity\app\Http\Controllers\Traits\Columns;
    use \Sitebill\Entity\app\Http\Controllers\Traits\ListBuilderOperation;

    public function setup()
    {
        CRUD::setModel("Sitebill\Entity\app\Models\Columns");
        CRUD::setRoute(config('backpack.base.route_prefix', 'admin').'/columns');
        CRUD::setEntityNameStrings('column', 'columns');
        $this->setEntityRequest(EntityRequest::class);
        $this->setupList();
        $this->setupCreateAndUpdate();
    }

    protected function get_grid_columns($model_name, $user_id) {
        $ra['grid_fields'] = ['name', 'active', 'table_id'];
        $ra['meta'] = [];
        return $ra;
    }
}

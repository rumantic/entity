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
    
    public function index()
    {
        if(!isset($_GET['tableId'])){
            $this->data['crud'] = $this->crud;
            $this->data['title'] = 'No title';
            $this->data['tables'] = \Sitebill\Entity\app\Models\Table::all()->sortBy('name')->pluck('name', 'table_id')->toArray();
            return view("sitebill_entity::list.columns_tables_list", $this->data);
        }
        
        return parent::index();
    }

    public function setup()
    {
        CRUD::setModel("Sitebill\Entity\app\Models\Columns");
        CRUD::setRoute(config('backpack.base.route_prefix', 'admin').'/columns');
        CRUD::setEntityNameStrings('column', 'columns');
        $this->setEntityRequest(EntityRequest::class);
        $this->setupList();
        $this->setupCreateAndUpdate();
    }
    
    protected function setupList () {
        $this->crud->operation('list', function () {
            $this->getEntityColumns();
        });
        $this->crud->removeAllFilters();
        $this->crud->addFilter(
            [
                'name'  => 'table_id',
                'type'  => 'select2',
                'label' => 'Таблица'
            ],
            function(){
                return \Sitebill\Entity\app\Models\Table::all()->sortBy('name')->pluck('name', 'table_id')->toArray();
            },
            function($value) {
                $this->crud->addClause('where', 'table_id', $value);
            }
        );
    }

    protected function get_grid_columns($model_name, $user_id) {
        $ra['grid_fields'] = ['name', 'active', 'table_id'];
        $ra['meta'] = [];
        return $ra;
    }
}

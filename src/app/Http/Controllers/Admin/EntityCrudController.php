<?php
namespace Sitebill\Entity\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Sitebill\Realty\app\Http\Requests\DataRequest;

class EntityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    use \Sitebill\Entity\app\Http\Controllers\Traits\Columns;
    use \Sitebill\Entity\app\Http\Controllers\Traits\ListBuilderOperation;

    protected $entity_request;

    protected function setEntityRequest ($entity_request) {
        $this->entity_request = $entity_request;
    }

    protected function defaultSetup() {
        $this->setupList();
        $this->setupCreateAndUpdate();
        $this->setupListBuilderFiels();

    }

    protected function getEntityRequest () {
        return $this->entity_request;
    }

    protected function setupList () {
        $this->crud->operation('list', function () {
            $this->getEntityColumns();
        });
    }
    protected function setupCreateAndUpdate () {
        $this->crud->operation(['create', 'update'], function () {
            $this->crud->setValidation($this->getEntityRequest());

            $this->crud->addField([
                'name' => 'text',
                'label' => 'Text',
                'type' => 'ckeditor',
                'placeholder' => 'Your title here',
            ]);
            $this->crud->addField([
                'name' => 'date_added',
                'label' => 'Date',
                'type' => 'date',
                'default' => date('Y-m-d'),
            ]);
            $this->crud->addField([
                'label' => 'Topic',
                'type' => 'select2_nested',
                'name' => 'topic_id',
                'entity' => 'topic',
                'attribute' => 'name',
                'inline_create' => true,
                'model' => "Sitebill\Realty\app\Models\Topic", // force foreign key model

                //'ajax' => true,
            ]);
        });

    }

}

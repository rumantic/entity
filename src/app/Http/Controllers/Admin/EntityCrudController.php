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
    //use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    use \Sitebill\Entity\app\Http\Controllers\Traits\Columns;

    protected $entity_request;

    protected function setEntityRequest ($entity_request) {
        $this->entity_request = $entity_request;
    }

    protected function getEntityRequest () {
        return $this->entity_request;
    }

    protected function setupList () {
        $this->crud->operation('list', function () {
            $this->getEntityColumns();
            $this->crud->addButton('top', 'list_builder', 'view', 'sitebill_entity::buttons.list_builder', 'end');


            /*
            $this->crud->addColumn([
                'name' => 'featured',
                'label' => 'Featured',
                'type' => 'check',
            ]);
            $this->crud->addColumn('tags');

            $this->crud->addFilter([ // select2 filter
                'name' => 'category_id',
                'type' => 'select2',
                'label'=> 'Category',
            ], function () {
                return \Backpack\NewsCRUD\app\Models\Category::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($value) { // if the filter is active
                $this->crud->addClause('where', 'category_id', $value);
            });

            $this->crud->addFilter([ // select2_multiple filter
                'name' => 'tags',
                'type' => 'select2_multiple',
                'label'=> 'Tags',
            ], function () {
                return \Backpack\NewsCRUD\app\Models\Tag::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($values) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('tags', function ($q) use ($values) {
                    foreach (json_decode($values) as $key => $value) {
                        if ($key == 0) {
                            $q->where('tags.id', $value);
                        } else {
                            $q->orWhere('tags.id', $value);
                        }
                    }
                });
            });
            */
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

            /*
            $this->crud->addField([
                'name' => 'content',
                'label' => 'Content',
                'type' => 'ckeditor',
                'placeholder' => 'Your textarea text here',
            ]);
            $this->crud->addField([
                'name' => 'image',
                'label' => 'Image',
                'type' => 'browse',
            ]);
            $this->crud->addField([
                'label' => 'Tags',
                'type' => 'relationship',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'inline_create' => ['entity' => 'tag'],
                'ajax' => true,
            ]);
            $this->crud->addField([
                'name' => 'status',
                'label' => 'Status',
                'type' => 'enum',
            ]);
            $this->crud->addField([
                'name' => 'featured',
                'label' => 'Featured item',
                'type' => 'checkbox',
            ]);
            */
        });

    }

}

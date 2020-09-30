<?php

namespace Sitebill\Entity\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Sitebill\Realty\app\Http\Requests\DataRequest;
use Illuminate\Support\Facades\Route;

class TableCrudController extends CrudController
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
    
    
    
    
    
    protected function setupTableColumnsRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/columns', [
            'as'        => $routeName.'.columns',
            'uses'      => $controller.'@columns',
            'operation' => 'columns',
        ]);
    }
    
    public function columns($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Moderate '.$this->crud->entity_name;
        $this->data['columns'] = \Sitebill\Entity\app\Models\Columns::all()->where('table_id', $id)->sortBy('name')->toArray();
        //print_r($this->data['columns']);
        return view("sitebill_entity::list.columns", $this->data);
    }
    
    

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(\Sitebill\Entity\app\Models\Table::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/table');
        $this->crud->setEntityNameStrings('table', 'tables');

        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->operation('list', function () {
            //
            $this->crud->addColumn('table_id');
            $this->crud->addColumn([
                'name' => 'name',
                'label' => 'name',
                'type' => 'text',
            ]);
            $this->crud->addButtonFromModelFunction('line', 'table_columns', 'openColumns', 'end');
            

            /*
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

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */
        $this->crud->operation(['create', 'update'], function () {
            //$this->crud->setValidation(DataRequest::class);

            $this->crud->addField([
                'name' => 'name',
                'label' => 'Text',
                'type' => 'text',
                'placeholder' => 'Your title here',
            ]);
            $this->crud->addField([
                'name' => 'description',
                'label' => 'description',
                'type' => 'ckeditor',
            ]);
            /*

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

    /**
     * Respond to AJAX calls from the select2 with entries from the Category model.
     * @return JSON
     */
    public function fetchCategory()
    {
        //return $this->fetch(\Backpack\NewsCRUD\app\Models\Category::class);
    }

    /**
     * Respond to AJAX calls from the select2 with entries from the Tag model.
     * @return JSON
     */
    public function fetchTags()
    {
        //return $this->fetch(\Backpack\NewsCRUD\app\Models\Tag::class);
    }
}

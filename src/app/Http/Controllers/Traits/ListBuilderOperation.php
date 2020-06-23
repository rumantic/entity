<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Illuminate\Support\Facades\Route;
use Sitebill\Entity\app\Models\TableGrids;

trait ListBuilderOperation {
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $name       Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupListBuilderRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/list_builder', [
            'as'        => $routeName.'.show_list',
            'uses'      => $controller.'@showList',
            'operation' => 'list_builder',
        ]);

        Route::post($segment.'/list_builder', [
            'as'        => $routeName.'.post_list_builder',
            'uses'      => $controller.'@saveList',
            'operation' => 'list_builder',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupListBuilderDefaults()
    {
        //$this->crud->set('reorder.enabled', true);
        $this->crud->allowAccess('list_builder');

        $this->crud->operation('list_builder', function () {

            //$this->crud->loadDefaultOperationSettingsFromConfig();
            // $this->crud->addButton('bottom', 'list_builder', 'view', 'sitebill_entity::buttons.list_builder', 'end');
            /*
            $this->crud->addSaveAction([
                'name' => 'save_action_one',
                'redirect' => function($crud, $request, $itemId) {
                    return $crud->route;
                }, // what's the redirect URL, where the user will be taken after saving?

                // OPTIONAL:
                'button_text' => 'Custom save message', // override text appearing on the button
                // You can also provide translatable texts, for example:
                // 'button_text' => trans('backpack::crud.save_action_one'),
                'visible' => function($crud) {
                    return true;
                }, // customize when this save action is visible for the current operation
                'referrer' => function($crud, $request, $itemId) {
                    return $crud->route;
                }, // override http_referrer_url
                'order' => 1, // change the order save actions are in
            ]);
            */

        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('top', 'list_builder', 'view', 'sitebill_entity::buttons.list_builder', 'end');
        });
    }

    protected function setupListBuilderFiels () {
        $this->crud->operation('list_builder', function () {
            $value = $this->get_table_grids();

            $model = $this->crud->getModel();
            $columns = $model->get_all_columns();
            $columns_keys = array_keys($columns);
            //dd($columns_keys);

            $this->crud->addField(
                [ // select_and_order
                    'name'    => 'select_and_order',
                    'label'   => 'Выбрать колонки для таблицы',
                    'type'    => 'select_and_order',
                    'options' => $columns_keys,
                    'value' => [1,2,3],


                    'fake' => false,
                    //'tab'  => 'Selects',
                ]
            );
        });
    }

    private function get_table_grids () {
        $table_grids = TableGrids::where('action_code', 'data_user_0')->first();
        return json_decode($table_grids->grid_fields);
    }



    public function showList (Request $request = null) {
        //$this->crud->setOperation('ListBuilder');
        $this->data['crud'] = $this->crud;
        $this->crud->setupDefaultSaveActions();
        $this->setupListBuilderFiels();

        $this->data['saveAction'] = $this->crud->getSaveAction();

        return view('sitebill_entity::list.builder', $this->data);
    }

    public function saveList (Request $request = null) {
        TableGrids::where('action_code', 'street_user_0')
            ->update(['grid_fields' => 'test']);

        \Alert::success(trans('sitebill::entity.table_settings_updated'))->flash();
        // save the redirect choice for next time
        //$this->crud->setSaveAction();
        return \Redirect::to($this->crud->route);

    }
}

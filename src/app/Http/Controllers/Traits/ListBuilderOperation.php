<?php
namespace Sitebill\Entity\app\Http\Controllers\Traits;

use Illuminate\Support\Facades\Route;

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


    public function showList (Request $request = null) {
        //$this->crud->setOperation('ListBuilder');
        $this->data['crud'] = $this->crud;
        $this->crud->setupDefaultSaveActions();


        $this->data['saveAction'] = $this->crud->getSaveAction();

        return view('sitebill_entity::list.builder', $this->data);
    }

    public function saveList (Request $request = null) {

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        // save the redirect choice for next time
        //$this->crud->setSaveAction();
        return \Redirect::to($this->crud->route);

    }
}

<?php

/*
|--------------------------------------------------------------------------
| Backpack\NewsCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\NewsCRUD package.
|
*/

Route::group([
    'namespace' => 'Sitebill\Entity\app\Http\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin'],
], function () {
    Route::crud('table', 'TableCrudController');
    Route::crud('columns', 'ColumnsCrudController');
    //Route::crud('tag', 'TagCrudController');
});

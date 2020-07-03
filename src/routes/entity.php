<?php

Route::group([
    'namespace' => 'Sitebill\Entity\app\Http\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin'],
], function () {
    Route::crud('table', 'TableCrudController');
    Route::crud('columns', 'ColumnsCrudController');
    //Route::crud('tag', 'TagCrudController');
});

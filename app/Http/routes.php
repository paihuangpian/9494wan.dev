<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {

    // 后台
    Route::group(['prefix' => 'admin'], function(){
        Route::get('/', function(){
            return view('admin');
        });
        Route::group(['prefix' => 'system'], function(){
            Route::get('/', ['as' => 'system', function(){
                return view('admin.system.index');
            }]);
            Route::group(['prefix' => 'menus'], function(){
                Route::get('/', ['as' => 'menus', 'uses' => 'SystemController@index']);
                Route::get('addMenu', ['as' => 'addMenu', 'uses' => 'SystemController@addMenu']);
                Route::post('postMenu', ['as' => 'postMenu', 'uses' => 'SystemController@postMenu']);
            });
        });
    });
});

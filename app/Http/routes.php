<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/admin', function(){
        return view('admin');
    });
    Route::get('nav', function(){
        return response()->json([
            ['name' => '仪表盘', 'level' => 1],
            ['name' => '系统','level' => 1],
            ['name' => '会员','level' => 1],
            ['name' => '文章','level' => 1],
        ]);
    });
});

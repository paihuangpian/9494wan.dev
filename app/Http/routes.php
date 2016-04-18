<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vue', function(){
    return view('vue');
});

Route::group(['prefix' => 'api'], function(){
    Route::get('menus', function(){
        $menus = \DB::table('menus')->where('status', 1)->get();
        sleep(1);
        return response()->json($menus);
    });
});

Route::group(['middleware' => ['web']], function () {

    // 后台
    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

        // 设置服务器时区并利用 HTML5 server-sent 更新时间
        Route::get('time', function(){
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            date_default_timezone_set("Etc/GMT-8");
            $time = date("Y-m-d H:i:s",time());
            echo "data: {$time}\n\n";
            flush();
        });

        // 首页：服务器信息等
        Route::get('/', ['as' => 'admin', function(){
            date_default_timezone_set("Etc/GMT-8");
            $infos = collect([
                ['name' => '系统版本', 'value' => '1.0.0', 'color' => 'red'],
                ['name' => '服务器', 'value' => $_SERVER["SERVER_SOFTWARE"], 'color' => 'origin'],
                ['name' => 'PHP版本', 'value' => PHP_VERSION, 'color' => 'blue'],
                ['name' => 'GD库版本', 'value' => gd_info()['GD Version'], 'color' => 'green'],
                ['name' => '最大上传限制', 'value' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", 'color' => 'red'],
                ['name' => '脚本最大执行时间', 'value' => ini_get("max_execution_time") . '秒', 'color' => 'origin'],
                ['name' => '服务器时间', 'value' => date("Y-m-d H:i:s",time()), 'color' => 'grey'],
                ['name' => '版权所有', 'value' => '广州市格木网络科技有限公司', 'color' => 'green'],
            ]);

            return view('admin', ['infos' => $infos]);
        }]);

        // 仪表盘
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Admin\DashboardController@index']);

        // 系统
        Route::group(['prefix' => 'system'], function(){
            Route::get('/', ['as' => 'system', function(){
                $menus = \DB::table('menus')->where('status', 1)->get();
                return view('admin.system.index', ['menus' => $menus]);
            }]);
            Route::group(['prefix' => 'menus'], function(){
                Route::get('/', ['as' => 'menus', 'uses' => 'SystemController@index']);
                Route::get('addMenu', ['as' => 'addMenu', 'uses' => 'SystemController@addMenu']);
                Route::post('postMenu', ['as' => 'postMenu', 'uses' => 'SystemController@postMenu']);
            });
        });

        // 游戏
        Route::group(['prefix' => 'game'], function(){
            Route::get('/', ['as' => 'game', 'uses' => 'Admin\GameController@index']);
            Route::get('addGame', ['as' => 'addGame', 'uses' => 'Admin\GameController@addGame']);
        });
    }); 

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

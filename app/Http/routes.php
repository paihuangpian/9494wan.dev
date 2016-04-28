<?php

// 后台
Route::group(['middleware' => ['web']], function () {
    date_default_timezone_set("Etc/GMT-8");
    Route::get('admin/login', 'Admin\AuthController@getLogin');
    Route::post('admin/login', 'Admin\AuthController@postLogin');
    Route::get('admin/logout', 'Admin\AuthController@logout');
    Route::get('admin/password/reset', 'Admin\PasswordController@showResetForm');
    
    Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function(){

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
                // ['name' => '服务器', 'value' => $_SERVER["SERVER_SOFTWARE"], 'color' => 'origin'],
                // ['name' => 'PHP版本', 'value' => PHP_VERSION, 'color' => 'blue'],
                // ['name' => 'GD库版本', 'value' => gd_info()['GD Version'], 'color' => 'green'],
                // ['name' => '最大上传限制', 'value' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", 'color' => 'red'],
                // ['name' => '脚本最大执行时间', 'value' => ini_get("max_execution_time") . '秒', 'color' => 'origin'],
                // ['name' => '服务器时间', 'value' => date("Y-m-d H:i:s",time()), 'color' => 'grey'],
                ['name' => '版权所有', 'value' => '广州市格木网络科技有限公司', 'color' => 'green'],
            ]);

            return view('admin', ['infos' => $infos]);
        }]);

        // 仪表盘
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Admin\DashboardController@index']);

        // 等级计划
        Route::group(['prefix' => 'level'], function(){
            Route::get('/', ['as' => 'level', 'uses' => 'LevelController@index']);
            Route::get('add', ['as' => 'addLevel', 'uses' => 'LevelController@addLevel']);
            Route::post('add', ['as' => 'postLevel', 'uses' => 'LevelController@postLevel']);
            Route::get('edit', ['as' => 'editLevel', 'uses' => 'LevelController@editLevel']);
            Route::post('edit', ['as' => 'updateLevel', 'uses' => 'LevelController@updateLevel']);
            Route::get('del', ['as' => 'delLevel', 'uses' => 'LevelController@delLevel']);
        });

        // 游戏
        Route::group(['prefix' => 'game'], function(){
            Route::get('/', ['as' => 'game', 'uses' => 'Admin\GameController@index']);
            Route::get('addGame', ['as' => 'addGame', 'uses' => 'Admin\GameController@addGame']);
        });

        // 军团、小组
        Route::group(['prefix' => 'group'], function(){
            Route::get('/', ['as' => 'group', 'uses' => 'Admin\GroupController@index']);
            Route::get('add', ['as' => 'addGroup', 'uses' => 'Admin\GroupController@addGroup']);
            Route::post('postGroup', ['as' => 'postGroup', 'uses' => 'Admin\GroupController@postGroup']);
            Route::get('edit', ['as' => 'editGroup', 'uses' => 'Admin\GroupController@editGroup']);
            Route::post('edit', ['as' => 'updateGroup', 'uses' => 'Admin\GroupController@updateGroup']);
            Route::get('del', ['as' => 'delGroup', 'uses' => 'Admin\GroupController@delGroup']);

            // 指派组长api
            Route::get('users', ['as' => 'getUsers', 'uses' => 'Admin\GroupController@getUsers']);
            Route::get('searchUsers', ['as' => 'searchUsers', 'uses' => 'Admin\GroupController@searchUsers']);
            Route::get('setUser', ['as' => 'setUser', 'uses' => 'Admin\GroupController@setUser']);

        });

        // 员工
        Route::group(['prefix' => 'user'], function(){
            Route::get('/', ['as' => 'user', 'uses' => 'Admin\UserController@index']);
            Route::get('add', ['as' => 'addUser', 'uses' => 'Admin\UserController@addUser']);
            Route::post('add', ['as' => 'postUser', 'uses' => 'Admin\UserController@postUser']);
            Route::get('edit', ['as' => 'editUser', 'uses' => 'Admin\UserController@editUser']);
            Route::post('edit', ['as' => 'updateUser', 'uses' => 'Admin\UserController@updateUser']);
            Route::get('del', ['as' => 'delUser', 'uses' => 'Admin\UserController@delUser']);
        });

        // 留言板
        Route::group(['prefix' => 'book'], function(){
            Route::get('/', ['as' => 'bookAdmin', 'uses' => 'BookController@index']);
        });

    });

});

// 前台
Route::group(['middleware' => 'web'], function () {

    // Route::auth();
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    Route::group(['middleware' => 'auth'], function(){

        Route::get('/', ['as' => '/', 'uses' => 'HomeController@index']);

        // 组长管理
        Route::group(['middleware' => 'groupAdmin', 'prefix' => 'groupAdmin'], function(){
            Route::get('/', ['as' => 'groupAdmin', 'uses' => 'GroupAdminController@index']);
            Route::get('add', ['as' => 'addRecord', 'uses' => 'GroupAdminController@addRecord']);
            Route::post('add', ['as' => 'postRecord', 'uses' => 'GroupAdminController@postRecord']);

            // 组员战绩
            Route::get('user/{user_id}', ['as' => 'getUser', 'uses' => 'GroupAdminController@getUser']);
        });

        // 成长计划
        Route::get('plan', ['as' => 'plan', function(){
            $levels = \DB::table('levels')->where('status', 1)->orderBy('experience')->get();
            return view('plan', ['levels' => $levels]);
        }]);

        // 排行榜
        Route::get('rank', ['as' => 'rank', function(){
            $persons = \DB::select("select *, (@i := @i + 1) rank from users,(SELECT @i:=0) AS it order by experience desc");
            $groups = \DB::select("select group_id, sum(recharge) as total, (@i := @i + 1) rank from records,(SELECT @i:=0) AS it group by group_id order by total desc");
            
            return view('rank', ['persons' => $persons, 'groups' => $groups]);
        }]);

        // 留言板
        Route::get('book', ['as' => 'book', function(){
            return view('book');
        }]);
        Route::post('book', ['as' => 'postBook', 'uses' => 'BookController@postBook']);
    });
});

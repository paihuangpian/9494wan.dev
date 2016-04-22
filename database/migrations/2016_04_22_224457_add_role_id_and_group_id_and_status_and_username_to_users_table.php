<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleIdAndGroupIdAndStatusAndUsernameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username'); // 用户名 登陆用
            $table->integer('role_id'); // 角色 0-团长 1-组长 2-组员
            $table->integer('group_id'); // 小组
            $table->tinyInteger('status'); // 状态 0-离职 1-在职
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->dropColumn(['username', 'role_id', 'group_id', 'status']);
        });
    }
}

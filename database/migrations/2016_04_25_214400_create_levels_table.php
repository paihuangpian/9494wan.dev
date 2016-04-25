<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // 等级名称
            $table->string('sign'); // 标志
            $table->integer('experience'); // 所需经验
            $table->integer('attenuation'); // 衰减值
            $table->integer('wages'); // 等级工资
            $table->float('commission'); // 消费奖金百分比
            $table->integer('vacation'); // 带薪休假天数
            $table->tinyInteger('status'); // 状态 0-否 1-是
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('levels');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');

            // 基本信息
            $table->string('name'); // 游戏名称
            $table->string('company'); // 所属公司
            $table->text('description'); // 游戏描述
            $table->integer('type'); // 游戏类型 1-角色扮演 2-模拟经营 3-战争策略 4-休闲竞技 0-其他
            $table->integer('theme'); // 游戏题材 1-三国 2-西游 3-水浒 4-仙侠 5-武侠 6-魔幻 0-其他
            $table->integer('initial'); // 首字母 1-abcde 2-fghij 3-klmno 4-pqrst 5-uvwxyz
            $table->tinyInteger('status'); // 状态 0-否 1-是

            // 充值信息
            $table->string('game_coin'); // 游戏币名称
            $table->integer('change'); // 兑换比例
            $table->float('split'); // 工会分成比例

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
        Schema::drop('games');
    }
}

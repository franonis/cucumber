<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFeatureDefinitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_definitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('unit');
            $table->string('comment');
            // 数据量少就不建立索引了
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_definitions');
    }
}

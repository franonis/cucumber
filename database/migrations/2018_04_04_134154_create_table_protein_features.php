<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProteinFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protein_features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gene');
            $table->string('protein');
            $table->string('feature_id');
            $table->string('value', 2048);
            $table->index('gene');
            $table->index('feature_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protein_features');
    }
}

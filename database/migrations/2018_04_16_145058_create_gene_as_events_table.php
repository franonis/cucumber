<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneAsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gene_as_events', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('event', ['AA', 'AD', 'ES', 'IR', 'Others']);
            $table->string('gene');
            $table->string('chr');
            $table->text('loc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gene_as_events');
    }
}

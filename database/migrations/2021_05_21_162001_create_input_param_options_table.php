<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputParamOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_param_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('param_id');
            $table->foreign('param_id')->references('id')->on('input_parameters');
            $table->string('option_value');
            $table->timestamps();
            $table->enum('is_active', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_param_options');
    }
}

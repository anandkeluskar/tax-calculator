<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('param_name');
            $table->unsignedBigInteger('max_deduct_amt')->default(0);
            $table->timestamps();
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('input_parameters');
    }
}

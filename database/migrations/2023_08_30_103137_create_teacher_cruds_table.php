<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_cruds', function (Blueprint $table) {
            $table->id();
            $table->string('headline_en')->nullable();
            $table->string('headline_bn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_bn')->nullable();
            $table->text('description_en',200)->nullable();
            $table->text('description_bn',200)->nullable();
            $table->integer('order_by')->nullable();
            $table->integer('status')->default(1)->comment("0 = inactive & 1 = active");
            $table->string('image')->default('0')->nullable();
            $table->date('deleted_at')->nullable();
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
        Schema::dropIfExists('teacher_cruds');
    }
};

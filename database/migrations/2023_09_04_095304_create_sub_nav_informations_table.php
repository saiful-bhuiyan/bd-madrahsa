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
        Schema::create('sub_nav_informations', function (Blueprint $table) {
            $table->id();
            $table->integer('nav_id')->nullable();
            $table->integer('sub_nav_id')->nullable();
            $table->string('title_en',50)->nullable();
            $table->string('title_bn',50)->nullable();
            $table->text('description_en',250)->nullable();
            $table->text('description_bn',250)->nullable();
            $table->string('image')->default('0');
            $table->integer('status')->default(1)->comment("0 = Inactive & 1 = Active");
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
        Schema::dropIfExists('sub_nav_informations');
    }
};

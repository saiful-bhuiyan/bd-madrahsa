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
        Schema::create('banner_images', function (Blueprint $table) {
            $table->id();
            $table->string('title_en',50)->nullable();
            $table->string('title_bn',50)->nullable();
            $table->text('description_en',250)->nullable();
            $table->text('description_bn',250)->nullable();
            $table->string('image')->default('0');
            $table->integer('order_by')->nullable();
            $table->integer('status')->default(1)->comment("0 = inactive & 1 = Active");
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
        Schema::dropIfExists('banner_images');
    }
};

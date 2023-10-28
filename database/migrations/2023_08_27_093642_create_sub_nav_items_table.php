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
        Schema::create('sub_nav_items', function (Blueprint $table) {
            $table->id();
            $table->integer('nav_id')->unsigned();
            $table->foreign('nav_id')->references('id')->on('nav_items');
            $table->string('sub_nav_name_en',50)->nullable();
            $table->string('sub_nav_name_bn',50)->nullable();
            $table->string('route_name',50)->nullable();
            $table->integer('order_by')->nullable();
            $table->integer('status')->default(1)->comment("0 = Inactive & 1 = Active");
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
        Schema::dropIfExists('sub_nav_items');
    }
};

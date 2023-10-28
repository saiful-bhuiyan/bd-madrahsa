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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('menu_name_en',100)->nullable();
            $table->string('menu_name_bn',100)->nullable();
            $table->string('icon',100)->nullable();
            $table->integer('order_by')->nullable();
            $table->string('route_name')->nullable();
            $table->integer('type')->nullable()->comment('1= Parent, 2= Module');
            $table->integer('status')->nullable()->comment('1= Active, 0= Inactive');
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
        Schema::dropIfExists('menus');
    }
};

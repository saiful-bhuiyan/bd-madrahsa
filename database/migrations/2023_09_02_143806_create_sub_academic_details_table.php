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
        Schema::create('sub_academic_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ad_id')->unsigned();
            $table->foreign('ad_id')->references('id')->on('academic_details');
            $table->string('item_name_en')->nullable();
            $table->string('item_name_bn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_bn')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->string('image')->default('0')->nullable();
            $table->integer('status')->default(1)->comment("0 = inactive & 1 = active");
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
        Schema::dropIfExists('sub_academic_details');
    }
};

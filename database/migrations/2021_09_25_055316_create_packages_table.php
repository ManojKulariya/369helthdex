<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->string('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->double('mrp', 8, 2)->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->bigInteger('paramter_included')->nullable();
            $table->enum('sample_collection', ['1', '2'])->comment("1=>free,2=>paid")->default(1);
            $table->double('sample_collection_fee', 8, 2)->nullable();
            $table->string('report_time')->nullable();
            $table->enum('fasting_time', ['0', '1'])->comment("0=>no,1=>yes")->default(0);
            $table->string('fast_time')->nullable();
            $table->string('test_recommended_for')->nullable();
            $table->string('test_recommended_for_age')->nullable();
            $table->string('realted_package')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('packages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->double('mrp', 8, 2)->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->enum('sample_collection', ['1', '2'])->comment("1=>free,2=>paid")->default(1);
            $table->double('sample_collection_fee', 8, 2)->nullable();
            $table->string('report_time')->nullable();
            $table->enum('fasting_time', ['0', '1'])->comment("0=>no,1=>yes")->default(1);
            $table->string('fast_time')->nullable();
            $table->string('test_recommended_for')->nullable();
            $table->string('test_recommended_for_age')->nullable();
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
        Schema::dropIfExists('parameters');
    }
}

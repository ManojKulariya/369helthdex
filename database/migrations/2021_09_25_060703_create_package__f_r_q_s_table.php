<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageFRQSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package__f_r_q_s', function (Blueprint $table) {
            $table->id();
            $table->longText('question')->nullable();
            $table->enum('type', ['1', '2'])->comment("1=>package,2=>parameters")->default(1);
            $table->longText('ans')->nullable();
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
        Schema::dropIfExists('package__f_r_q_s');
    }
}

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
        Schema::create('fees_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('year');
            $table->foreign('year')->references('id')->on('academic_year');
            
            $table->unsignedBigInteger('fee_head');
            $table->foreign('fee_head')->references('id')->on('fees_heads');

            $table->unsignedBigInteger('class');
            $table->foreign('class')->references('id')->on('classes');

            $table->bigInteger('tuition')->nullable()->default(0);
            $table->bigInteger('amount')->nullable()->default(0);

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
        Schema::dropIfExists("fees_details");
    }
};

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
        Schema::create('admission', function (Blueprint $table) {
            $table->id();
            $table->date("date_of_adm");

            $table->unsignedBigInteger('year');
            $table->foreign('year')->references('id')->on('academic_year');

            $table->unsignedBigInteger('caste');
            $table->foreign('caste')->references('id')->on('caste');

            $table->unsignedBigInteger('class');
            $table->foreign('class')->references('id')->on('classes');

            $table->bigInteger("sts");
            $table->string("name", 50);
            $table->string("fname", 50);
            $table->string("mname", 50);
            $table->string("lname", 50);
            $table->string("address", 255);
            $table->string("city");
            $table->string("phone");
            $table->string("mobile");
            $table->date("dob");
            $table->string("birth_place");
            
            $table->unsignedBigInteger('sub_district');
            $table->foreign('sub_district')->references('id')->on('sub_district');

            $table->string("religion");
            $table->string("nationality");
            $table->integer("gender");
            $table->boolean("handicap");

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
        //
    }
};

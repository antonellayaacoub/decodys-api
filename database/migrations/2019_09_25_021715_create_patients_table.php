<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("firstname");
            $table->string("lastname")->nullable();
            $table->string("email")->nullable();
            $table->string("phonenumber");
            $table->string("country_code")->nullable();
            $table->string("image_file")->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string("sex")->nullable();
            $table->string("school")->nullable();
            $table->string("class")->nullable();
            $table->string("address")->nullable();
            $table->string("father_profession")->nullable();
            $table->string("mother_profession")->nullable();
            $table->string("number_of_kids")->nullable();
            $table->string("home_language")->nullable();
            $table->string("activity")->nullable();
           
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
        Schema::dropIfExists('patients');
    }
}

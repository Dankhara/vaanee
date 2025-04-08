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
        Schema::create('user_voice_profile_scripts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('language_code', 10);
            $table->string('accent', 100);
            $table->string('style', 100);
            $table->string('gender', 20);
            $table->string('age_group', 50);
            $table->string('emotions', 100);
            $table->string('pitch', 100);
            $table->unsignedBigInteger('voice_clone_script_language_script_id');
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
        Schema::dropIfExists('user_voice_profile_scripts');
    }
};

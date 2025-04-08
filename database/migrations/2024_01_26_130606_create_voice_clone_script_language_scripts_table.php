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
        Schema::create('voice_clone_script_language_scripts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voice_clone_script_language_id');
            $table->longText('voice_script');
            $table->timestamps();
            $table->foreign('voice_clone_script_language_id', 'fk_voice_script_language')
                ->references('id')
                ->on('voice_clone_script_languages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voice_clone_script_language_scripts');
    }
};

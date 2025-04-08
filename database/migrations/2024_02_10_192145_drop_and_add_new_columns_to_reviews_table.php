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
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['position', 'image_url']);
            $table->after('name', function () use ($table) {
                $table->string('designation')->nullable();
                $table->string('company_name')->nullable();
                $table->string('rating', 3);
                $table->text('customer_image_url')->nullable();
                $table->text('company_logo_url')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::table('careers', function (Blueprint $table) {
            $table->string('job_category');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('salary', 15, 2)->nullable()->default(0);
            $table->string('salary_type', 100)->nullable()->default('Permonth');
            $table->string('no_of_positions', 5)->nullable()->default('1');
            $table->string('education', 100)->nullable();
            $table->string('job_type', 100)->nullable()->default('Fulltime');
            $table->string('duration', 50)->nullable()->default('Permanent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            //
        });
    }
};

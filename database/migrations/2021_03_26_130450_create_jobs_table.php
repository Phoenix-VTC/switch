<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('trucksbook_username');
            $table->integer('trucksbook_job_id')->unique();
            $table->string('game');
            $table->string('from');
            $table->string('to');
            $table->string('cargo');
            $table->integer('damage');
            $table->integer('xp');
            $table->integer('profit');
            $table->integer('planned_distance');
            $table->integer('driven_distance');
            $table->integer('weight');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}

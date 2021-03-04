<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_id');
            $table->foreign('target_id')
            ->references('id')
            ->on('targets')
            ->onDelete('cascade');
            $table->string('task_title');
            $table->string('period_kind')
            ->nullable();
            $table->date('start_date')
            ->nullable();
            $table->date('end_date')
            ->nullable();
            $table->boolean('is_done')
            ->default(false);
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
        Schema::dropIfExists('tasks');
    }
}

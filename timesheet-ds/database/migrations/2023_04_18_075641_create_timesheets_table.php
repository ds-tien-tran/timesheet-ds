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
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('day_selected')->nullable(false);
            $table->text('plan');
            $table->text('note');
            $table->tinyInteger('status')->nullable(false)->default(1)->comment('1:open, 2:approve, 3:reject');
            $table->tinyInteger('dayoff')->nullable(false)->default(0)->comment('Check xem nv có nghỉ  1:yes 0:no');
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
        Schema::dropIfExists('timesheets');
    }
};

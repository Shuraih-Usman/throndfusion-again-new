<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contexts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->bigInteger('user_id')->unsigned();
            $table->string('image_folder');
            $table->string('image');
            $table->string('video');
            $table->double('first_reward')->default(0);
            $table->double('second_reward')->default(0);
            $table->double('third_reward')->default(0);
            $table->double('fourth_reward')->default(0);
            $table->double('fifth_reward')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contexts');
    }
};

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
        Schema::create('context_submission', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('context_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('link');
            $table->double('views');
            $table->double('quality_score');
            $table->integer('status')->default(2);
            $table->foreign('context_id')->references('id')->on('contexts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('context_submission');
    }
};

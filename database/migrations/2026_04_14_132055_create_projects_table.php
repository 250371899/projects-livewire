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
 
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->string('title');
            $table->string('description');
            $table->date("start_date");
            $table->date('end_date'); 
            $table->enum('phase', ['design','development','testing', 'deployment', 'complete'])->default('design');
            $table->timestamps();
            $table->foreignId('uid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

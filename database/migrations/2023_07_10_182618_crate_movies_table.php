<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('director');
            $table->json('description');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->json('genre')->nullable();
            $table->integer('year');
        });
    }

    public function down(): void
    {

        Schema::dropIfExists('movies');
    }
};

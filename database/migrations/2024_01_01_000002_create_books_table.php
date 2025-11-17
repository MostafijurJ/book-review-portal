<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('synopsis')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->string('cover_image')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('genre')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();
            
            $table->index(['title', 'author']);
            $table->index('genre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};


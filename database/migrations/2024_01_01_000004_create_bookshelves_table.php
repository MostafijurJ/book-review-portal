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
        Schema::create('bookshelves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['want_to_read', 'currently_reading', 'read'])->default('want_to_read');
            $table->date('date_added')->default(now());
            $table->date('date_started')->nullable();
            $table->date('date_finished')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'book_id']); // One entry per user per book
            $table->index('user_id');
            $table->index('book_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('bookshelves');
    }
};


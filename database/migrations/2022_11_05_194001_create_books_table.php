<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('isbn');
            $table->json('authors');
            $table->integer('number_of_pages');
            $table->string('publisher');
            $table->string('country');
            $table->date('release_date');
            $table->timestamps();
            $table->unique(['name', 'isbn']);
            $table->index(['name', 'publisher', 'country', 'release_date'], 'search_index_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('books');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordFrequenciesTable extends Migration
{
    public function up()
    {
        Schema::create('word_frequencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->json('frequencies');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('word_frequencies');
    }
}
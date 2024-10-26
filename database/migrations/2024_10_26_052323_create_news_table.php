<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->uuid('feed_id');
            $table->foreignId('country_id')->constrained()->onDelete('cascade'); // Relação com o modelo Country
            $table->string('title_pt')->nullable();
            $table->string('title_es')->nullable();
            $table->string('title_en')->nullable();
            $table->text('text_pt')->nullable();
            $table->text('text_es')->nullable();
            $table->text('text_en')->nullable();
            $table->text('ai_comments_pt')->nullable();
            $table->text('ai_comments_es')->nullable();
            $table->text('ai_comments_en')->nullable();
            $table->string('link')->nullable();
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('revised_at')->nullable();
            $table->timestamps();

            $table->index('feed_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}

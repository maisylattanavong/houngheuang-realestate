<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_multiple_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class);
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_multiple_images');
    }
};

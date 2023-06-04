<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realestate_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('realestate_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->unique();

            $table->string('location')->nullable();
            $table->text('address')->nullable();

            $table->unique(['realestate_id', 'locale']);
            $table->foreign('realestate_id')->references('id')
            ->on('realestates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realestate_translations');
    }
};

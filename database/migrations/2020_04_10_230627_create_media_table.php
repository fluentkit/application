<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('disk');
            $table->string('name');
            $table->string('filename');
            $table->string('path');
            $table->string('extension');
            $table->string('mime_type');
            $table->json('metadata');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->linkToApp();
            $table->unique(['app_id', 'filename']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}

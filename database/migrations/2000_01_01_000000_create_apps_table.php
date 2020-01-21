<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('master');
            $table->timestamps();
        });

        Schema::create('app_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('domain');
            $table->timestamps();

            $table->linkToApp();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_domains');
        Schema::dropIfExists('apps');
    }
}

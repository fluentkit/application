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
            $table->boolean('master')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('app_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('domain');
            $table->softDeletes();
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

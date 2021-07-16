<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skins', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->string('platform')->nullable();

            $table->string('app_id')->nullable();

            $table->longText('description')->nullable();

            $table->string('filepath');

            $table->string('filename');

            $table->string('skinimage');

            $table->json('skinsliderimages');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skins');
    }
}

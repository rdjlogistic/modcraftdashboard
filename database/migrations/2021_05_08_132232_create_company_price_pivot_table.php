<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPricePivotTable extends Migration
{
    public function up()
    {
        Schema::create('company_price', function (Blueprint $table) {
            $table->unsignedInteger('company_id');

            $table->foreign('company_id', 'company_id_fk_344257')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedInteger('price_id');

            $table->foreign('price_id', 'price_id_fk_344257')->references('id')->on('prices')->onDelete('cascade');
        });
    }
}





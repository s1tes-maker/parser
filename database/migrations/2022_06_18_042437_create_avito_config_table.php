<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvitoConfigTable extends Migration
{
    protected $connection = "mysql2";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->integer('count');
            $table->string('profile')->nullable();
            $table->boolean('suggest_price');
            $table->text('suggest_price_message')->nullable();
            $table->tinyInteger('discount_min')->nullable();
            $table->tinyInteger('discount_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}

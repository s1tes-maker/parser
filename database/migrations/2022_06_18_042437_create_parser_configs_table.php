<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParserConfigsTable extends Migration
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
            $table->json('avito_data');
            $table->integer('process_id')->unique();
            $table->string('status')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('python_message')->nullable();
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

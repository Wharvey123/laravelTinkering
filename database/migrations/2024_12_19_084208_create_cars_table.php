<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('make'); // Marca
            $table->string('model'); // Model
            $table->integer('year'); // Any de producció
            $table->float('price', 10, 2); // Preu amb decimals
            $table->text('description'); // Descripció
            $table->timestamps(); // Camps created_at i updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
};

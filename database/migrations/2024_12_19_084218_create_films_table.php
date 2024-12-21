<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('name'); // Nom de la pel·lícula
            $table->string('director'); // Nom del director
            $table->integer('year'); // Any de producció
            $table->text('description'); // Descripció
            $table->timestamps(); // Camps created_at i updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('films');
    }
};


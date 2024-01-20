<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recomendation_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_recomendation')->nullable();
            $table->foreign('id_recomendation')->references('id')->on('recomendations');
            $table->unsignedBigInteger('id_menu')->nullable();
            $table->foreign('id_menu')->references('id')->on('menus');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recomendation_detail');
    }
};

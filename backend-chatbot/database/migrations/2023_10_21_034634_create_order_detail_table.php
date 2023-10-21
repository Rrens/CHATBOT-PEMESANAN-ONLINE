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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order')->nullable();
            $table->foreign('id_order')->references('id')->on('orders');
            $table->unsignedBigInteger('id_menu')->nullable();
            $table->foreign('id_menu')->references('id')->on('menus');
            $table->unsignedBigInteger('id_promo')->nullable();
            $table->foreign('id_promo')->references('id')->on('promos');
            $table->decimal('promo_amount')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('quantity');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};

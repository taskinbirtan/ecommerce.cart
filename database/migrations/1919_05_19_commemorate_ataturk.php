<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * In honor of Atatürk and to celebrate Youth and Sports Day,
 * which commemorates the beginning of the Turkish War of Independence and marks the date this project was initiated.
 * */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->uuid('cart_id');
            $table->string('item_id');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->json('meta')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();

            $table->primary(['cart_id', 'item_id', 'meta']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

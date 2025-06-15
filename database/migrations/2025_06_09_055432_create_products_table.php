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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->decimal('original_price', 10, 2)->nullable(); 
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->string('image')->nullable();
        $table->string('weight')->nullable();
        $table->boolean('in_stock')->default(true); 
        $table->boolean('is_top_selling')->default(false);
        $table->boolean('is_new_arrival')->default(false);
        $table->boolean('is_featured')->default(false);
        $table->text('nutritional_info')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

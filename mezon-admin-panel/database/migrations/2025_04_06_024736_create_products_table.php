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
            $table->string('slug')->unique();
        
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('primary_image');
            $table->text('description');
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->boolean('status')->default(1);
        
            $table->unsignedInteger('sale_price')->default(0);
            $table->timestamp('date_on_sale_from')->nullable();
            $table->timestamp('date_on_sale_to')->nullable();
        
            $table->boolean('is_featured')->default(0);
        
            $table->unsignedInteger('view_count')->default(0);
        
            $table->timestamps();
            $table->softDeletes();
        

            $table->index('name');
            $table->index('status');
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

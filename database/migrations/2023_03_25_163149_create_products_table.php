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

            $table->string('title');
            $table->string('description', 2000)->nullable();
            $table->jsonb('content')->nullable();
            $table->string('preview_image')->nullable();

            $table->integer('vendor_code')->unique();

            $table->decimal('price');
            $table->integer('count');
            $table->boolean('is_published')->default(0);

            $table->foreignId('category_id')->nullable()->index()->constrained('categories');
            $table->softDeletes();
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

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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
            ->on('categories')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('name');
            $table->integer('disc_percent');
            $table->string('image')->nullable();
            $table->enum('is_active', [0, 1])->default(1)->comment('0 = inactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};

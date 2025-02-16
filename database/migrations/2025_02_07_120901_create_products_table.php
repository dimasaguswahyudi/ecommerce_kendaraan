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

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
            ->on('categories')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')
            ->on('discounts')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('name');
            $table->string('slug');
            $table->integer('price');
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->enum('is_active', [0, 1])->default(1)->comment('0 = inactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();

            
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')
            ->on('users')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')
            ->on('users')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('deleted_by')
            ->on('users')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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

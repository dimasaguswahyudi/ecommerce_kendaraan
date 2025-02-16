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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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
        Schema::dropIfExists('banners');
    }
};

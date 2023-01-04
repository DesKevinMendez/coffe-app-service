<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->text('description')->nullable();
            $table->double('price');
            $table->boolean('isUnit');
            $table->boolean('isActive');
            $table->boolean('isTemporary');
            $table->foreignId('user_id')->on('users');
            $table->foreignId('commerce_id')->on('commerces');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

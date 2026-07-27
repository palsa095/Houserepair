<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('label')->nullable();
            $table->text('address_line');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->index(['customer_id', 'is_default']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
};

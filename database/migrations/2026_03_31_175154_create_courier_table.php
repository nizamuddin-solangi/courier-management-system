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
        Schema::create('courier', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('sender_name',50);
            $table->string('sender_phone',11);
            $table->text('sender_address',255);
            $table->string('receiver_name',50);
            $table->string('receiver_phone',11);
            $table->text('receiver_address',255);
            $table->string('from_city',50);
            $table->string('to_city',50);
            $table->string('parcel_type',50);
            $table->float('weight');
            $table->decimal('price', 10, 2);
            $table->enum('status', [
                'pending',
                'in_transit',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier');
    }
};

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
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->string('sender_name', 50);
            $table->string('sender_phone', 15);
            $table->text('sender_address');
            $table->string('receiver_name', 50);
            $table->string('receiver_phone', 15);
            $table->text('receiver_address');
            $table->string('from_city', 50);
            $table->string('to_city', 50);
            $table->date('delivery_date')->nullable();
            $table->string('parcel_type', 50);
            $table->float('weight');
            $table->decimal('price', 10, 2);
            $table->enum('status', [
                'pending',
                'in_transit',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->foreign('agent_id')
                ->references('id')
                ->on('agents')
                ->onDelete('set null');

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

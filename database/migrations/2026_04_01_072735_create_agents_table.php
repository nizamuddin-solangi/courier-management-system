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
        Schema::create('agents', function (Blueprint $table) {
        $table->id();
        $table->string('name', 50);
        $table->string('email')->unique();
        $table->string('phone', 15);
        $table->string('username')->unique();
        $table->string('password');
        $table->string('branch_name', 100);
        $table->string('city', 50);        
        $table->string('from_city', 50);   
        $table->string('to_city', 50);     
        $table->boolean('is_active')->default(true);
        $table->string('agent_code')->unique(); 
        $table->text('address')->nullable();
        $table->timestamps();
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};

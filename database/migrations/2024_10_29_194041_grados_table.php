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
        Schema::create('grados', function (Blueprint $table) {
            $table->increments('idgrado');  
            $table->string('descricpion', 50); 
            $table->string('abreviatura', 30); 
            $table->boolean('status');         // varchar(50)
            $table->timestamps();  // created_at & updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grados');
    }
};

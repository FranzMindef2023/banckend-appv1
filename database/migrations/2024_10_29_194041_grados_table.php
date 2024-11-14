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
            $table->string('grado', 50); 
            $table->string('abregrado', 30); 
            $table->string('categoria', 30); 
            $table->boolean('status');         // varchar(50)
            $table->timestamps();  // created_at & updated_at timestamps
        });
        DB::table('grados')->insert([
            'grado' => 'EJERCITO DE BOLIVIA',
            'abregrado' => 'EJERCITO DE BOLIVIA',
            'categoria' => 'EJERCITO DE BOLIVIA',
            'status' => true],
            [
            'grado' => 'EJERCITO DE BOLIVIA',
            'abregrado' => 'EJERCITO DE BOLIVIA',
            'categoria' => 'EJERCITO DE BOLIVIA',
            'status' => true
            ],
            [
            'grado' => 'EJERCITO DE BOLIVIA',
            'abregrado' => 'EJERCITO DE BOLIVIA',
            'categoria' => 'EJERCITO DE BOLIVIA',
            'status' => true
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grados');
    }
};

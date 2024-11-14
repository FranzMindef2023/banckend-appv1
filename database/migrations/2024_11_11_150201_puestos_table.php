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
        Schema::create('puestos', function (Blueprint $table) {
            $table->bigIncrements('idpuesto');  // Usamos bigIncrements para bigint como PK
            $table->string('nompuesto');        // Nombre de la organización
            $table->boolean('status');  
            $table->timestamps();            // created_at y updated_at
        });
        DB::table('puestos')->insert([
            'nompuesto' => 'MINISTRO',
            'status' => true],
            [
            'nompuesto' => 'VICEMINISTRO',
            'status' => true
            ],
            [
            'nompuesto' => 'DIRECTOR GENERAL',
            'status' => true
            ],
            [
            'nompuesto' => 'JEFE DE UNIDAD',
            'status' => true
            ],
            [
            'nompuesto' => 'RESPONSABLE DE SECCIÓN',
            'status' => true
            ],
            [
            'nompuesto' => 'TECNICO',
            'status' => true
            ],
            [
            'nompuesto' => 'SEGURIDAD',
            'status' => true
            ],
            [
            'nompuesto' => 'COMANDANTE',
            'status' => true
            ],
            [
            'nompuesto' => 'JEFE DE GABINETE',
            'status' => true
            ],
            [
            'nompuesto' => 'AYUDANTE',
            'status' => true
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};

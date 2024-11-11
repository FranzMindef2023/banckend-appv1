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
            $table->string('sigla', 50);     // Sigla de la organización
            $table->unsignedBigInteger('idorg'); // idpadre como bigint, nullable si puede ser raíz
            $table->timestamps();            // created_at y updated_at

            // Foreign keys
            $table->foreign('idorg')->references('idorg')->on('organizacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};

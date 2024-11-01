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
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('idpersona');                  // int8, primary key
            $table->string('nombres');                  // varchar, no length specified, but could be added
            $table->string('priemerapellido', 50);         // varchar(50)
            $table->string('segundoapellido', 50);       // varchar(50)
            $table->string('codpersona', 50);       // varchar(50)
            $table->string('numerodocumento', 250)->uniqid;          // varchar(250)
            $table->bigInteger('complemento');         // int8
            $table->string('fechadenac', 30);         // varchar(30)
            $table->string('celular', 250);       // varchar(250)
            $table->boolean('status');             // bool
            $table->timestamps();                  // created_at & updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

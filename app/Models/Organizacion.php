<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Organizacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable;
    // Define el nombre correcto de la tabla
    protected $table = 'organizacion';
    // Establecer la clave primaria
    protected $primaryKey = 'idorg';

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'nomorg',
        'sigla',
        'idpadre'
    ];
}

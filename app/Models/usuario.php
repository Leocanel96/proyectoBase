<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario extends Model
{
    //en caso no se llame el modelo igual a la tabla
    protected $table = "usuario";

    //Esto es solo si la llave primaria de la tabla no es id
    protected $primaryKey = "id_usuario";
    public $timestamps = false;
}

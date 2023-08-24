<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class platillo extends Model
{
    //en caso no se llame el modelo igual a la tabla
    protected $table = "platillo";

    //Esto es solo si la llave primaria de la tabla no es id
    protected $primaryKey = "id_platillo";
    public $timestamps = false;

}

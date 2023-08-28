<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipo_platillo extends Model
{
    //en caso no se llame el modelo igual a la tabla
    protected $table = "tipo_platillo";

    //Esto es solo si la llave primaria de la tabla no es id
    protected $primaryKey = "id_tipo";
    public $timestamps = false;
}

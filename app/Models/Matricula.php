<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matricula extends Model
{
        //nombre de la tabla
    protected $table = 'matricula';
    
    //campos que hay que rellenar antes de guardar un objeto en la base de datos
    protected $fillable = ['alumno_id', 'curso', 'modulo_id', 'nota'];

   /* public function alumno(){
        return $this->belongsTo('App\Models\Alumno');
    }*/
      public function alumnoV2(): BelongsTo {
        return $this->belongsTo(Alumno::class);
    }
     public function modulo(): BelognsTo{
        return $this->belongsTo(Modulo::class);
    }
}

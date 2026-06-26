<?php
use Illuminate\Database\Eloquent\Model;

class Offerts extends Model {

    protected $table = 'ofertas';
    protected $fillable = ['consecutivo', 'objeto','descripcion', 'moneda', 'presupuesto', 'actividad_id', 'fecha_inicio', 'hora_inicio', 'fecha_cierre', 'hora_cierre', 'estado'];
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    //public $timestamps = false;

}
<?php
use Illuminate\Database\Eloquent\Model;

class OfferDocuments extends Model {

    protected $table = 'ofertas_documentos';
    protected $fillable = ['licitacion_id', 'titulo','descripcion', 'archivo'];
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIntencao extends Model
{
    use HasFactory;

    protected $table = 'tipo_intencao';
    protected $primaryKey = 'id_tipo_intencao';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'no_tipo_intencao',
    ];
}
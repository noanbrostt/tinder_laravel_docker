<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInteracao extends Model
{
    use HasFactory;

    protected $table = 'tipo_interacao';
    protected $primaryKey = 'id_tipo_interacao';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'no_tipo_interacao',
    ];
}
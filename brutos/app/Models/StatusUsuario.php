<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusUsuario extends Model
{
    use HasFactory;

    protected $table = 'status_usuario';
    protected $primaryKey = 'id_status_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'no_status_usuario',
    ];
}
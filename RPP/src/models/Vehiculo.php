<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model{
    protected $primaryKey = 'patente';
    protected $keyType = 'string';
    public $timestamps = false;
}
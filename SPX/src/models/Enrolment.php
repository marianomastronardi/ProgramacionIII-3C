<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model{
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
}
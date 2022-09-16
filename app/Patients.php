<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    //
    protected $table = "patients";
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

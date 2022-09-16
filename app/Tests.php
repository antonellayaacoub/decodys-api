<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tests extends Model
{
    //
    protected $table = "tests";
    public function user()
    {
        return $this->belongsTo(Patient::class);
    }

}

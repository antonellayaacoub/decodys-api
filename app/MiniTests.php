<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniTests extends Model
{
    //
    protected $table = "miniTests";
    public function user()
    {
        return $this->belongsTo(Test::class);
    }

}

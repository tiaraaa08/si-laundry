<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
   protected $table = 'transaksi';
    protected $guarded = [];
    // $timestamps = false;
     public $timestamps = false;

      public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id');
    }
}

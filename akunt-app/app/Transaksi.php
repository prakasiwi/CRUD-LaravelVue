<?php

namespace App;

use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //use HasFactory;

    protected $fillable = ['title', 'amount', 'time', 'type'];
}

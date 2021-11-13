<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Kategori extends Model
{
    protected $table = 'tbl_kategori';
    protected $fillable = ['nama_kategori'];
}

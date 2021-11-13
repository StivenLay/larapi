<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tbl_barang';
    protected $fillable = ['nama_barang', 'nama_kategori', 'price'];
}

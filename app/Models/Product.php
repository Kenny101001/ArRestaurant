<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = "Products";

    protected $primaryKey = 'id';

    // Les colonnes de la table que vous souhaitez autoriser à remplir
    protected $fillable = [ 'id','name','image_url','usdz_url','date'];
}

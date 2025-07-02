<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class typeEntreprise extends Model
{
    use HasFactory;

    protected $table = "typeEntreprise";

    protected $primaryKey = 'id';

    // Les colonnes de la table que vous souhaitez autoriser à remplir
    protected $fillable = [ 'id','type'];
}

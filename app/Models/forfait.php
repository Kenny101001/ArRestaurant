<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class forfait extends Model
{
    use HasFactory;

    protected $table = "forfait";

    protected $primaryKey = 'id';

    // Les colonnes de la table que vous souhaitez autoriser à remplir
    protected $fillable = [ 'id','nom','prix','nb3d'];
}

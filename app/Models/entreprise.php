<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class entreprise extends Model
{
    use HasFactory;

    protected $table = "entreprise";

    protected $primaryKey = 'id';

    // Les colonnes de la table que vous souhaitez autoriser à remplir
    protected $fillable = [ 'id','nom','logo','adresse','type_entreprise','phone','email','siteWeb','forfait','date_ajout','mdp','actif'];
}

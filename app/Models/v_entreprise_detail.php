<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class v_entreprise_detail extends Model
{
    use HasFactory;

    protected $table = 'v_entreprise_detail';

    protected $primaryKey = 'entreprise_id';

    // Les colonnes de la table que vous souhaitez autoriser à remplir
    protected $fillable = [ 'id','nom','logo','adresse','type_entreprise','type','phone','email','siteWeb','forfait','forfait_nom','forfait_nb3d','date_ajout','mdp','actif','nb_produit'];
}

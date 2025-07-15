<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class v_produit_detail extends Model
{
    use HasFactory;

    protected $table = "produit";

    protected $primaryKey = 'id';

    // Les colonnes de la table que vous souhaitez autoriser à remplir
    protected $fillable = [ 'id','nom','url_3d','url_image','id_entreprise','entreprise_nom','id_type_plat','type_plat_nom','code','date_ajout'];
}

@extends('layouts.base')

@section('content')

<div style="padding: 2em;">
    @if ($errors->any())
        <div style="font-family: 'Montserrat', sans-serif;color: #d00000;" class="">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div style="font-family: 'Montserrat', sans-serif; color: #52b788;" class="" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <button class="btn btn-lg btn-block" type="button" style="background-color: #FFCC00; border-color: transparent; color: white;" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Ajouter des object 3D
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content" style="padding-left: 1rem; padding-right: 1rem; width:120%">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter des object 3D</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="insertObjet3d" method="POST" action="{{ route('ajouterObjet3d') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="apple3d" name="apple3d[]" accept=".usdz" multiple>
                            <label for="apple3d" class="form-label">Importer vos fichiers 3D en format .usdz</label>
                        </div>

                        <div class="mb-3">
                            <select class="form-select" aria-label="typePlat" name="typePlat" id="typePlat" required>

                                <option value="" disabled selected>Choisissez le type de plat</option>
                                @foreach ($type_plats as $type_plat)
                                    <option value="{{ $type_plat->id }}">{{ $type_plat->nom }}</option>
                                @endforeach
                                <option value="new">Nouveau type de plat +</option>

                            </select>
                            <input type="text" class="form-control mt-2" id="new_typePlat" name="new_typePlat" placeholder="Nom du nouveau type de plat" style="display: none;">

                            <label for="type" class="form-label">Type de l'entreprise</label>
                        </div>

                        <script>
                            document.getElementById('typePlat').addEventListener('change', function() {
                                var newClientInput = document.getElementById('new_typePlat');
                                if (this.value === 'new') {
                                    newClientInput.style.display = 'block';
                                    newClientInput.required = true;
                                } else {
                                    newClientInput.style.display = 'none';
                                    newClientInput.required = false;
                                }
                            });
                        </script>

                        <input type="hidden" id="entrepriseId" name="entrepriseId" value="{{ $id }}">

                        <button type="submit" class="btn btn-lg btn-block" style="background-color: #FFCC00; border-color: transparent; color: white;" >Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Liste des produits</h2>

    @php
    use Jenssegers\Agent\Agent;
    $agent = new Agent();
    @endphp

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($produits as $produit)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">

                    {{-- Image preview statique --}}
                    <div class="card-img-top position-relative" style="background-color: #f5f5f5; min-height: 180px;">
                        <div class="card-imgs pv" data-quicklook="true"></div>
                    </div>

                    {{-- Contenu de la carte --}}
                    <div class="card-body d-flex flex-column justify-content-between p-3">
                        <div>
                            <h5 class="card-title mb-2">{{ $produit->nom }}</h5>
                            <span class="badge bg-secondary mb-2">{{ $produit->type_plat_nom }}</span>

                            {{-- Bouton AR / Téléchargement --}}
                            @php $usdzUrl = Storage::url($produit->url_3d); @endphp

                            @if ($agent->isiOS())
                                <a href="{{ $usdzUrl }}" rel="ar" class="btn btn-outline-primary btn-sm w-100 mt-2">
                                    <i class="bi bi-eye"></i> Voir en réalité augmentée
                                </a>
                            @else
                                <a href="{{ $usdzUrl }}" download class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                    <i class="bi bi-download"></i> Télécharger le modèle 3D
                                </a>
                            @endif
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('modifierProduit', $produit->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </a>

                            <form action="{{ route('supprimerProduit', $produit->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash3"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>




</div>

@endsection

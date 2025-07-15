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
            Ajouter une nouvelle entreprise
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content" style="padding-left: 1rem; padding-right: 1rem; width:120%">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une nouvelle entreprise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="insertEntreprise" method="POST" action="{{ route('ajouterEntreprise') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="text" class="form-control" id="nom" name="nom" required>
                            <label for="nom" class="form-label">Nom de l'entreprise</label>
                        </div>

                        <div class="mb-3">
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" >
                            <label for="logo" class="form-label">Logo</label>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" id="adresse" name="adresse" required>
                            <label for="adresse" class="form-label">Adresse</label>
                        </div>

                        <div class="mb-3">
                            <select class="form-select" aria-label="Type" name="type" id="type" required>
                                <option value="" disabled selected>Choisissez le type</option>
                                @foreach ($typeEntreprises as $typeEntreprise)
                                    <option value="{{ $typeEntreprise->id }}">{{ $typeEntreprise->type }}</option>
                                @endforeach
                                <option value="new">Nouveau type +</option>
                            </select>
                            <input type="text" class="form-control mt-2" id="new_typeEntreprise" name="new_typeEntreprise" placeholder="Nom du nouveau type d'entreprise" style="display: none;">

                            <label for="type" class="form-label">Type de l'entreprise</label>
                        </div>

                        <script>
                            document.getElementById('type').addEventListener('change', function() {
                                var newClientInput = document.getElementById('new_typeEntreprise');
                                if (this.value === 'new') {
                                    newClientInput.style.display = 'block';
                                    newClientInput.required = true;
                                } else {
                                    newClientInput.style.display = 'none';
                                    newClientInput.required = false;
                                }
                            });
                        </script>

                        <div class="mb-3">
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" required>
                            <label for="email" class="form-label">Email</label>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="website" name="website">
                            <label for="website" class="form-label">Site web</label>
                        </div>

                        <div class="mb-3">
                            <select class="form-select" aria-label="forfait" name="forfait" required>
                                <option value="" disabled selected>Choisissez le forfait</option>
                                @foreach ($forfaits as $forfait)
                                    <option value="{{ $forfait->id }}">{{ $forfait->nom }} ({{ $forfait->prix }}€, {{ $forfait->nb3d }} modèles 3D)</option>
                                @endforeach
                            </select>
                            <label for="forfait" class="form-label">Forfait</label>
                        </div>

                        <button type="submit" class="btn btn-lg btn-block" style="background-color: #FFCC00; border-color: transparent; color: white;" >Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h2>Liste des entreprises</h2>

        <div class="row gy-4">
            @foreach ($entreprises as $entreprise)
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 d-flex flex-row align-items-center p-3" style="min-height: 180px;">

                        {{-- Logo --}}
                        <div class="me-4 flex-shrink-0">
                            <img src="{{ Storage::url($entreprise->logo) }}" alt="Logo de {{ $entreprise->nom }}" class="rounded-3" style="width: 100px; height: auto;">
                        </div>

                        {{-- Infos entreprise --}}
                        <div class="flex-grow-1">
                            <a href="{{ route('entrepriseDetail', $entreprise->id) }}" class="text-decoration-none">
                                <h3 class="mb-1">{{ $entreprise->nom }}</h3>
                            </a>
                            <h4 class="text-muted mb-2">{{ $entreprise->type }}</h4>
                            <h5 class="mb-1">{{ $entreprise->adresse }}</h5>
                            <p class="mb-0 text-muted small">
                                📞 {{ $entreprise->phone }}<br>
                                ✉️ {{ $entreprise->email }}<br>
                                🔗 <a href="{{ $entreprise->siteweb }}" target="_blank">{{ $entreprise->siteweb }}</a>
                            </p>
                        </div>

                        {{-- Nombre de modèles 3D (exemple statique) --}}
                        <div class="text-end ms-4 d-none d-md-block" style="min-width: 150px;">
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                {{ $entreprise->nb_produit ?? '0' }} modèles 3D
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('submit', '#insertEntreprise', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            const formElement = document.getElementById('insertEntreprise');
            const formData = new FormData(formElement);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            $.ajax({
                type: 'POST',
                url: '{{ route("ajouterEntreprise") }}',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                success: function (response) {
                    swalWithBootstrapButtons.fire(
                        'Succès !',
                        'L\'entreprise a été ajoutée avec succès.',
                        'success'
                    );

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Erreur s\'est produite lors de l\'ajout de l\'entreprise.';

                        for (const [key, value] of Object.entries(errors)) {
                            errorMessage += `\n${value}`;
                        }

                        swalWithBootstrapButtons.fire(
                            'Erreur!',
                            errorMessage,
                            'error'
                        );
                    }
                }
            });
        });
    });
</script> -->
@endsection

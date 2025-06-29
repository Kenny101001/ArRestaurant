@extends('layouts.base')

@section('content')

<div style="padding: 2em;">
    <div>
        <button class="btn btn-lg btn-block" type="button" style="background-color: #FFCC00; border-color: transparent; color: white;" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Ajouter une nouvelle entreprise
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une nouvelle entreprise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ajouterEntreprise') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" name="name" required>
                            <label for="name" class="form-label">Nom de l'entreprise</label>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="address" name="address" required>
                            <label for="address" class="form-label">Adresse</label>
                        </div>
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

                        <button type="submit" class="btn btn-lg btn-block" style="background-color: #FFCC00; border-color: transparent; color: white;" >Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('submit', 'form[action="{{ route('ajouterEntreprise') }}"]', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            const formData = $(this).serialize(); // Sérialise les données du formulaire

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            $.ajax({
                type: 'post',
                url: '{{ route("ajouterEntreprise") }}',
                data: formData,

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
</script>
@endsection

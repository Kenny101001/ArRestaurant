<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" sizes="76x76" type="image/png" href="../img/logo/icone2.png">
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <title>Login</title>
</head>
<body style="background-color: #fbfafa;">
<section class="vh-100" style="background-color: #fbfafa;">
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100">
      <div class="col-sm-12 col-md-8 col-lg-6 mx-auto">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">

            <div class="col-12 d-flex align-items-center">
              <div class="card-body p-5 text-black">

                <form action="{{route('loginVerifAdmin')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                  </div>

                  <div class="form-outline mb-4">
                    <input required name="email" type="email" id="form2Example17" class="form-control form-control-lg" value="{{ old('email') }}" style="font-family: 'Montserrat', sans-serif;" />
                    <label class="form-label" for="form2Example17" style="font-family: 'Montserrat', sans-serif;">Adresse e-mail</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input required name="mdp" type="password" id="form2Example27" class="form-control form-control-lg" style="font-family: 'Montserrat', sans-serif;" />
                    <label class="form-label" for="form2Example27" style="font-family: 'Montserrat', sans-serif;">Mot de passe</label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-outline-danger btn-lg btn-block" type="submit" style="font-family: 'Montserrat', sans-serif; background-color: #FFCC00; border-color: transparent; color: white;">Connexion</button>
                  </div>

                </form>

                @if ($errors->any())
                  <div style="font-family: 'Montserrat', sans-serif; color: #d00000;">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                @if (session()->has('success'))
                  <div style="font-family: 'Montserrat', sans-serif; color: #52b788;" role="alert">
                    {{ session('success') }}
                  </div>
                @endif

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>

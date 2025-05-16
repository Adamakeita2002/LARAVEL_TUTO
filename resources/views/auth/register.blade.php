<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <title>Application de Gestion Employer</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Application de Gestion Employer</h1>
                <p>Bienvenue sur notre application de gestion des employés !</p>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card mx-auto mt-1" style="width: 350px;">
                <form action="{{ route('handle.register') }}" method="POST">
                    @csrf
                    <div class="card-header text-center">
                        <h4>Espace d'inscription</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="Nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="Mot de passe" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </div>
                    <div class="card-footer text-center">
                        <p>Deja un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

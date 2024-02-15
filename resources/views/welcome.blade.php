<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <title>{{ env('APP_NAME') }} | {{ env('APP_DESCRIPTION') }}</title>
    <link rel="shortcut icon" href="https://laravel.com/img/logomark.min.svg" type="image/svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            background-color: #34495e;
        }
    </style>
</head>

<body class="bg-dark">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 text-center">
                <div class="card border-0 shadow-none py-3">
                    <div class="card-body">
                        <h1 class="mb-3 fw-bold text-white">{{ env('APP_NAME') }}</h1>
                        <p class="text-white">{{ env('APP_DESCRIPTION') }}</p>
                        <a href="{{ route('l5-swagger.default.api') }}" class="btn btn-warning text-dark">
                            <i class="fa fa-book me-2"></i>
                            View Documentation
                        </a>
                        <hr>
                        <span class="me-2 text-warning fw-bold">Build on</span>
                        <span class="text-white fw-bold">
                            <i class="fab fa-laravel me-1"></i>
                            v{{ Illuminate\Foundation\Application::VERSION }}
                        </span>
                        <span class="text-white mx-1">-</span>
                        <span class="text-white fw-bold">
                            <i class="fab fa-php me-1"></i>
                            v{{ PHP_VERSION }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>

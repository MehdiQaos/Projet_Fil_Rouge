<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('assets/css/chessboard-1.0.0.css') }} " />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.all.min.css') }}">
    <script src="{{ asset('assets/js/jquery-1.12.4.js') }}"></script>
    <script defer src="/script.js"></script>
    <link rel="stylesheet" href="/style.css">
    <title>MyChess</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        {{ $slot }}
    </div>
</body>

</html>
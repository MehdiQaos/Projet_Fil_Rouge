<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/chessboard-1.0.0.css') }} " />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
    <script src="{{ asset('assets/js/chess.0.10.3.js') }}"></script>
    <title>Document</title>
</head>
<body>
    <div class="container p-3">
        <div class="row">
            <div class="col-7">
                <div id="myBoard" style="width: 100%"></div>
            </div>
            <div class="col-5">
                <div class="border border-primary border-3 rounded-4 p-3">
                    <p id="history" class="fs-6"></p>
                <button class="btn btn-primary" id="prev">prev</button>
                <button class="btn btn-primary" id="next">next</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
        </div>
    </div>
    <script defer src="{{ asset('assets/js/pgnview.js') }}"></script>
</body>
</html>
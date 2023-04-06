<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('assets/css/chessboard-1.0.0.css') }} " />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.2/chess.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <title>Document</title>
    </head>
    <body>
        <div id="myBoard" style="width: 45%"></div>

        {{-- <script src="./js/chessboard-1.0.0.js"></script> --}}
        <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>
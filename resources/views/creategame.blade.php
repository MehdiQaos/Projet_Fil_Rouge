<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('assets/css/chessboard-1.0.0.css') }} " />
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.2/chess.js"></script> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.all.min.css') }}">
        {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
        <script src="{{ asset('assets/js/jquery-1.12.4.js') }}"></script>
        <title>Create game</title>
    </head>
    <body>
        <div><h2 id="timer1"></h2></div>
        <div id="myBoard" style="width: 400px"></div>
        <div><h2 id="timer2"></h2></div>
        <div>
            <input id="nameInput" type="text">
            <button id="connectBtn">connect</button>
        </div>
        <div>
            <button id="createGameBtn" disabled>create game</button>
            <h1 id="GameCode"></h1>
            <form>
                <input id="gameCodeInput" type="text" disabled>
                <button id="joinGameBtn" disabled>join game</button>
            </form>
        </div>

        <script src="{{ asset('assets/js/chess.0.10.3.js') }}"></script>
        <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
        <script src="{{ asset('assets/js/create_game.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
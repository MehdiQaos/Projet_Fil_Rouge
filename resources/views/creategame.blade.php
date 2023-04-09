<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('assets/css/chessboard-1.0.0.css') }} " />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.2/chess.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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

        <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
        <script src="{{ asset('assets/js/create_game.js') }}"></script>
    </body>
</html>
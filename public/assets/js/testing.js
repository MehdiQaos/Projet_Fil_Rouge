const conn = new WebSocket("ws://localhost:8090");

let game, playerColor, board;

conn.onmessage = onMessage;

function onMessage(e) {
    const data = JSON.parse(e.data);
    switch (data.type) {
        case "game":
            console.log("game", data);
            initGame(data.data);
            break;
        case "move":
            console.log("move", data);
            handleOpponentMove(data.data);
            break;
    }
}

function initGame(data) {
    game = new Chess();
    playerColor = data.color === "white" ? "w" : "b";
    const config = {
        orientation: data.color,
        draggable: true,
        position: "start",
        pieceTheme: "assets/img/chesspieces/wikipedia/{piece}.png",
        onDragStart: onDragStart,
        onDrop: onDrop,
        onSnapEnd: onSnapEnd,
    };
    board = Chessboard("myBoard", config);
}

conn.onopen = (e) => {
    console.log("conncection established");

    const payload = { type: "game" };
    conn.send(JSON.stringify(payload));
};

function onDragStart(source, piece, position, orientation) {
    // do not pick up pieces if the game is over
    if (game.game_over()) return false;

    // only pick up pieces for the side to move
    if (game.turn() !== playerColor || !isPlayerPiece(piece)) {
        return false;
    }
}

function isPlayerPiece(piece) {
    const s = "^" + playerColor;
    return piece.search(s) !== -1;
}

function onDrop(source, target) {
    // see if the move is legal
    const move = {
        from: source,
        to: target,
        promotion: "q",
    };
    const r = game.move(move);

    // illegal move
    if (r === null) return "snapback";
    else makeMove(move);
}

function updateBoard() {
    board.position(game.fen());
}

function onSnapEnd() {
    updateBoard();
}

function makeMove(move) {
    const payLoad = {
        type: "move",
        data: {
            move,
        },
    };
    conn.send(JSON.stringify(payLoad));
}

function handleOpponentMove(data) {
    const move = data.move;
    const r = game.move(move);

    if (r === null) {
        console.log("error move");
        return;
    }

    updateBoard();
}

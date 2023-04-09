const conn = new WebSocket("ws://localhost:8090");
const PIECETHEME = "assets/img/chesspieces/wikipedia/{piece}.png";

const timeControl = 5 * 60 * 1000; // 5 minutes
let timeWhite = timeControl;
let timeBlack = timeControl;
let game, playerColor, board, currentGameId, newBoard, whiteTimer, blackTimer;

const connectBtn = document.getElementById("connectBtn");
const nameInput = document.getElementById("nameInput");
const createGameBtn = document.getElementById("createGameBtn");
const GameCode = document.getElementById("GameCode");
const gameCodeInput = document.getElementById("gameCodeInput");
const joinGameBtn = document.getElementById("joinGameBtn");
const timer1Node = document.getElementById("timer1");
const timer2Node = document.getElementById("timer2");
let whiteTimerNode;
let blackTimerNode;

board = Chessboard("myBoard", {
    pieceTheme: PIECETHEME,
});

conn.onmessage = onMessage;

conn.onopen = (e) => {
    console.log("conncection established");

    connectBtn.addEventListener("click", () => {
        if (nameInput.value === "") return;

        console.log("connect btn clicked");
        sendInfo(conn, { name: nameInput.value });
        connectBtn.disabled = true;
        nameInput.disabled = true;

        enableInputs();
    });

    createGameBtn.addEventListener("click", () => {
        sendData(conn, { type: "create", data: {} });
        createGameBtn.disabled = true;
        gameCodeInput.disabled = true;
        joinGameBtn.disabled = true;
    });

    joinGameBtn.addEventListener("click", () => {
        const gameId = gameCodeInput.value;
        if (gameId === "") return;

        const payLoad = {
            type: "join",
            data: {
                gameId,
            },
        };
        sendData(conn, payLoad);
        createGameBtn.disabled = true;
        gameCodeInput.disabled = true;
        joinGameBtn.disabled = true;
        currentGameId = gameId;
    });
};

function enableInputs() {
    createGameBtn.disabled = false;
    gameCodeInput.disabled = false;
    joinGameBtn.disabled = false;
}

function onMessage(e) {
    const data = JSON.parse(e.data);
    switch (data.type) {
        case "move":
            handleOpponentMove(data.data);
            break;
        case "gameCreated":
            handleGameCreated(data.data);
            break;
        case "gameStarted":
            initGame("myBoard", data.data);
            break;
    }
}

function handleGameCreated(data) {
    currentGameId = data.gameId;
    GameCode.innerText = currentGameId;
}

function sendInfo(conn, info) {
    //first thing to do after the connection is established send player info (name..)
    const payLoad = {
        type: "playerInfo",
        data: info,
    };

    sendData(conn, payLoad);
}

function askServerCreateGame() {
    const payload = {
        type: "create",
        data: {},
    };

    sendData(conn, payload);
}

function sendData(conn, payLoad) {
    conn.send(JSON.stringify(payLoad));
}

function milliToTime(milli) {
    let timeText = "";
    let hours = Math.floor(milli / 3600000);
    if (hours > 0)
        timeText += String(Math.floor(milli / 3600000)).padStart(2, "0") + ":";
    const minutes = String(
        Math.floor((milli - hours * 3600000) / 60000)
    ).padStart(2, "0");
    timeText += minutes + ":";
    const seconds = String(Math.floor((milli / 1000) % 60)).padStart(2, "0");
    timeText += seconds;
    return timeText;
}

function setWhiteTimer() {
    blackTimer = clearInterval(blackTimer);
    clearInterval(whiteTimer);
    whiteTimer = setInterval(() => {
        timeWhite -= 1000;
        whiteTimerNode.innerText = milliToTime(timeWhite);
    }, 1000);
}

function setBlackTimer() {
    whiteTimer = clearInterval(whiteTimer);
    clearInterval(blackTimer);
    blackTimer = setInterval(() => {
        timeBlack -= 1000;
        blackTimerNode.innerText = milliToTime(timeBlack);
    }, 1000);
}

function initTimersNodes() {
    whiteTimerNode = playerColor === "w" ? timer2Node : timer1Node;
    blackTimerNode = playerColor === "w" ? timer1Node : timer2Node;
    whiteTimerNode.innerText = milliToTime(timeWhite);
    blackTimerNode.innerText = milliToTime(timeBlack);
}

function initGame(context, data) {
    board.destroy();
    game = new Chess();
    timeWhite = timeControl;
    timeBlack = timeControl;

    playerColor = data.color === "white" ? "w" : "b"; //TODO: change to full color name
    const config = {
        orientation: data.color,
        draggable: true,
        position: "start",
        pieceTheme: PIECETHEME,
        onDragStart: onDragStart,
        onDrop: onDrop,
        onSnapEnd: onSnapEnd,
    };
    newBoard = Chessboard(context, config);

    initTimersNodes();
    setWhiteTimer();
}

function onDragStart(source, piece, position, orientation) {
    if (game.game_over()) return false;

    if (game.turn() !== playerColor || !isPlayerPiece(piece)) {
        return false;
    }
}

function isPlayerPiece(piece) {
    const s = "^" + playerColor;
    return piece.search(s) !== -1;
}

function onDrop(source, target) {
    const move = {
        from: source,
        to: target,
        promotion: "q",
    };
    const r = game.move(move);

    if (r === null) return "snapback";
    else {
        makeMove(move);
        toggleTimer();
    }
}

function toggleTimer() {
    if (whiteTimer) setBlackTimer();
    else setWhiteTimer();
}

function updateBoard() {
    console.log("board updated");
    newBoard.position(game.fen());
}

function onSnapEnd() {
    updateBoard();
}

function makeMove(move) {
    const payLoad = {
        type: "move",
        data: {
            move,
            gameId: currentGameId,
        },
    };
    conn.send(JSON.stringify(payLoad));
}

function handleOpponentMove(data) {
    console.log("move", data);
    const move = data.move;
    const r = game.move(move);

    if (r === null) {
        console.log("error move");
        return;
    }

    updateBoard();
    toggleTimer();
}

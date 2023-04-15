const conn = new WebSocket("ws://localhost:8090");
const PIECETHEME = "assets/img/chesspieces/wikipedia/{piece}.png";

const timeControl = 5 * 60 * 1000; // 5 minutes
let time1 = timeControl;
let time2 = timeControl;
let game,
    playerColor,
    board,
    currentGameId,
    timer1Interval,
    timer2Interval,
    gameStatus,
    result,
    playing = false,
    drawOffered = false,
    resignOffered = false,
    takeBackOffered = false,
    offerDraw = false,
    offerResign = false,
    offerTakeBack = false;
let player1Score = 0,
    player2Score = 0;

const connectBtn = document.getElementById("connectBtn");
const nameInput = document.getElementById("nameInput");
const createGameBtn = document.getElementById("createGameBtn");
const GameCode = document.getElementById("GameCode");
const gameCodeInput = document.getElementById("gameCodeInput");
const joinGameBtn = document.getElementById("joinGameBtn");
const player1timerNode = document.getElementById("timer1");
const player2timerNode = document.getElementById("timer2");
const takeBackBtn = document.getElementById("takeBackBtn");
const offerDrawBtn = document.getElementById("drawBtn");
const resignBtn = document.getElementById("resignBtn");
const rematchBtn = document.getElementById("rematchBtn");
const acceptDrawBtn = document.getElementById("acceptDrawBtn");
const acceptTakeBAckBtn = document.getElementById("acceptTakeBAckBtn");
const declineDrawBtn = document.getElementById("declineDrawBtn");
const declineTakeBAckBtn = document.getElementById("declineTakeBAckBtn");

const resultNode = document.getElementById("result");

board = Chessboard("myBoard", {
    pieceTheme: PIECETHEME,
});

// resignBtn.addEventListener("click", f("resign", "offer"));

// takeBackBtn.addEventListener("click", f("take_back", "offer"));
// takeBackBtn.addEventListener("click", f("take_back", "accept"));
// takeBackBtn.addEventListener("click", f("take_back", "decline"));

// offerDrawBtn.addEventListener("click", f("draw", "offer"));
// acceptDrawBtn.addEventListener("click", f("draw", "accept"));
declineDrawBtn.addEventListener("click", () => {
    if (drawOffered) {
        f("draw", "decline");
        drawOffered = false;
    }
});

offerDrawBtn.addEventListener("click", () => {
    if (drawOffered) {
        f("draw", "accept");
        setResult("Draw");
        drawOffered = false;
    } else if (!offerDraw) {
        f("draw", "offer");
        offerDraw = true;
    }
});

acceptDrawBtn.addEventListener("click", () => {
    if (drawOffered) {
        f("draw", "accept");
        setResult("Draw");
        drawOffered = false;
    }
});

function f(a, b) {
    sendData(conn, {
        type: "game",
        data: {
            type: a,
            data: {
                type: b,
                data: {
                    gameId: currentGameId,
                },
            },
        },
    });
}

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
        const payLoad = {
            type: "custom",
            data: {
                type: "create",
                data: {},
            },
        };
        sendData(conn, payLoad);
        createGameBtn.disabled = true;
        gameCodeInput.disabled = true;
        joinGameBtn.disabled = true;
    });

    joinGameBtn.addEventListener("click", () => {
        const gameId = gameCodeInput.value;
        if (gameId === "") return;

        const payLoad = {
            type: "custom",
            data: {
                type: "join",
                data: {
                    gameId,
                },
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
        case "custom":
            handleCustom(data.data);
            break;
        case "game":
            handleGame(data.data);
            break;
    }
}

function handleGame(data) {
    const type = data.type;
    switch (type) {
        case "move":
            handleGameMove(data.data);
            break;
        case "draw":
            handleDraw(data.data);
            break;
        case "take_back":
            handleTakeBack(data.data);
            break;
    }
}

function handleDraw(data) {
    const type = data.type;
    switch (type) {
        case "offer":
            handleDrawOffer(data.data);
            break;
        case "accept":
            handleDrawAccept(data.data);
            break;
        case "decline":
            handleDrawDecline(data.data);
            break;
    }
}

function handleDrawOffer(data) {
    drawOffered = true;
    console.log("draw offered");
}

function handleDrawAccept(data) {
    if (offerDraw) {
        setResult("Draw");
        offerDraw = false;
    }
    // disableGameBtns();
}

function handleDrawDecline(data) {
    if (offerDraw) {
        offerDraw = false;
        console.log("draw declined");
    }
}

function handleGameMove(data) {
    if (playing) handleOpponentMove(data);
}

function handleCustom(data) {
    const type = data.type;
    switch (type) {
        case "created":
            handleGameCreated(data.data);
            break;
        case "ready":
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
        type: "connect",
        data: info,
    };

    sendData(conn, payLoad);
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

function setTimer1() {
    timer2Interval = clearInterval(timer2Interval);
    clearInterval(timer1Interval);
    timer1Interval = setInterval(() => {
        time1 -= 1000;
        player1timerNode.innerText = milliToTime(time1);
    }, 1000);
}

function setTimer2() {
    timer1Interval = clearInterval(timer1Interval);
    clearInterval(timer2Interval);
    timer2Interval = setInterval(() => {
        time2 -= 1000;
        player2timerNode.innerText = milliToTime(time2);
    }, 1000);
}

function initTimers() {
    player1timerNode.innerText = milliToTime(time1);
    player2timerNode.innerText = milliToTime(time2);
    if (playerColor === "w") setTimer1();
    else setTimer2();
}

function initGame(context, data) {
    board.destroy();
    playing = true;
    game = new Chess();
    time1 = timeControl;
    time2 = timeControl;
    playing = false;
    drawOffered = false;
    resignOffered = false;
    takeBackOffered = false;
    offerDraw = false;
    offerResign = false;
    offerTakeBack = false;

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
    board = Chessboard(context, config);

    initTimers();
    resultNode.display = "none";
}

function onDragStart(source, piece, position, orientation) {
    if (!playing) return false; //TODO: handle this
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

    handleIfGameOver();
}

function handleIfGameOver() {
    if (game.game_over()) {
        //TODO: handle timers
        clearInterval(timer1Interval);
        clearInterval(timer2Interval);
        if (game.in_draw()) {
            setResult("Draw");
        } else if (game.in_checkmate()) {
            if (game.turn() === playerColor) setResult("You Lost");
            else setResult("You Won");
        } else if (game.in_stalemate()) {
            setResult("Stalemate");
        } else if (game.in_threefold_repetition()) {
            setResult("Draw Threefold Repetition");
        } else if (game.insufficient_material()) {
            setResult("Draw Insufficient Material");
        }
    } else if (time1 <= 0) {
        setResult("You Lost by Time");
    } else if (time2 <= 0) {
        setResult("You Won by Time");
    }
}

function setResult(r) {
    resultNode.innerText = r;
    resultNode.style.display = "block";
    clearInterval(timer1Interval);
    clearInterval(timer2Interval);
    playing = false;
}

function toggleTimer() {
    if (timer1Interval) setTimer2();
    else setTimer2();
}

function updateBoard() {
    console.log("board updated");
    board.position(game.fen());
}

function onSnapEnd() {
    updateBoard();
}

function makeMove(move) {
    const payLoad = {
        type: "game",
        data: {
            type: "move",
            data: {
                move,
                gameId: currentGameId,
            },
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

    handleIfGameOver();
}

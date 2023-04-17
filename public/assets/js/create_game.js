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
    opponentOfferedDraw = false,
    opponentOfferedResign = false,
    opponentOfferedTakeBack = false,
    drawOffered = false,
    resignOffered = false,
    takeBackOffered = false,
    rematchOffered = false,
    takeBackHistory = null;
(player1Score = 0), (player2Score = 0);

const connectBtn = document.getElementById("connectBtn");
const nameInput = document.getElementById("nameInput");
const createGameBtn = document.getElementById("createGameBtn");
const GameCode = document.getElementById("GameCode");
const gameCodeInput = document.getElementById("gameCodeInput");
const joinGameBtn = document.getElementById("joinGameBtn");
const player1timerNode = document.getElementById("timer1");
const player2timerNode = document.getElementById("timer2");
const offerTakeBackBtn = document.getElementById("takeBackBtn");
const offerDrawBtn = document.getElementById("drawBtn");
const resignBtn = document.getElementById("resignBtn");
const confirmResignBtn = document.getElementById("confirmResignBtn");
const offerRematchBtn = document.getElementById("offerRematchBtn");
const acceptDrawBtn = document.getElementById("acceptDrawBtn");
const acceptTakeBackBtn = document.getElementById("acceptTakeBAckBtn");
const declineDrawBtn = document.getElementById("declineDrawBtn");
const declineTakeBAckBtn = document.getElementById("declineTakeBAckBtn");
const acceptRematchBtn = document.getElementById("acceptRematchBtn");
const declineRematchBtn = document.getElementById("declineRematchBtn");
const modalBtn = document.getElementById("modal");
const modalTitle = document.getElementById("mymodallabel");
const cancelModal = document.getElementById("cancelModalBtn");
const modal = document.getElementById("mymodal");
const modalBtns = document.querySelectorAll(".modalBtn");
const mm = new bootstrap.Modal(modal);

// hideControlButtons();

const resultNode = document.getElementById("result");

const showDrawOffer = () =>
    showModal("Accept Draw?", [acceptDrawBtn, declineDrawBtn]);
const showTakebackOffer = () =>
    showModal("Accept take back?", [acceptTakeBackBtn, declineTakeBAckBtn]);
const showRematchOffer = () =>
    showModal("Opponent want rematch", [acceptRematchBtn, declineRematchBtn]);
const showConfirmResign = () =>
    showModal("Confirm Resign", [confirmResignBtn, cancelModal]);

function showModal(title, buttons) {
    modalTitle.innerText = title;
    modalBtns.forEach((b) => (b.style.display = "none"));
    buttons.forEach((b) => (b.style.display = "block"));
    mm.show();
}

resignBtn.addEventListener("click", () =>
    showModal("Confirm Resign", [confirmResignBtn, cancelModal])
);

board = Chessboard("myBoard", {
    pieceTheme: PIECETHEME,
});

confirmResignBtn.addEventListener("click", () => {
    if (playing) {
        console.log("resign confirmed");
        f("resign", "offer");
        setResult("You Lost", 0, 1);
    }
});

offerTakeBackBtn.addEventListener("click", () => {
    if (!takeBackOffered) {
        f("take_back", "offer");
        takeBackOffered = true;
        takeBackHistory = game.history;
    }
});

acceptTakeBackBtn.addEventListener("click", () => {
    if (opponentOfferedTakeBack) {
        f("take_back", "accept");
        opponentOfferedTakeBack = false;
        goBacktoTakeBack();
        // handle tackback
    }
});

declineTakeBAckBtn.addEventListener("click", () => {
    if (opponentOfferedTakeBack) {
        f("take_back", "decline");
        opponentOfferedTakeBack = false;
    }
});

declineDrawBtn.addEventListener("click", () => {
    if (opponentOfferedDraw) {
        f("draw", "decline");
        opponentOfferedDraw = false;
    }
});

offerDrawBtn.addEventListener("click", () => {
    if (opponentOfferedDraw) {
        f("draw", "accept");
        setResult("Draw", 0.5, 0.5);
        opponentOfferedDraw = false;
    } else if (!drawOffered) {
        f("draw", "offer");
        drawOffered = true;
    }
});

acceptDrawBtn.addEventListener("click", () => {
    if (opponentOfferedDraw) {
        f("draw", "accept");
        setResult("Draw", 0.5, 0.5);
        opponentOfferedDraw = false;
    }
});

offerRematchBtn.addEventListener("click", () => {
    if (!playing && !rematchOffered) {
        f("rematch", "offer");
        console.log("rematch offered");
        rematchOffered = true;
    }
});

acceptRematchBtn.addEventListener("click", () => {
    f("rematch", "accept");
    initGame("myBoard", { color: playerColor });
});

declineRematchBtn.addEventListener("click", () => {
    f("rematch", "decline");
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
        case "resign":
            handleOpponentResign(data.data);
            break;
        case "rematch":
            handleRematchOffer(data.data);
            break;
    }
}

function handleRematchOffer(data) {
    const type = data.type;
    switch (type) {
        case "offer":
            console.log("rematch offered");
            if (playing) return;
            if (rematchOffered) {
                rematchOffered = false;
                initGame("myBoard", { color: playerColor });
            } else {
                showRematchOffer();
            }
            break;
        case "accept":
            rematchOffered = false;
            initGame("myBoard", { color: playerColor });
            break;
        case "decline":
            rematchOffered = false;
            console.log("your rematch offer was declined");
            break;
    }
}

function handleOpponentResign(data) {
    console.log("opponent resigned");
    setResult("You Won", 1, 0);
}

function handleTakeBack(data) {
    const type = data.type;
    switch (type) {
        case "offer":
            opponentOfferedTakeBack = true;
            showTakebackOffer();
            break;
        case "accept":
            handleTAkeBackAccepted(data);
            takeBackOffered = false;
            break;
        case "decline":
            console.log("your takeback offer was declined");
            takeBackOffered = false;
            break;
    }
}

function handleTAkeBackAccepted(data) {}

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
    opponentOfferedDraw = true;
    console.log("draw offered");
}

function handleDrawAccept(data) {
    if (drawOffered) {
        setResult("Draw", 0.5, 0.5);
        drawOffered = false;
    }
    // disableGameBtns();
}

function handleDrawDecline(data) {
    if (drawOffered) {
        drawOffered = false;
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
    if (playerColor[0] === "w") setTimer1();
    else setTimer2();
}

function initGame(context, data) {
    board.destroy();
    playing = true;
    game = new Chess();
    time1 = timeControl;
    time2 = timeControl;
    playing = true;
    opponentOfferedDraw = false;
    opponentOfferedResign = false;
    opponentOfferedTakeBack = false;
    drawOffered = false;
    resignOffered = false;
    takeBackOffered = false;
    rematchOffered = false;
    takeBackHistory = null;

    // playerColor = data.color === "white" ? "w" : "b"; //TODO: change to full color name
    playerColor = data.color;
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
    offerRematchBtn.style.display = "none";
    offerTakeBackBtn.style.display = "block";
    offerDrawBtn.style.display = "block";
    resignBtn.style.display = "block";
    resultNode.style.display = "none";
}

function hideControlButtons() {
    offerRematchBtn.style.display = "none";
    offerTakeBackBtn.style.display = "none";
    offerDrawBtn.style.display = "none";
    resignBtn.style.display = "none";
}

function onDragStart(source, piece, position, orientation) {
    if (!playing) return false; //TODO: handle this
    if (game.game_over()) return false;

    if (game.turn() !== playerColor[0] || !isPlayerPiece(piece)) {
        return false;
    }
}

function isPlayerPiece(piece) {
    const s = "^" + playerColor[0];
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
            setResult("Draw", 0.5, 0.5);
        } else if (game.in_checkmate()) {
            if (game.turn() === playerColor[0]) setResult("You Lost", 0, 1);
            else setResult("You Won", 1, 0);
        } else if (game.in_stalemate()) {
            setResult("Stalemate", 0.5, 0.5);
        } else if (game.in_threefold_repetition()) {
            setResult("Draw Threefold Repetition", 0.5, 0.5);
        } else if (game.insufficient_material()) {
            setResult("Draw Insufficient Material", 0.5, 0.5);
        }
    } else if (time1 <= 0) {
        setResult("You Lost by Time", 0, 1);
    } else if (time2 <= 0) {
        setResult("You Won by Time", 1, 0);
    }
}

function setResult(r, p1, p2) {
    resultNode.innerText = r;
    resultNode.style.display = "block";
    offerRematchBtn.style.display = "block";
    offerTakeBackBtn.style.display = "none";
    offerDrawBtn.style.display = "none";
    resignBtn.style.display = "none";

    clearInterval(timer1Interval);
    clearInterval(timer2Interval);
    player1Score += p1;
    player2Score += p2;
    playing = false;
}

function toggleTimer() {
    if (timer1Interval) setTimer2();
    else setTimer1();
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

// const conn = new WebSocket("ws://172.16.11.44:8090");
// const conn = new WebSocket("ws://192.168.43.143:8090");
const conn = new WebSocket("ws://localhost:8090");
const PIECETHEME = "assets/img/chesspieces/wikipedia/{piece}.png";

// const timeControl = 10 * 1000; // 10 seconds
let timeControl = 5 * 60 * 1000; // 5 minutes
let time1 = timeControl;
let time2 = timeControl;
let game,
    gameRuleId,
    playerId,
    playerColor,
    board,
    currentGameId,
    timer1Interval,
    timer2Interval,
    addTimeType,
    addTime,
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
    takeBackMoveNumber = null;
let player1Score = 0;
let player2Score = 0;

const gameSection = document.getElementById("game-section");
const createGameSection = document.getElementById("create-game-section");
// const findGameSection = document.getElementById("find-game-section");
const connectBtn = document.getElementById("connectBtn");
const nameInput = document.getElementById("nameInput");
const createGameBtn = document.getElementById("createGameBtn");
const gameCode = document.getElementById("gameCode");
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
const userNameNode = document.getElementById("user-name");
const opponentNameNode = document.getElementById("opponent-name");
const userScoreNode = document.getElementById("user-score");
const opponentScoreNode = document.getElementById("opponent-score");
const mm = new bootstrap.Modal(modal);

const resultNode = document.getElementById("result");
const gameRuleSelect = document.getElementById("game-rule-select");

showCreateGameSection();

function showGameSection() {
    createGameSection.hidden = true;
    gameSection.hidden = false;
}

function showCreateGameSection() {
    createGameSection.hidden = false;
    gameSection.hidden = true;
}

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
    modalBtns.forEach((b) => (b.hidden = true));
    buttons.forEach((b) => (b.hidden = false));
    mm.show();
}

resignBtn.addEventListener("click", () =>
    showModal("Confirm Resign", [confirmResignBtn, cancelModal])
);

board = Chessboard("myBoard", {
    pieceTheme: PIECETHEME,
});
window.addEventListener("resize", board.resize);

confirmResignBtn.addEventListener("click", () => {
    if (playing) {
        console.log("resign confirmed");
        f("resign", "offer");
        setResult("You Lost", 0, 1);
    }
});

function playerIsWhite() {
    return playerColor === "white";
}

function playerIsBlack() {
    return playerColor === "black";
}

offerTakeBackBtn.addEventListener("click", () => {
    if (!takeBackOffered) {
        console.log("take back offer sent");
        takeBackOffered = true;
        if (playerIsWhite()) s = game.history().length % 2 ? 1 : 2;
        else s = game.history().length % 2 ? 2 : 1;
        takeBackMoveNumber = game.history().length - s;
        if (takeBackMoveNumber >= 0) {
            sendData(conn, {
                type: "game",
                data: {
                    type: "take_back",
                    data: {
                        type: "offer",
                        data: {
                            gameId: currentGameId,
                            takeBackMoveNumber,
                        },
                    },
                },
            });
        } else {
            takeBackOffered = false;
            takeBackMoveNumber = null;
        }
    }
});

acceptTakeBackBtn.addEventListener("click", () => {
    if (opponentOfferedTakeBack) {
        f("take_back", "accept");
        opponentOfferedTakeBack = false;
        executeTakeBack();
        // handle takeback
    }
});

declineTakeBAckBtn.addEventListener("click", () => {
    if (opponentOfferedTakeBack) {
        f("take_back", "decline");
        opponentOfferedTakeBack = false;
        takeBackMoveNumber = null;
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

    sendInfo(conn, {
        registred: true,
        userName,
        userId,
    });

    // connectBtn.addEventListener("click", () => {
    //     if (nameInput.value === "") return;

    //     console.log("connect btn clicked");
    //     sendInfo(conn, { name: nameInput.value });
    //     connectBtn.disabled = true; // TODO: handle this mess
    //     nameInput.disabled = true;

    //     enableInputs();
    // });

    createGameBtn.addEventListener("click", () => {
        gameRuleId = gameRuleSelect.value;
        if (gameRuleId === "") return;
        const payLoad = {
            type: "custom",
            data: {
                type: "create",
                data: {
                    playerId,
                    gameRuleId,
                },
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
                    playerId,
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
        case "connect":
            handleConnect(data.data);
            break;
    }
}

function handleConnect(data) {
    playerId = data.playerId;
    console.log(`player registred with succes, id: ${playerId}`);
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
            console.log("takeback offered");
            opponentOfferedTakeBack = true;
            showTakebackOffer();
            takeBackMoveNumber = data.data.takeBackMoveNumber;
            break;
        case "accept":
            console.log("takeback accepted");
            executeTakeBack();
            takeBackOffered = false;
            break;
        case "decline":
            console.log("takeback declined");
            console.log("your takeback offer was declined");
            takeBackOffered = false;
            takeBackMoveNumber = null;
            break;
    }
}

function executeTakeBack() {
    let n = game.history().length - takeBackMoveNumber;
    if (n % 2) toggleTimer();
    while (n > 0) {
        game.undo();
        board.position(game.fen());
        --n;
    }
    takeBackMoveNumber = null;
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
    opponentOfferedDraw = true;
    showDrawOffer();
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
            handleGameReady(data.data);
            break;
    }
}

function handleGameReady(data) {
    userNameNode.innerText = userName;
    opponentNameNode.innerText = data.opponent.userName;
    timeControl = data.gameRules.length * 1000;
    addTimeType = data.gameRules.addTimeType;
    addTime = data.gameRules.addTime * 1000;

    initGame("myBoard", data);
}

function handleGameCreated(data) {
    currentGameId = data.gameId;
    gameCode.value = currentGameId;
    // gameCode.innerText = currentGameId;
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
    if (hours > 0) timeText += String(hours).padStart(2, "0") + ":";
    // timeText += String(Math.floor(milli / 3600000)).padStart(2, "0") + ":";
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
    if (addTimeType === "delay") {
        setTimeout(() => {
            timer1Interval = setInterval(() => {
                time1 -= 1000;
                player1timerNode.innerText = milliToTime(time1);
                if (time1 <= 0) setResult("You Lost", 0, 1);
            }, 1000);
        }, addTime);
        return;
    } else if (addTimeType === "increment") time1 += addTime;

    timer1Interval = setInterval(() => {
        time1 -= 1000;
        player1timerNode.innerText = milliToTime(time1);
        if (time1 <= 0) setResult("You Lost", 0, 1);
    }, 1000);
}

function setTimer2() {
    timer1Interval = clearInterval(timer1Interval);
    clearInterval(timer2Interval);
    if (addTimeType === "delay") {
        setTimeout(() => {
            timer2Interval = setInterval(() => {
                time2 -= 1000;
                player2timerNode.innerText = milliToTime(time2);
                if (time2 <= 0) setResult("You Won", 1, 0);
            }, 1000);
        }, addTime);
        return;
    } else if (addTimeType === "increment") time2 += addTime;

    timer2Interval = setInterval(() => {
        time2 -= 1000;
        player2timerNode.innerText = milliToTime(time2);
        if (time2 <= 0) setResult("You Won", 1, 0);
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
    window.addEventListener("resize", board.resize);

    initTimers();
    offerRematchBtn.hidden = true;
    offerTakeBackBtn.hidden = false;
    offerDrawBtn.hidden = false;
    resignBtn.hidden = false;
    resultNode.hidden = true;

    showGameSection();
}

function hideControlButtons() {
    offerRematchBtn.hidden = true;
    offerTakeBackBtn.hidden = true;
    offerDrawBtn.hidden = true;
    resignBtn.hidden = true;
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

function sendResultToServer(p1, p2) {
    let result;
    if (p1 === 1) {
        result = "1-0";
    } else if (p2 === 1) {
        result = "0-1";
    } else {
        result = "1/2-1/2";
    }

    const payLoad = {
        type: "game",
        data: {
            type: "result",
            data: {
                result,
                gameId: currentGameId,
                pgn: game.pgn(),
            },
        },
    };

    sendData(conn, payLoad);
}

function setResult(r, p1, p2) {
    resultNode.innerText = r;
    resultNode.hidden = false;
    offerRematchBtn.hidden = false;
    offerTakeBackBtn.hidden = true;
    offerDrawBtn.hidden = true;
    resignBtn.hidden = true;

    clearInterval(timer1Interval);
    clearInterval(timer2Interval);
    player1Score += p1;
    player2Score += p2;
    userScoreNode.innerText = player1Score;
    opponentScoreNode.innerText = player2Score;
    playing = false;

    if (playerColor == "white") {
        sendResultToServer(p1, p2);
    }
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
                time1,
                time2,
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

    time1 = data.time2;
    time2 = data.time1;
    updateBoard();
    toggleTimer();

    handleIfGameOver();
}

// function showControlBtns() {
//     offerTakeBackBtn.hidden = false;
//     offerDrawBtn.hidden = false;
//     resignBtn.hidden = false;
//     offerRematchBtn.hidden = false;
// }

// function hideControlBtns() {
//     offerTakeBackBtn.hidden = true;
//     offerDrawBtn.hidden = true;
//     resignBtn.hidden = true;
//     offerRematchBtn.hidden = true;
// }

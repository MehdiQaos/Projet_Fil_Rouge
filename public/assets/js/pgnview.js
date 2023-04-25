const PIECETHEME = "/assets/img/chesspieces/wikipedia/{piece}.png";
const game = new Chess();

// const pgn = `1. e4 e5 2. Nf3 Nc6 3. Bb5 a6 4. Ba4 Nf6 5. O-O Be7 6. Bxc6 dxc6 7. Re1 Nd7
// 8. d4 exd4 9. Qxd4 O-O 10. Bf4 Nc5 11. Qe3 Bg4 12. Nd4 Qd7 13. Nc3 Rad8 14.
// Nf5 Ne6 15. Nxe7+ Qxe7 16. Bg3 Bh5 17. f3 f6 18. h3 h6 19. Kh2 Bf7 20. Rad1
// b6 21. a3 a5 22. Ne2 Rxd1 23. Rxd1 Rd8 24. Rd3 c5 25. Qd2 c6 26. Rxd8+ Nxd8
// 27. Qf4 b5 28. Qb8 Kh7 29. Bd6 Qd7 30. Ng3 Ne6 31. f4 h5 32. c3 c4 33. h4
// Qd8 34. Qb7 Be8 35. Nf5 Qd7 36. Qb8 Qd8 37. Qxd8 Nxd8 38. Nd4 Nb7 39. e5
// Kg8 40. Kg3 Bd7 41. Bc7 Nc5 42. Bxa5 Kf7 43. Bb4 Nd3 44. e6+ Bxe6 45. Nxc6
// Bd7 46. Nd4 Nxb2 47. Kf3 Nd3 48. g3 Nc1 49. Ke3 1/2-1/2`;

game.load_pgn(pgn);
const h = game.history();
game.reset();
let i = 0;

const history = document.getElementById("history");
h.forEach((e, j) => {
    const span = document.createElement("span");
    span.innerText =
        (j % 2 ? "-" : `${Math.floor(j / 2 + 1)}.`) + e + (j % 2 ? " " : "");
    span.addEventListener("click", () => {
        let k = j - i + 1;
        if (k > 0) jumpAheadBy(k);
        else if (k < 0) jumpBehindBy(k);
        updateBoard();
    });
    history.append(span);
});

document.addEventListener("keydown", (event) => {
    if (event.key === "ArrowRight") next();
    else if (event.key === "ArrowLeft") prev();
});

function jumpAheadBy(i) {
    while (i > 0) {
        nextMove();
        --i;
    }
}

function jumpBehindBy(i) {
    while (i < 0) {
        prevMove();
        ++i;
    }
}

const config = {
    appearSpeed: 100,
    moveSpeed: 100,
    snapbackSpeed: 100,
    snapSpeed: 100,
    draggable: true,
    position: "start",
    pieceTheme: PIECETHEME,
};

function next() {
    if (nextMove()) updateBoard();
}

function prev() {
    if (prevMove()) updateBoard();
}

function updateBoard() {
    board.position(game.fen());
}

function nextMove() {
    if (i < h.length) {
        game.move(h[i]);
        i++;
        return true;
    }
    return false;
}

function prevMove() {
    if (i > 0) {
        game.undo();
        --i;
        return true;
    }
    return false;
}

board = Chessboard("myBoard", config);
window.addEventListener("resize", board.resize);

document.getElementById("prev").addEventListener("click", prev);

document.getElementById("next").addEventListener("click", next);

// const conn = new WebSocket("ws://172.16.11.44:8090");
// const conn = new WebSocket("ws://192.168.43.143:8090");
// const conn = new WebSocket("ws://localhost:8090");

function findGame(gameRuleId) {
    // const gameRule = document.getElementById("gameRule").value;
    // const userId = document.getElementById("userId").value;
    // const payload = {
    //     type: "find",
    //     data: {
    //         type: "new",
    //         data: {
    //             id: userId,
    //             gameRuleId,
    //         },
    //     },
    // };
    // conn.send(JSON.stringify(payload));
    console.log(gameRuleId);
}

function cancelFind() {
    const payload = {
        type: "find",
        data: {
            type: "cancel",
            data: {
                id: userId,
                gameRuleId,
            },
        },
    };
    conn.send(JSON.stringify(payload));
}

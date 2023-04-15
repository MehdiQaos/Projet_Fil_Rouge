<x-menu.layout>
    {{-- {{auth()->user()->role->name}} --}}
    {{-- @if (auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'superadmin') --}}
        <x-menu.sidebar/>
    {{-- @endif --}}
    <div id="page-content-wrapper">
        <x-menu.navbar/>
        {{-- <x-menu :dishes="$dishes"/> --}}
        {{-- <div class="card p-5 m-5"> --}}
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div id="result"><h1></h1></div>
                    <div><h2 id="timer2"></h2></div>
                    <div id="myBoard" style="width: 100%;"></div>
                    <div><h2 id="timer1"></h2></div>
                </div>
                <div class="col-5">
                    <div class="form-floating">
                        <textarea readonly class="form-control" placeholder="Leave a comment here" id="gameHistory">1. d4-d5 2.c4-c5</textarea>
                        <label for="floatingTextarea">History</label>
                    </div>
                    <div class="form-floating">
                        <textarea readonly class="form-control" placeholder="Leave a comment here" id="chatArea"></textarea>
                        <label for="floatingTextarea">Chat</label>
                    </div>
                    <div class="form-floating">
                        <textarea readonly class="form-control" placeholder="Leave a comment here" id="chatMessage"></textarea>
                        <label for="floatingTextarea">message</label>
                    </div>
                    <button id="takeBackBtn">take back</button>
                    <button id="drawBtn">draw</button>
                    <button id="resignBtn">resign</button>
                    <button id="rematchBtn">rematch</button>
                    <button id="acceptDrawBtn">accept Draw</button>
                    <button id="acceptTakeBAckBtn">accept Takeback</button>
                    <button id="declineDrawBtn">decline Draw</button>
                    <button id="declineTakeBAckBtn">decline Takeback</button>
                </div>
            </div>
            <div class="row">
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
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/chess.0.10.3.js') }}"></script>
    <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
    <script src="{{ asset('assets/js/create_game.js') }}"></script>
</x-menu.layout>
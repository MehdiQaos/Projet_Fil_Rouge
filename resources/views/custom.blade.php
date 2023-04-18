<x-menu.layout>
    {{-- {{auth()->user()->role->name}} --}}
    {{-- @if (auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'superadmin') --}}
        <x-menu.sidebar/>
    {{-- @endif --}}
    <div id="page-content-wrapper">
        <x-menu.navbar/>
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
                    <button id="takeBackBtn" class="btn btn-secondary" hidden>take back</button>
                    <button id="drawBtn" class="btn btn-secondary" hidden>draw</button>
                    <button id="resignBtn" class="btn btn-secondary" hidden>resign</button>
                    <button id="offerRematchBtn" class="btn btn-secondary" hidden>rematch</button>
                </div>
            </div>
            <div class="row">
                <div>
                    <input id="nameInput" type="text" focus>
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
    <script defer src="{{ asset('assets/js/create_game.js') }}"></script>
    {{-- draw modal --}}
    <div class="modal" id="mymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="takebackmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mymodallabel">Modal title</h1>
      </div>
      <div class="modal-footer">
        <button class="modalBtn" id="acceptDrawBtn" data-bs-dismiss="modal">accept</button>
        <button class="modalBtn" id="acceptTakeBAckBtn" data-bs-dismiss="modal">accept</button>
        <button class="modalBtn" id="declineDrawBtn" data-bs-dismiss="modal">decline</button>
        <button class="modalBtn" id="declineTakeBAckBtn" data-bs-dismiss="modal">decline</button>
        <button class="modalBtn" id="confirmResignBtn" data-bs-dismiss="modal">Confirm</button>
        <button class="modalBtn" id="acceptRematchBtn" data-bs-dismiss="modal">Accept</button>
        <button class="modalBtn" id="declineRematchBtn" data-bs-dismiss="modal">Decline</button>
        <button class="modalBtn" id="cancelModalBtn" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
{{-- end modal --}}
</x-menu.layout>
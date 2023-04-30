@php
    use App\Models\GameRule;
@endphp
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
                    {{-- <div id="result" class="alert alert-primary col-10 mx-auto"><h1>You won</h1></div> --}}
                <div id="board-section" class="col col-md-5 ms-auto">
                    {{-- <div id="result"><h1></h1></div>
                    <div><h2 id="timer2"></h2></div> --}}
                    <div id="myBoard" style="width: 100%;"></div>
                    {{-- <div><h2 id="timer1"></h2></div> --}}
                </div>
                <div id="game-section" class="col col-md-5 me-auto">
                    {{-- <div class="form-floating">
                        <textarea readonly class="form-control" placeholder="Leave a comment here" id="gameHistory">1. d4-d5 2.c4-c5</textarea>
                        <label for="floatingTextarea">History</label>
                    </div> --}}
                    {{-- <div class="container text-white">
                        <div class="row bg-dark">
                            <div class="col-2">1</div>
                            <div class="col-5">d4</div>
                            <div class="col-5">d5</div>
                        </div>
                        <div class="row bg-dark">
                            <div class="col-2">2</div>
                            <div class="col-5">c4</div>
                            <div class="col-5">c5</div>
                        </div>
                        <div class="row bg-dark">
                            <div class="col-2">3</div>
                            <div class="col-5">cxd4</div>
                            <div class="col-5">Nf6</div>
                        </div>
                    </div> --}}
                    <div class="mb-1">
                        <span class="bg-black p-2 text-light rounded-1">3</span>
                        <div class="d-inline bg-light p-2">
                            <span class="fs-2 me-3">Qaos</span>
                            <span class="fs-3" id="timer2">05:00</span>
                        </div>
                    </div>
                    <div style="height: 10rem; overflow-y: scroll">
                        <table class="table table-striped table-hover table-sm table-light">
                            <tbody>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</td>
                                    <td>c4</td>
                                    <td>Nf6</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</td>
                                    <td>d4</td>
                                    <td>d5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <span class="bg-black p-2 text-light rounded-1">0</span>
                        <div class="d-inline bg-light p-2">
                            <span class="fs-2 me-3">Mehdi</span>
                            <span class="fs-3" id="timer2">05:00</span>
                        </div>
                    </div>
                    <div class="my-1">
                        <button title="offer take back" id="takeBackBtn" class="btn btn-lg btn-outline-secondary game-control-btn" hidden><i class="fa-solid fa-rotate-left"></i></button>
                        <button title="offer draw" id="drawBtn" class="btn btn-lg btn-outline-secondary game-control-btn" hidden><i class="fa-solid fa-arrow-right-arrow-left"></i></button>
                        <button title="resign" id="resignBtn" class="btn btn-lg btn-outline-secondary game-control-btn" hidden><i class="fa-solid fa-chess-king"></i></button>
                        <button title="offer rematch" id="offerRematchBtn" class="btn btn-lg btn-outline-secondary game-control-btn" hidden><i class="fa-solid fa-exclamation"></i></button>
                    </div>
                    <div id="result" class="alert alert-primary"><b>You won</b></div>
                    <div class="form-floating">
                        <textarea readonly class="form-control" placeholder="Leave a comment here" id="chatArea"></textarea>
                        <label for="floatingTextarea">Chat</label>
                    </div>
                    <div class="form-floating">
                        <textarea readonly class="form-control" placeholder="Leave a comment here" id="chatMessage"></textarea>
                        <label for="floatingTextarea">message</label>
                    </div>
                </div>
                <div id="create-game-section" class="col col-md-5 mt-2 me-auto" hidden>
                    <div class="row mb-2">
                        <input class="form-control col-7 mb-2" id="nameInput" type="text" placeholder="Enter your name">
                        <button class="btn btn-primary mx-auto" id="connectBtn">Connect</button>
                    </div>
                    <div class="row mb-2">
                        {{-- <h1 id="GameCode"></h1> --}}
                        <input id="gameCode" class="form-control col-7 mb-2" type="text" placeholder="" readonly>
                        <button class="btn btn-primary mx-auto" id="createGameBtn" disabled>create game</button>
                    </div>
                    <form class="row mb-2">
                        <input class="form-control mb-2" id="gameCodeInput" type="text" placeholder="Game id" disabled>
                        <button class="btn btn-primary mx-auto" id="joinGameBtn" disabled>join game</button>
                    </form>
                </div>
                {{-- <div id="find-game-section" class="card p-5 m-1" hidden> --}}
                <div id="find-game-section" class="col col-md-5 me-auto" hidden>
                    <table>
                        <thead>
                            <tr>
                                <th>type</th>
                                <th>length</th>
                                <th>add time type</th>
                                <th>add time</th>
                            </tr>
                            <tbody>
                                @foreach (GameRule::all() as $rule)
                                    <tr onclick="findGame({{ $rule->id }})">
                                        <td>{{ $rule->gameType->name }}</td>
                                        <td>{{ $rule->length }}</td>
                                        <td>{{ $rule->move_addtime_type }}</td>
                                        <td>{{ $rule->move_addtime }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pageType = '{{ $type }}';
        const userId = {{ $user->id }};
        const userName = '{{ $user->user_name }}';
    </script>
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
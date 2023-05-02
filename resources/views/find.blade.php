@php
    use App\Models\GameRule;
@endphp
<x-menu.layout>
        <x-menu.sidebar/>
    <div id="page-content-wrapper">
        <x-menu.navbar/>
        <div class="container-fluid">
            <div class="row">
                <div id="board-section" class="col col-md-5 ms-auto">
                    <div id="myBoard" style="width: 100%;"></div>
                </div>
                <div id="game-section" class="col col-md-5 me-auto my-auto" hidden>
                    <div>
                        <div class="bg-light m-0 d-flex rounded-top rounded-1">
                            <span class="fw-bolder mt-0 me-2 fs-1 border border-2 " id="opponent-score">0</span>
                            <span class="fs-5 me-3 my-auto fst-italic" id="opponent-name">Qaos</span>
                            <span class="bg-light ms-auto my-auto me-2 fs-3" id="timer2">05:00</span>
                        </div>
                    </div>
                    <div style="max-height: 6rem; overflow-y: scroll;">
                        <table class="table table-striped table-hover table-sm table-light">
                            <tbody id="game-history">
                                <tr id="history-last-row" style="height: 6rem">
                                    <th scope="row"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="bg-light m-0 d-flex rounded-bottom rounded-1">
                            <span class="fw-bolder mt-0 me-2 fs-1 border border-2 " id="user-score">0</span>
                            <span class="fs-5 me-3 my-auto fst-italic" id="user-name">Mehdi</span>
                            <span class="bg-light ms-auto my-auto me-2 fs-3" id="timer1">05:00</span>
                        </div>
                    </div>
                    <div class="my-1">
                        <button title="offer take back" id="takeBackBtn" class="btn btn-lg btn-outline-secondary game-control-btn border-2" hidden><i class="fa-solid fa-rotate-left"></i></button>
                        <button title="offer draw" id="drawBtn" class="btn btn-lg btn-outline-secondary game-control-btn border-2" hidden><i class="fa-solid fa-flag"></i></button>
                        <button title="resign" id="resignBtn" class="btn btn-lg btn-outline-secondary game-control-btn border-2" hidden><i class="fa-solid fa-chess-king"></i></button>
                        <button title="offer rematch" id="offerRematchBtn" class="btn btn-outline-secondary game-control-btn fw-bolder border-2" hidden>REMATCH</button>
                    </div>
                    <div id="result" class="alert alert-info"><b>You won</b></div>
                </div>
                <div id="find-game-section" class="col col-md-5 me-auto my-auto">
                    <div class="row mb-2">
                        <select id="game-rule-select" class="form-select mb-2" required>
                            <option value="" selected>Choose type of game</option>
                            @foreach (GameRule::all() as $rule)
                                <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-secondary mx-auto mb-2" id="findGameBtn">find game</button>
                        <button class="btn btn-secondary mx-auto mb-2" id="cancelFindBtn" disabled>cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const userId = {{ $user->id }};
        const userName = '{{ $user->user_name }}';
    </script>
    <script src="{{ asset('assets/js/chess.0.10.3.js') }}"></script>
    <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
    <script defer src="{{ asset('assets/js/find.js') }}"></script>
    {{-- draw modal --}}
    <div class="modal" id="mymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="takebackmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="mymodallabel">Modal title</h1>
      </div>
      <div class="modal-footer">
        <button class="modalBtn btn btn-secondary" id="acceptDrawBtn" data-bs-dismiss="modal">accept</button>
        <button class="modalBtn btn btn-secondary" id="acceptTakeBAckBtn" data-bs-dismiss="modal">accept</button>
        <button class="modalBtn btn btn-secondary" id="declineDrawBtn" data-bs-dismiss="modal">decline</button>
        <button class="modalBtn btn btn-secondary" id="declineTakeBAckBtn" data-bs-dismiss="modal">decline</button>
        <button class="modalBtn btn btn-danger" id="confirmResignBtn" data-bs-dismiss="modal">Confirm</button>
        <button class="modalBtn btn btn-secondary" id="acceptRematchBtn" data-bs-dismiss="modal">Accept</button>
        <button class="modalBtn btn btn-secondary" id="declineRematchBtn" data-bs-dismiss="modal">Decline</button>
        <button class="modalBtn btn btn-secondary" id="cancelModalBtn" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
{{-- end modal --}}
</x-menu.layout>
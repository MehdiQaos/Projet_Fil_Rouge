<style>
    .span {
        padding: 2px;
    }
    .selected-span {
        background-color: black;
        color: white;
    }
</style>
<x-menu.layout>
    <x-menu.sidebar/>
    <div id="page-content-wrapper">
    <x-menu.navbar/>
    <div class="container">
        <div class="row">
            <div class="col col-lg-5">
                <div id="myBoard" style="width: 100%"></div>
            </div>
            <div class="col col-lg-5 my-auto">
                <div>
                    <div class="bg-light m-0 d-flex rounded-top rounded-1">
                        <span class="fw-bolder mt-0 me-2 fs-1 border border-2 " id="opponent-score">{{ $opponentScore }}</span>
                        <span class="fs-3 mx-auto my-auto fst-italic" id="opponent-name">{{ $opponentName }}</span>
                    </div>
                </div>
                <div class="border border-secondary border-2 rounded-1 p-3 bg-light">
                    <p id="history" class="fs-6"></p>
                    <button class="btn btn-secondary" id="prev">prev</button>
                    <button class="btn btn-secondary" id="next">next</button>
                </div>
                <div>
                    <div class="bg-light m-0 d-flex rounded-top rounded-1">
                        <span class="fw-bolder mt-0 me-2 fs-1 border border-2 " id="user-score">{{ $userScore }}</span>
                        <span class="fs-3 mx-auto my-auto fst-italic" id="user-name">{{ $userName }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
        </div>
    </div>
    <script>
        const pgn = "{{ $game->pgn }}";
        let orientation = '{{ $orientation }}';
    </script>
    <script defer src="{{ asset('assets/js/pgnview.js') }}"></script>
    <script src="{{ asset('assets/js/chess.0.10.3.js') }}"></script>
    <script src="{{ asset('assets/js/chessboard-1.0.0.js') }}"></script>
</x-menu.layout>
<x-menu.layout>
    <x-menu.sidebar/>
    <div id="page-content-wrapper">
    <x-menu.navbar/>
    <div class="container">
        @php
            $games = auth()->user()->games();
        @endphp
        @if (count($games) == 0)
            <h1>no games</h1>
        @else
        <table class="table table-light table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">white</th>
                    <th scope="col">black</th>
                    <th scope="col">result</th>
                    <th scope="col">type</th>
                    <th scope="col">date</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($games as $game)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td> {{ $game->white_player->user_name }} </td>
                        <td> {{ $game->black_player->user_name }} </td>
                        <td> <a href="/games/{{$game->id}}"> {{ $game->result }} </a></td>
                        <td> {{ $game->gameType() }} </td>
                        <td> {{ $game->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    </div>
</x-menu.layout>
<x-menu.layout>
    <x-menu.sidebar/>
    <div id="page-content-wrapper">
    <x-menu.navbar/>
    <div class="container">
        <table class="table">
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
            <tbody>
                @foreach (auth()->user()->games() as $game)
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
    </div>
    </div>
</x-menu.layout>
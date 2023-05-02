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
        <table class="table table-light table-striped border table-hover">
            <thead>
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">Full Name</th>
                    <th class="text-center" scope="col">User Name</th>
                    <th class="text-center" scope="col">Email</th>
                    <th class="text-center" scope="col">Number of games</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($users as $user)
                    <tr>
                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td class="text-center"> {{ $user->fullName() }} </td>
                        <td class="text-center"> {{ $user->user_name }} </td>
                        <td class="text-center"> {{ $user->email }} </td>
                        <td class="text-center"> {{ $user->games()->count() }} </td>
                        <td class="text-center">
                            <form method="POST" action="/users/{{$user->id}}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">delete</button>
                            </form>
                        </td>
                        {{-- <td> <a href="/games/{{$game->id}}"> {{ $game->result }} </a></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    </div>
</x-menu.layout>
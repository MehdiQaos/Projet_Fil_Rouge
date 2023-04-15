<x-dashboard.layout>
    {{-- {{auth()->user()->role->name}} --}}
    @if (auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'superadmin')
        <x-dashboard.sidebar/>
    @endif
    <div id="page-content-wrapper">
        <x-dashboard.navbar/>
        <x-menu :games="$games"/>
    </div>
</x-dashboard.layout>
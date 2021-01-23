<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success_message'))
                <x-alert>{{session('success_message')}}</x-alert> 
            @endif
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-medium">Subscribers Table</h1>
                <x-link-button href="{{route('subscribers.create')}}">New</x-link-button>
            </div>
            @livewire('subscribers-table')
        </div>
    </div>
</x-app-layout>

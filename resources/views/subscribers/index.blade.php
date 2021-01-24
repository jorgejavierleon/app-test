<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success_message'))
                <x-alert>{{session('success_message')}}</x-alert> 
            @endif
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-medium">Subscribers Table</h1>
                <div>
                    <x-link-button href="{{route('subscribers.create')}}">New</x-link-button>
                    <x-link-button title="Download csv" href="{{route('subscribers.download')}}">csv</x-link-button>
                </div>
            </div>
            @livewire('subscribers-table')
        </div>
    </div>
</x-app-layout>

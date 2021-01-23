<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-medium">Edit {{$subscriber->fullname}}</h1>
            </div>
            @livewire('subscribers-form', ['subscriber' => $subscriber, 'update_mode' => true])
        </div>
    </div>
</x-app-layout>

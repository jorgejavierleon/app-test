@props([
    'cancelable' => 'true',
    'type' => 'success',
    'colors' => [
        'success' => 'bg-green-500',
        'error' => 'bg-red-500'
    ],
])
<div x-data="{show: true}">
    <div x-show="show" class="flex justify-end" style="margin-top:-29px">
        <div {{ $attributes->merge(['class' => "{$colors[$type]} px-6 py-3 border-0 rounded relative mb-4 opacity-70"]) }} 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             >
             <span class="inline-block mr-8 text-white align-middle ">
                 {{$slot}}
             </span>
             @if($cancelable == 'true')
                 <button @click="show = false" class="absolute top-0 right-0 mt-3 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none">
                     <span>×</span>
                 </button>
            @endif
        </div>
    </div>
</div>

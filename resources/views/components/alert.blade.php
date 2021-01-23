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
        <div {{ $attributes->merge(['class' => "{$colors[$type]} text-white px-6 py-3 border-0 rounded relative mb-4 w-1/3 opacity-70"]) }} 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             >
             <span class="inline-block align-middle mr-8">
                 {{$slot}}
             </span>
             @if($cancelable == 'true')
                 <button @click="show = false" class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-3 mr-6 outline-none focus:outline-none">
                     <span>×</span>
                 </button>
            @endif
        </div>
    </div>
</div>

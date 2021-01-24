<section class="px-6 py-16 mx-auto bg-gray-900 md:px-12">
    <h3 class="text-2xl text-white md:text-3xl">Win Me</h3>
    <div class="max-w-2xl mx-auto mt-12">
        @if ($errors->any())
            <x-alert type="error" cancelable='false'>{{$errors->first()}}</x-alert> 
        @endif
        @if (session()->has('success_message'))
            <x-alert type="success" cancelable='true'>{{session('success_message')}}</x-alert> 
        @endif
      <form wire:submit.prevent="storeSubscriber" action="#" method="POST">
        <div class="flex py-1">
          <span class="p-2 w-28">Firstname</span>
          <input
            wire:model.difer="firstname"
            type="text"
            name="firstname"
            class="w-full p-2 text-gray-800 rounded"
            placeholder="Type here..."
            required
          />
        </div>
        <div class="flex py-1">
          <span class="p-2 w-28">Lastname</span>
          <input
            wire:model.difer="lastname"
            type="text"
            name="lastname"
            class="w-full p-2 text-gray-800 rounded"
            placeholder="Type here..."
            required
          />
        </div>
        <div class="flex py-1">
          <span class="p-2 w-28">Email</span>
          <input
            wire:model.difer="email"
            type="email"
            name="email"
            class="w-full p-2 text-gray-800 rounded"
            placeholder="Type here..."
            required
          />
        </div>
        <div class="flex py-1">
          <span class="p-2 w-28">Birthday</span>
          <input
            wire:model.difer="birthday"
            type="date"
            name="birthday"
            class="w-full p-2 text-gray-800 rounded"
            placeholder="Type here..."
          />
        </div>
        <div class="flex py-1">
          <span class="p-2 w-28">Birth City</span>
          <input
            wire:model.difer="city"
            type="text"
            name="city"
            class="w-full p-2 text-gray-800 rounded"
            placeholder="Type here..."
          />
        </div>
        <div class="flex py-1">
          <span class="p-2 w-28">Country</span>
          <input
            wire:model.difer="country"
            type="text"
            name="country"
            class="w-full p-2 text-gray-800 rounded"
            placeholder="Type here..."
          />
        </div>
        <div class="py-2 text-right">
            <button 
                type="submit"
                class="inline-flex items-center px-4 py-2 text-gray-800 bg-white border border-transparent border-gray-300 rounded hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            >
                Subscribe
            </button>
        </div>
      </form>
    </div>
</section>

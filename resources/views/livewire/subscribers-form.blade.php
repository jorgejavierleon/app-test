<div>
@if ($errors->any())
    <x-alert type="error" cancelable='false'>{{$errors->first()}}</x-alert> 
@endif
 <form wire:submit.prevent="createOrUpdate" action="#" method="POST">
    <div class="shadow overflow-hidden sm:rounded-md">
      <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-9 gap-6">
          <div class="col-span-3">
            <!-- Name -->
            <x-label for="name" :value="__('First Name')" />
            <x-input wire:model.difer="firstname" id="firstname" class="block mt-1 w-full" type="text" name="firstname" required />
          </div>
          <div class="col-span-3">
            <!-- Last Name -->
            <x-label for="name" :value="__('Last Name')" />
            <x-input wire:model.defer="lastname" class="block mt-1 w-full" type="text" name="lastname" required/>
          </div>

          <div class="col-span-3">
            <!-- Emanil -->
            <x-label for="email" :value="__('Email')" />
            <x-input wire:model.defer="email" class="block mt-1 w-full" type="email" name="email" required/>
          </div>

          <div class="col-span-3">
            <!-- Birthday -->
            <x-label for="birthday" :value="__('Birthday')" />
            <x-input wire:model.defer="birthday" class="block mt-1 w-full" type="date" name="birthday" />
          </div>
          <div class="col-span-3">
            <!-- City -->
            <x-label for="city" :value="__('Town of birth')" />
            <x-input wire:model.defer="city" class="block mt-1 w-full" type="text" name="city" required/>
          </div>
          <div class="col-span-3">
            <!-- Country -->
            <x-label for="country" :value="__('Country of living')" />
            <x-input wire:model.defer="country" class="block mt-1 w-full" type="text" name="country" required/>
          </div>
        </div>
      </div>
      <div class="flex justify-between px-4 py-3 bg-gray-50 sm:px-6">
          <div>
              @if(request()->routeIs('subscribers.edit'))
                  <x-modal 
                      title="Delete subscriber"
                      submitLabel="Delete"
                    >
                    <x-slot name="trigger">
                        <x-link-button @click="on = true" state="danger" href='#'>Delete</x-link-button>
                    </x-slot>
                    Are you sure you want to delete this subscriber
                  </x-modal>
              @endif
          </div>
          <div class="text-right">
              <x-link-button state="cancel" href="{{route('subscribers')}}">Cancel</x-link-button>
              <x-button type="submit" >
                  Save
              </x-button>
          </div>
      </div>
    </div>
  </form>   
  @if(request()->routeis('subscribers.edit'))
  @endif
</div>

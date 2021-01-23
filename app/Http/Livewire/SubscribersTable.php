<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class SubscribersTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.subscribers-table', [
            'subscribers' => Subscriber::paginate(10)
        ]);
    }
}

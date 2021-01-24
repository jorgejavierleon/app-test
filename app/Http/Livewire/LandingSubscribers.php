<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class LandingSubscribers extends Component
{
    public $firstname;
    public $lastname;
    public $email;
    public $birthday;
    public $city;
    public $country;

    public function render()
    {
        return view('livewire.landing-subscribers');
    }

    public function storeSubscriber()
    {
        $this->validate(Subscriber::$rules);

        Subscriber::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'city' => $this->city,
            'country' => $this->country,
        ]);
        
        $this->resetForm();
        session()->flash('success_message', 'Form submited. We will send you a validation email');
    }

    private function resetForm()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->birthday = '';
        $this->city = '';
        $this->country = '';
    }
}

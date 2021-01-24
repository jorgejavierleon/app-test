<?php

namespace App\Http\Livewire;

use App\Mail\VerifyEmail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
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

        $subscriber = Subscriber::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'city' => $this->city,
            'country' => $this->country,
        ]);
        Mail::to($subscriber)->send(new VerifyEmail($subscriber)); 
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

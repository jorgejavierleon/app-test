<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class SubscribersForm extends Component
{
    public $subscriber;
    public $update_mode = false;
    public $selected_id;
    public $firstname;
    public $lastname;
    public $email;
    public $birthday;
    public $city;
    public $country;

    
    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:subscribers',
        'city' => 'required|string',
        'country' => 'required|string',
    ];

    public function mount()
    {
        if($this->subscriber){
            $this->setSelectedSubscriber();
        }
    }

    public function render()
    {
        return view('livewire.subscribers-form');
    }

    public function createOrUpdate()
    {
        if($this->update_mode){
            return $this->updateSubscriber();
        }
        return $this->storeSubscriber();
    }

    public function storeSubscriber()
    {
        $this->validate();

        Subscriber::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'city' => $this->city,
            'country' => $this->country,
        ]);
        
        $this->resetForm();
        session()->flash('success_message', 'Subscriber successfully created.');
        redirect()->route('subscribers');
    }

    public function updateSubscriber()
    {
        if(!$this->subscriber){
            return;
        }
        $update_rules = $this->rules;
        $update_rules['email'] = 'required|email|unique:subscribers,email,'. $this->subscriber->id;
        $this->validate($update_rules);

        $this->subscriber->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'city' => $this->city,
            'country' => $this->country,
        ]);
        redirect()->route('subscribers');
        session()->flash('success_message', 'Subscriber successfully updated.');
    }

    public function deleteSubscriber()
    {
        if(!$this->subscriber){
            return;
        }
        $this->subscriber->delete();
        redirect()->route('subscribers');
        session()->flash('success_message', 'Subscriber successfully deleted.');
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

    private function setSelectedSubscriber()
    {
        $this->firstname = $this->subscriber->firstname;
        $this->lastname = $this->subscriber->lastname;
        $this->email = $this->subscriber->email;
        $this->birthday = $this->subscriber->birthday;
        $this->city = $this->subscriber->city;
        $this->country = $this->subscriber->country;
    }
}

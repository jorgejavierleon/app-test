<?php

namespace Tests\Feature;

use App\Http\Livewire\LandingSubscribers;
use App\Http\Livewire\SubscribersForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

class SubscribersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_show_list_of_subscribers()
    {
        Subscriber::factory()->create([
            'firstname' => 'peter'
        ]);
        $this->actingAsAdmin();
        $this->withoutExceptionHandling();
        $response = $this->get('admin/subscribers');

        $response->assertStatus(200);
        $response->assertSee('Peter');
    }

    /**
     * @test
     */
    public function an_admin_can_add_subscribers()
    {
        $subscriber_data = Subscriber::factory()->make(['firstname' => 'Pedrossd']);
        $this->actingAsAdmin();
        $this->withoutExceptionHandling();
        
        Livewire::test(SubscribersForm::class)
            ->set('firstname', $subscriber_data->firstname)        
            ->set('lastname', $subscriber_data->lastname)        
            ->set('email', $subscriber_data->email)        
            ->set('city', $subscriber_data->city)
            ->set('country', $subscriber_data->country)
            ->call('storeSubscriber');        

        $this->assertTrue(Subscriber::whereFirstname('Pedrossd')->exists());
    }

    /**
     * @test
     */
    public function an_admin_can_update_subscribers()
    {
        $subscriber = Subscriber::factory()->create(['firstname' => 'Pedrossd']);
        $this->actingAsAdmin();
        $this->withoutExceptionHandling();
        
        Livewire::test(SubscribersForm::class)
            ->set('subscriber', $subscriber)        
            ->set('firstname', 'Carlos')        
            ->set('lastname', $subscriber->lastname)        
            ->set('email', $subscriber->email)        
            ->set('city', $subscriber->city)
            ->set('country', $subscriber->country)
            ->call('updateSubscriber');        

        $subscriber->refresh();
        $updated = Subscriber::find($subscriber->id);
        $this->assertEquals('Carlos', $subscriber->firstname);
    }

    /**
     * @test
     */
    public function an_admin_can_delete_subscribers()
    {
        $subscriber = Subscriber::factory()->create();
        $this->actingAsAdmin();
        $this->withoutExceptionHandling();

        Livewire::test(SubscribersForm::class)
            ->set('subscriber', $subscriber)        
            ->call('deleteSubscriber');        

        $this->assertFalse(Subscriber::whereId($subscriber->id)->exists());
    }

    /**
     * @test
     */
    public function a_guest_can_subscribe()
    {
        Mail::fake();
        $subscriber_data = Subscriber::factory()->make(['firstname' => 'Pedrossd']);
        
        Livewire::test(LandingSubscribers::class)
            ->set('firstname', $subscriber_data->firstname)        
            ->set('lastname', $subscriber_data->lastname)        
            ->set('email', $subscriber_data->email)        
            ->set('city', $subscriber_data->city)
            ->set('country', $subscriber_data->country)
            ->call('storeSubscriber');        

        $this->assertTrue(Subscriber::whereFirstname('Pedrossd')->exists());
        $created_subscriber = Subscriber::whereFirstname('Pedrossd')->first();
        $this->assertFalse($created_subscriber->hasVerifiedEmail());

        //An email is sent
        Mail::assertSent(ValidateEmail::class, function($email) use ($created_subscriber){
            return $email->hasTo($created_subscriber->email);
        });
    }
}

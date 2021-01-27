<?php

namespace Tests\Feature;

use App\Http\Livewire\LandingSubscribers;
use App\Http\Livewire\SubscribersForm;
use App\Mail\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Subscriber;
use App\Models\User;
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
    public function an_admin_can_download_all_subscribers_in_csv()
    {
        $this->withoutExceptionHandling();
        $this->actingAsAdmin()
             ->get('admin/subscribers/download')
             ->assertOk();
    }

    /**
     * @test
     */
    public function a_guest_can_subscribe()
    {
        Mail::fake();
        $subscriber_data = Subscriber::factory()->make(['firstname' => 'Pedrossd']);
        $this->withoutExceptionHandling();
        
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
        Mail::assertQueued(VerifyEmail::class, function($email) use ($created_subscriber){
            return $email->hasTo($created_subscriber->email);
        });
    }

    /**
     * @test
     */
    public function an_email_can_be_verified_by_the_subscriber()
    {
        $subscriber = Subscriber::factory()->create([
            'email_verified_at' => null,
        ]);
        $verificationUrl = $subscriber->signedVerificationEmailUrl();
        $response = $this->get($verificationUrl);
        $response->assertSee($subscriber->email);

        $this->assertTrue($subscriber->fresh()->hasVerifiedEmail());
    }

    /**
     * @test
     */
    public function it_sotres_subscribers_via_api()
    {
        $this->withoutExceptionHandling();
        $subscriber = Subscriber::factory()->make();
        $data = [
            'firstname' => $subscriber->firstname,
            'lastname' => $subscriber->lastname,
            'email' => $subscriber->email,
            'birthday' => $subscriber->birthday,
            'city' => $subscriber->city,
            'country' => $subscriber->country,
        ];
        $user = User::factory()->create();
        $headers = [
            'Authorization' => 'Bearer '. $user->api_token,
        ];
        $response = $this->postJson('/api/subscribers', $data, $headers);
        $response
            ->assertStatus(201)
            ->assertJson(['created' => true]);

        $this->assertTrue(Subscriber::whereEmail($subscriber->email)->exists());
    }


    /**
     * @test
     */
    public function it_can_have_meta_values()
    {
        $this->withoutExceptionHandling();
        $subscriber = Subscriber::factory()->create();

        $subscriber->updateOrCreateMeta('age', '32');
        $this->assertTrue($subscriber->hasMetas());
        $this->assertEquals('32', $subscriber->getMeta('age'));

        $subscriber->deleteMeta('age');
        
        $this->assertFalse($subscriber->hasMetas());
    }

}

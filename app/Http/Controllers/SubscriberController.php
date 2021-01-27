<?php

namespace App\Http\Controllers;

use App\Http\Exports\ExportSubscribers;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscribers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscribers.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        return view('subscribers.edit', compact('subscriber'));
    }

    /**
     * Store the subscriber via api request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorizeToken($request);
        $this->validate($request, Subscriber::$rules);

        $subscriber = Subscriber::create([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'birthday' => $request->get('birthday'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
        ]);
        return response()->json([
            'created' => true,
            'data' => $subscriber
        ], 201);
    }

    /**
     * Verify the email
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function verifyEmail(Request $request)
    {
        $subscriber = Subscriber::findOrFail($request->get('subscriber'));
        $subscriber->update(['email_verified_at' => now()]);
        return $subscriber->email . ' verify';
    }

    /**
     * Verify the email
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        $exporter = new ExportSubscribers();
        return $exporter->export();
    }

    /**
     * Validate the api token 
     */
    public function authorizeToken(Request $request)
    {
        if(!User::where('api_token',  $request->bearerToken())->exists()){
            throw new AuthenticationException();
        };
        return;
    }
}

<?php

namespace App\Http\Controllers;

use Mail;
use App\Notifications\SendNotificationMail;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::select('id','name','email','message');
        return datatables($messages)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        $message =  Message::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'message' => $fields['message']
        ]);
        $admin = User::where('id', 1)->first();

        Notification::send($admin, new SendNotificationMail($message));


        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::find($id);
        return $message;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        $message->update($request->all());
        return $message;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Message::destroy($id);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    public function search($message)
    {
        return Message::where('message', 'like', '%'. $message. '%')->get();
    }
}

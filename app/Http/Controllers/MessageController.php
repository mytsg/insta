<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\MessageCreated;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','<>', Auth::id())
        ->get();

        return Inertia::render('Messages/Index',[
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        // dd($request);

        $message = Message::create([
            'send_id' => $request->send_id,
            'receive_id' => $request->receive_id,
            'message' => $request->message,
        ]);

        event(new MessageCreated($message));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $opponent = User::findOrFail($id);
        $authUser = User::findOrFail(Auth::id());
        $users = User::where('id','<>',Auth::id())
                ->orderBy('created_at','desc')
                ->get();

        return Inertia::render('Messages/Show',[
            'opponent' => $opponent,
            'authUser' => $authUser,
            'users' => $users,
        ]);
    }

    public function getMessages($id)
    {
        $authId = Auth::id();

        $messages = Message::where([['send_id',$id],['receive_id',$authId]])
                    ->orWhere([['send_id',$authId],['receive_id',$id]])
                    ->orderBy('created_at','desc')
                    ->get(); //選んだ相手が自分に送信、または自分が相手に送信したものを取得
        
        return $messages;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}

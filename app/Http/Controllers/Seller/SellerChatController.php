<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repository\ChatInterface;
use Repository\UserInterface;
use Response,Input;

class SellerChatController extends Controller
{
    public $chatRepo;
    public $userRepo;
    public function __construct(ChatInterface $chatRepo, UserInterface $userRepo)
    {
        $this->chatRepo = $chatRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userUuid = '')
    {
        $this->userRepo->uuid     = $userUuid;
        $fromUser                 = $this->userRepo->getUserByAttribute();
        $fromId                   = $this->chatRepo->fromId                   = $fromUser->userId;
        $this->chatRepo->userUuid = $userUuid;
        $toId                     = $this->chatRepo->toId                     = session('userId');
        $chats                    = $this->chatRepo->getChats();
        $this->chatRepo->updateChatReadStatus();
        return view('seller/chat/chat', ['uuid' => $userUuid, 'chats' => $chats, 'fromId' => $fromId, 'toId' => $toId]);

    }

    public function getChatUsers()
    {
        $myId      = $this->chatRepo->myChatUserId      = session('userId');
        $users = $this->chatRepo->getChatUsers();
        return view('seller/chat/chatUser', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $jsonArray['error'] = 'error';
        $jsonArray['msg']   = 'Invalid User';
        $toId               = $this->userRepo->uuid               = Input::get('uuid');
        if (!$toId) {
            return $jsonArray;
        }
        $this->chatRepo->fromId = session('userId');
        $this->chatRepo->toId   = $this->userRepo->getUserByAttribute()->userId;
        $res                    = $this->chatRepo->createChat($request);

        return Response::json($res); //response()->json($data[res, 200]['', $headers]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace Repository\Eloquent;

use App\Models\Chat;
use App\Models\User;
use DB;
use Repository\ChatInterface;
use Schema,Uuid;

class ChatRepo implements ChatInterface {

    public $loggedInUserId;
    public $fromId = null;
    public $toId = null;
    public $userUuid = null;
    public $chatId = null;
    public $chatUuid = null;
    public $myChatUserId = null;
    public $isRead = 0;

    public function getChats() {
        $this->checkChatUser();
        return $this->getData();
    }

    public function getChatByAttribute() {
        
    }

    public function getChatUsers() {
        return $this->getChatUsersData();
    }

    public function getData() {
        $query = Chat::orderBy('chats.created_at', 'asc');
        if ($this->isRead) {
            $query->where('chats.is_read', $this->isRead);
        }
        //$query->orderBy('chats.created_at', 'desc');
        if ($this->chatUuid) {
            $query->where('chats.uuid', $this->chatUuid);
            return $query->first();
        }
        $query->join('users', 'users.id', '=', 'chats.from_id');
        $query->join('companies', 'companies.id', '=', 'users.company_id');
        $query->whereRaw("((chats.to_id = $this->toId && chats.from_id = $this->fromId) || (chats.to_id = $this->fromId && chats.from_id = $this->toId))");
        $query->select('companies.name as companyName', 'chats.*', 'users.uuid as TouserUuid', 'users.name as userName');
        return $query->get();
    }

    public function getUnreadChats() {
        return $count = Chat::where('to_id', $this->myChatUserId)->where('is_read', $this->isRead)->count();
    }

    public function getChatUsersData() {
        $query = DB::table('user_friends')->orderBy('user_friends.last_interacted','Desc')->join('users', 'users.id', '=', 'user_friends.to_id');
        $query->join('companies', 'companies.id', '=', 'users.company_id');
        $query->select('users.id as userId', 'users.uuid as userUuid', 'users.name as userName',  'companies.name as companyName', 'user_friends.last_interacted');
        $query->addSelect(DB::raw('(select DISTINCT count(*) from chats where chats.to_id = ' . $this->myChatUserId . '  and chats.from_id = user_friends.to_id and is_read = 0) as unreadChat'));
        $query->where('user_friends.from_id', $this->myChatUserId);
        return $query->get();
    }

    public function checkChatUser() {
        //if($this->fromId == $this->toId) return;
        $toId = $this->fromId;
        $fromId = $this->toId;
        $data = DB::table('user_friends')->whereRaw("((to_id = $toId && from_id = $fromId) || (to_id = $fromId && from_id = $toId))")->get();
        if (!$data) {
            DB::table('user_friends')->insert([
                ['to_id' => $toId, 'from_id' => $fromId],
                ['to_id' => $fromId, 'from_id' => $toId],
            ]);
        }
    }

    public function updateChatReadStatus(){
        DB::table('chats')
            ->where('to_id', $this->toId)
            ->where('from_id', $this->fromId)
            ->update(['is_read' => 1]);
    }
    
    public function createChat($post) {
        date_default_timezone_set('Asia/Calcutta');
        $chatColumns = Schema::getColumnListing('chats');
        $chat = new Chat;
        foreach ($chatColumns as $k1 => $v1) {
            if (isset($post[$v1])) {
                $chat->$v1 = trim($post[$v1]);
            }
        }
        $chat->uuid = Uuid::generate();;
        $chat->from_id = $this->fromId;
        $chat->to_id = $this->toId;
        $chat->created_at = date('Y-m-d H:i:s'); 
        $chat->save();
        DB::table('user_friends')
                ->where('from_id', $this->fromId)
                ->where('to_id', $this->toId)
                ->update(['last_interacted' => date('Y-m-d H:i:s')]);
        DB::table('user_friends')
                ->where('from_id', $this->toId)
                ->where('to_id', $this->fromId)
                ->update(['last_interacted' => date('Y-m-d H:i:s')]);

        //send notification 
        $fromUser = User::find($this->fromId);        
        $toUser = User::find($this->toId); 
        $type = 'chatmsg~' . $fromUser->uuid . '~' . $fromUser->name;
        $message = $fromUser->name.' has sent you new message';       
        //$data = trigger_gcm($toUser->device_id,$message,$type);        
        //print_r($data);
    }

}

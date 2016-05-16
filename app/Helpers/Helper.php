<?php

namespace App\Helpers;
use Repositories\Eloquent\NotificationRepo as NotificationRepo;
use Repositories\Eloquent\ChatRepo as ChatRepo;
use Repositories\Eloquent\MasterRepo as MasterRepo;
use Repositories\Eloquent\UserRepo as UserRepo;
use Session;
class Helpers
{
    public static function getNotifications($is_read = 0)
    {

        $notification = new NotificationRepo;
        $notification->isRead = $is_read;
        $notification->userId = session('userId');
        $data = $notification->getNotificationByAttribute();
        
        return $data;
    }

    public static function getUnreadChat($is_read = 0)
    {

        $notification = new ChatRepo;
        $notification->isRead = $is_read;
        $notification->myChatUserId = session('userId');
        $data = $notification->getUnreadChats();
        
        return $data;
    }

    public static function getModes(){
        $master = new MasterRepo;
        $master->tableName = 'modes';
        $data = $master->getMasterByTable();
        return $data;
    }

    public static function sendChatNotification($from ,$to, $message,$type){

    }


    public static function sendNotification($user,$message,$type){

    }
}

?>

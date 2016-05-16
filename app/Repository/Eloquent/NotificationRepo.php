<?php
namespace Repository\Eloquent;
use Repository\NotificationInterface;
use App\Models\Notification;
use App\Models\User;
use Session,Uuid,DB,Schema;
class NotificationRepo implements NotificationInterface
{

	public $loggedInUser;
    public $buyerId;
    public $sellerId;
    public $fromId;
	public $toId;
	public $uuid;
	public function getNotifications(){

	}

	public function getNotificationById(){

	}

	public function saveNotification($data){
	 
     $notificationColumns = Schema::getColumnListing('notifications');
     /*$userData = new UserRepo();
     $userData->companyId = $data['company_id'];
     $resultArray = $userData->getData();*/
     
     $query = User::join('companies', 'users.company_id', '=', 'companies.id');
     $query->where('companies.id', '=', $data['company_id']);
     $query->select('users.id as user_id','users.name as user_name', 'companies.name as compny_name', 'users.status', 'users.email', 'users.uuid', 'users.user_type', 'users.role_id');
     $resultArray = $query->get();
 
     foreach($resultArray as $k=>$user){
     	$notifiication = new Notification();
     	$notifiication->uuid = Uuid::generate();
       foreach ($data as $key => $value) {
                if (in_array($key, $notificationColumns)) {
                    $notifiication->$key = $value;
                }
            }
       $notifiication->to_id = $user->user_id;
       $result = $notifiication->save();

     }
     return $result;
	}

	public function getData(){

	}

	public function save($data){

	}
}
?>
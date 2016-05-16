<?php

namespace Repository;

interface NotificationInterface {
	public function getNotifications();
	public function getNotificationById();
	public function saveNotification($arrayData);
}

?>
<?php
namespace Repository;

interface ChatInterface{
	public function getChats();
	public function getChatByAttribute();
	public function getChatUsers();
	//public function checkChatUser();
}
?>
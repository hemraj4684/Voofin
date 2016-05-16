<?php
namespace Repository;

interface BuyerInterface {
	public function getData();
	public function store($data);
	//public function buyerConfiguration(Request $request);  
}


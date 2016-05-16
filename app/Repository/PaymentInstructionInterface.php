<?php
namespace Repository;

interface PaymentInstructionInterface {
	public function getData();
	public function store($data);
}
<?php

// Warning! This code was generated by WSDL2PHP tool. 
// author: Filippov Andrey <afi.work@gmail.com> 
// see https://solo-framework-lib.googlecode.com 

namespace Moneta\Types;

/**
 * Ответ на запрос FindContractsRequest.
	 * Response to FindContractsRequest.
	 * 
 */
class FindContractsResponse
{
	
	/**
	 * 
	 *
	 * @var Contract
	 */
	 public $contract = null;

	/**
	 * 
	 *
	 * @param Contract
	 *
	 * @return void
	 */
	public function addContract(Contract $item)
	{
		$this->contract[] = $item;
	}

}

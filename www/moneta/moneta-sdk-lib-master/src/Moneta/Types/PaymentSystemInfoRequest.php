<?php

// Warning! This code was generated by WSDL2PHP tool. 
// author: Filippov Andrey <afi.work@gmail.com> 
// see https://solo-framework-lib.googlecode.com 

namespace Moneta\Types;

/**
 * Запрос информации об платежных системах.
	 * Request information about payments system
	 * 
 */
class PaymentSystemInfoRequest
{
	
	/**
	 * Номер счета в системе МОНЕТА.РУ.
	 * MONETA.RU account number.
	 * 
	 *
	 * @var long
	 */
	 public $accountId = null;

	/**
	 * 
	 *
	 * @var decimal
	 */
	 public $amount = null;

}

<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

include("exchangerate_ua.php");

class Currencies_hook
{
	function toUAH(&$bean, $event, $arguments)
    {
		$bean->currency_uah=$this->to_uah($bean->totalcost, $bean->currency);
		//$this->toUAH_update(); //!TODO ÏÅÐÅÊÈÍÓÒÜ Â ÏËÀÍÈÐÎÂÙÈÊ!
	}
	
	function to_uah($cost_, $currency_)
	{
		//ïîëó÷àåì àêòóàëüíûé êóðñ
		$er = new ExchangeRate();
		$currency_=strtoupper($currency_);
		if($currency_=='RUR') $currency_='RUB';
		if($currency_!='UAH')
		{
			$data = $er->getExchangeRateByChar3($currency_);
			return (floatval($data->rate)/floatval($data->size)*$cost_);
		}
		else
			return $cost_;
	}
	
	function toUAH_update()
	{
		$realty_ = new Realty();
		
		//ïîëó÷àåì àêòóàëüíûé êóðñ
		$er = new ExchangeRate();
		
		$data = $er->getExchangeRateByChar3('USD');
		$usd=floatval($data->rate)/floatval($data->size);
		
		$data = $er->getExchangeRateByChar3('EUR');
		$eur=floatval($data->rate)/floatval($data->size);
		
		$data = $er->getExchangeRateByChar3('RUB');
		$rur=floatval($data->rate)/floatval($data->size);
		
		//SELECT * FROM `realty` where id = '37844731-3aaa-65b0-e84b-51b36762ab81'
		//UPDATE `realty` SET `currency_uah` = ( `totalcost` * 0.25 ) WHERE id = '37844731-3aaa-65b0-e84b-51b36762ab81'
		
		$query_usd="UPDATE `realty` SET `currency_uah` = ( `totalcost` * $usd ) WHERE UPPER(currency) = 'USD'";
		$query_eur="UPDATE `realty` SET `currency_uah` = ( `totalcost` * $eur ) WHERE UPPER(currency) = 'EUR'";
		$query_rur="UPDATE `realty` SET `currency_uah` = ( `totalcost` * $rur ) WHERE UPPER(currency) = 'RUR'";
		$query_uah="UPDATE `realty` SET `currency_uah` = `totalcost` WHERE UPPER(currency) = 'UAH'";
		
		$result=$realty_->db->query($query_usd, true);
		$result=$realty_->db->query($query_eur, true);
		$result=$realty_->db->query($query_rur, true);
		$result=$realty_->db->query($query_uah, true);
	}
}
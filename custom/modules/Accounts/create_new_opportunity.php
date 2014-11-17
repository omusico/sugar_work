<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 class CreateNewOpportunityFromAccount{

     function create(&$bean){

         if (empty($_REQUEST['record']))
         {

             global $current_user;

             $bean->assigned_user_id = $current_user->id;

             $relate_field = "account_id";

             $opportunity = new Opportunity();
             $opportunity->name = "Сделка с клиентом " . $bean->name . " от " . date("d.m.Y");
             $opportunity->$relate_field = $bean->id;
             $opportunity->assigned_user_id = $bean->assigned_user_id;
             $opportunity->type_of_realty = "client";
             $opportunity->save();
         }
     }
 }
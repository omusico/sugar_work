<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 class CreateNewOpportunityFromContact{

     function create(&$bean){

         if ($bean->code_inc=='')
         {
             $relate_field = "contact_id";

             $opportunity = new Opportunity();
             $opportunity->name = "Сделка с клиентом " . $bean->last_name . " " . $bean->first_name . " от " . date("d.m.Y");
             $opportunity->$relate_field = $bean->id;
             $opportunity->assigned_user_id = $bean->assigned_user_id;
             $opportunity->type_of_realty = "client";
             $opportunity->save();
         }
     }
 }
<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 class AddRealtyFromOpportunities{

     function addRealty(&$bean)
     {
         $bean->load_relationship("realty_contracts");
         $bean->realty_contracts->delete($bean->id);

         $opp = new Opportunity();
         $opp->retrieve($bean->opp_id);

         $realty_list = $opp->get_linked_beans('realty_opportunities', 'Opportunities');

         foreach($realty_list as $realty)
         {
             $bean->realty_contracts->add($realty->id);
         }
     }
 }
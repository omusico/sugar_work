<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
class AfterSaveHook {

    function execute(&$bean)
    {
        if ($bean->sales_stage == "completed")
        {
            $realty_list = $bean->get_linked_beans("realty_opportunities", "Realty");

            if(!empty($bean->contact_id))
            {
                $contact = new Contact();
                $contact->retrieve($bean->contact_id);

                foreach($realty_list as $realty)
                {
                    if($realty->operation == 'rent')
                    {
                        $contact->load_relationship("realty_contacts_rent");
                        $contact->realty_contacts_rent->add($realty->id);
                    }
                    elseif($realty->operation == 'buying')
                    {
                        $contact->load_relationship("realty_contacts_buying");
                        $contact->realty_contacts_buying->add($realty->id);
                    }

                }
            }

            if(!empty($bean->account_id))
            {
                $account = new Account();
                $account->retrieve($bean->account_id);

                foreach($realty_list as $realty)
                {
                    if($realty->operation == 'rent')
                    {
                        $account->load_relationship("realty_accounts_rent");
                        $account->realty_accounts_rent->add($realty->id);
                    }
                    elseif($realty->operation == 'buying')
                    {
                        $account->load_relationship("realty_accounts_buying");
                        $account->realty_accounts_buying->add($realty->id);
                    }
                }
            }
        }
    }
}
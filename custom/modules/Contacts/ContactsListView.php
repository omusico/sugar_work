<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Contacts/Contact.php');

class ContactsListView extends Contact {

    function ContactsListView() {
        parent::Contact();
    }

    function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false, $parentbean=null, $singleSelect = false){

        $dateWhereClause = '';
        $and = '';
        $fromClause = '';
        $toClause = '';

        require_once('custom/modules/Contacts/rangeSearch.php');

        $where = str_replace('contacts.square >=', 'contacts.square_min >=', $where);
        $where = str_replace('contacts.square <=', 'contacts.square_max <=', $where);
        $where = str_replace('contacts.cost_to =', 'contacts.cost_to <=', $where);

        $pre_where = getRangeSearch('contacts', 'square', '_min', '_max', $_REQUEST, $where);

        if (!empty($pre_where))
        {
            $where = "(" . $pre_where . " ) " ." AND " . $where;
        }


        $ret_array = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, true, $parentbean, $singleSelect);

        //to make these custom fields pre-populatable, they had to go in searchdefs. But that automatically
        //puts them in the query as sugar wants. But we want to use these fields as we wish. So remove what sugar adds.
        $ret_array['where'] = preg_replace('/\(\s?contacts\.max_square[^)]+\)/', '1', $ret_array['where']);
        $ret_array['where'] = preg_replace('/\(\s?contacts\.min_square[^)]+\)/', '1', $ret_array['where']);

        $ret_array['where'] .= $dateWhereClause;

        if ( !$return_array ){

            return  $ret_array['select'] . $ret_array['from'] . $ret_array['where']. $ret_array['order_by'];
        }

        return $ret_array;
    }
}
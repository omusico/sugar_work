<?php
require_once('custom/include/Dashlets/DashletGenericFunnelChart.php');

class VoronkaDashlet extends DashletGenericFunnelChart
{
    protected $_seedName = 'Opportunities';
    protected $groupBy = array('a');
    public $v_date_start;
    public $v_date_end;
    public $v_ids = array();

    public function __construct($id, array $options = null)
    {
        global $timedate;
        if(empty($options['v_date_start']))
            $options['v_date_start'] = $timedate->nowDbDate();
        if(empty($options['v_date_end']))
            $options['v_date_end'] = $timedate->asDbDate($timedate->getNow()->modify("+6 months"));
        parent::__construct($id,$options);
    }

    public function displayOptions()
    {
        if (!isset($this->v_ids) || count($this->v_ids) == 0)
            $this->_searchFields['v_ids']['input_name0'] = array_keys(get_user_array(false));
        return parent::displayOptions();
    }


    protected function getDataset()
    {
        global $db;
        $query = "Select count(id) FROM calls ".
                 " WHERE DATE_FORMAT(calls.date_start, '%Y-%m-%d') >= ".db_convert("'".$this->v_date_start."'",'date') .
                 " AND DATE_FORMAT(calls.date_end, '%Y-%m-%d') <= ".db_convert("'".$this->v_date_end."'",'date') .
                 " AND calls.deleted=0" ;
        if ( count($this->v_ids) > 0 )
            $query .= " AND calls.assigned_user_id IN ('".implode("','",$this->v_ids)."') ";
        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);

        $query2 = "Select count(id) FROM meetings ".
                  " WHERE DATE_FORMAT(meetings.date_start, '%Y-%m-%d') >= ".db_convert("'".$this->v_date_start."'",'date').
                  " AND DATE_FORMAT(meetings.date_end, '%Y-%m-%d') <= ".db_convert("'".$this->v_date_end."'",'date') .
                  " AND meetings.deleted=0";
        if ( count($this->v_ids) > 0 )
            $query2 .= " AND meetings.assigned_user_id IN ('".implode("','",$this->v_ids)."') ";
        $result2 = $db->query($query2);
        $row2 = $db->fetchByAssoc($result2);

        $query3 = "Select count(id) FROM opportunities";
        $query3 .= " WHERE DATE_FORMAT(opportunities.date_closed, '%Y-%m-%d') >= ".db_convert("'".$this->v_date_start."'",'date') .
                        " AND DATE_FORMAT(opportunities.date_closed, '%Y-%m-%d') <= ".db_convert("'".$this->v_date_end."'",'date') .
                        " AND opportunities.deleted=0";
        if ( count($this->v_ids) > 0 )
            $query3 .= " AND opportunities.assigned_user_id IN ('".implode("','",$this->v_ids)."') ";
        $result3 = $db->query($query3);
        $row3= $db->fetchByAssoc($result3);

        $query4 = "Select count(id) FROM opportunities WHERE opportunities.sales_stage = 'completed'";
        $query4 .= " AND DATE_FORMAT(opportunities.date_closed, '%Y-%m-%d') >= ".db_convert("'".$this->v_date_start."'",'date') .
                        " AND DATE_FORMAT(opportunities.date_closed, '%Y-%m-%d') <= ".db_convert("'".$this->v_date_end."'",'date') .
                        " AND opportunities.deleted=0";
        if ( count($this->v_ids) > 0 )
            $query4 .= " AND opportunities.assigned_user_id IN ('".implode("','",$this->v_ids)."') ";
        $result4 = $db->query($query4);
        $row4 = $db->fetchByAssoc($result4);
        $returnArray =
        array(
            array('a' => 'Звонки',  'total' => $row['count(id)'],),
            array('a' => 'Встречи',  'total' => $row2['count(id)'],),
            array('a' => 'Сделки',  'total' => $row3['count(id)'],),
            array('a' => 'Успешные сделки',  'total' => $row4['count(id)'],),   
            );

        return $returnArray;
    }
}
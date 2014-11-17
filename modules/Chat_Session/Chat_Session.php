<?PHP

require_once('modules/Chat_Session/Chat_Session_sugar.php');
class Chat_Session extends Chat_Session_sugar {
	
	function Chat_Session(){
		parent::Chat_Session_sugar();
	}

//    public function save()
//    {
//        $is_new = false;
//        if (empty($this->id)) {
//            $is_new = true;
//        }
//
//        $closeTaskType11 = false;
//        if ($this->fetched_row['order_status'] == 1 && $this->order_status != 1) {
//            $closeTaskType11 = true;
//        }
//
//        $createTaskType9 = false;
//        if ($this->fetched_row['order_status'] != 6 && $this->order_status == 6) {
//            $createTaskType9 = true;
//        }
//
//        $closeTaskType5 = false;
//        if ($this->fetched_row['order_status'] == 8 && $this->order_status != 8) {
//            $closeTaskType5 = true;
//        } elseif ($this->order_status == 8 && strtotime($this->delivery_date) > strtotime('+2 day')) {
//            $closeTaskType5 = true;
//        }
//
//
//        $closeTaskType3 = false;
//        $closeTaskType4 = false;
//        if ($this->fetched_row['order_status'] == 2 && $this->order_status != 2) {
//            $closeTaskType3 = true;
//            $closeTaskType4 = true;
//        }
//
//        $createTaskType2 = false;
//        if (($this->fetched_row['order_status'] == 2 && $this->order_status != 2) ||
//            (
//                ($this->fetched_row['payment_type'] == '' ||
//                    $this->fetched_row['payment_type'] == 'cc' ||
//                    $this->fetched_row['payment_type'] == 'mm' ||
//                    $this->fetched_row['payment_type'] == 'ym' ||
//                    $this->fetched_row['payment_type'] == 'wm') &&
//                ($this->payment_type != '' ||
//                    $this->payment_type != 'cc' ||
//                    $this->payment_type != 'mm' ||
//                    $this->fpayment_type != 'ym' ||
//                    $this->payment_type != 'wm'))
//        ) {
//            $createTaskType2 = true;
//        }
//
//        parent::save();
//
//        $db = DBManagerFactory::getInstance();
//        require_once 'custom/modules/Tasks/autocontactFunctions.php';
//
//        if ($this->order_status == 1 && $is_new) {
//            createTask(11, $this->parent_type, $this->parent_id, 'order', $this->id);
//        }
//
//        if ($closeTaskType11) {
//            closeTask(11, $this->parent_type, $this->parent_id);
//        }
//
//        if ($createTaskType9) {
//            createTask(9, $this->parent_type, $this->parent_id, 'order', $this->id);
//        }
//
//        if ($closeTaskType5) {
//            closeTask(5, $this->parent_type, $this->parent_id);
//        }
//
//        if ($closeTaskType3) {
//            closeTask(3, $this->parent_type, $this->parent_id);
//        }
//
//        if ($closeTaskType4) {
//            closeTask(4, $this->parent_type, $this->parent_id);
//        }
//
//        if ($createTaskType2) {
//            closeTask(2, $this->parent_type, $this->parent_id);
//        }
//
//    }


	
}
?>
<?php

class Sale extends CI_Model {
    
    public static function create($data) {
        $CI         = &get_instance();
        $database   = $CI->db;
        
        $today = strtotime("00:00:00");
        $data = array(
                    'user_id'     => $data['user_id'],
                    'day'         => $today,
                    'item_number'  => $data['user_id'],
                    'price'        => $data['price'],
                    'currency'     => $data['currency'],
                    'txn_id'       => '',
                    'txn_bank'     => $data['txn_bank'],
                    'user_mail'    => $data['user_mail'],
                    'ctime'        => time(),
                    'mtime'        => time()
            );
        
        $database->insert('sale', $data);
        return $database->insert_id();
    }
    
    public static function finish($data) {
       $CI         = &get_instance();
       $database   = $CI->db;
        
       $database->where('id', $data['ID']);
       $database->update('sale', array('user_mail' => $data['user_mail'], 'status' => 'Completed', 'tnx_id' => $data['tnx_id']));
    }
}
?>

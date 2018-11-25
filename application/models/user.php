<?php

class User extends CI_Model {
    
    const USER_SHOT_LITMI = 50;
    private $db;
    
    public function __construct() {
        parent::__construct();
        $CI             = &get_instance();
        $this->db = $CI->db;
        //here I should only 
        //return  self::getUser();
        //and then remove in code $user->user->...
        $this->user = self::getUser();
    }
    
    public static function getUser() {
        $CI         = &get_instance();
        $database   = $CI->db;
        $macAddress = User::getMacAddress();
        $today      = Utilities::getToday();
        $userObj    = $database->get_where('user', array('mac_address' => $macAddress, 'day' => $today))->row();
        if (is_null($userObj) || empty($userObj)) {
            $userObj = self::create();
        }
        return $userObj;
    }
    
    /**
     * Method will create new user
     */
    public static function create() {
        $CI         = &get_instance();
        $database   = $CI->db;
        $macAddress = User::getMacAddress();
        $data = array('mac_address' => $macAddress,
                      'ip_address'  => self::getIpAddress(),
                      'count'       => 0,
                      'day'         => Utilities::getToday(),
                      'ctime'       => time(),
                      'mtime'       => time());
        $database->insert('user', $data);
        $userID  = $database->insert_id();
        $userObj = $database->get_where('user', array('id' => $userID))->row();
        return $userObj;
    }
    /*
     * This method will use user MAC address, and check if we userd 50 shots today
     */
    public function checkUser() {
        if ($this->user->count < $this->user->shot_limit) {
            return true;
        }
        else {
            return false;
        }
    }
    
    /*
     * This function will increase user shots
     */
    public function increaseUserShot(){
        try {
            $count    = $this->user->count;
            $countNew = $count + 1;
            $this->db->where('id', $this->user->id);
            $this->db->update('user', array('count' => $countNew, 'status' => 1));
            $status = true;
        } catch (Exception $e) {
            $status = false;
        }
        return array('status' => $status);
    }
    
    /**
     * Method is called after user result request
     * and will change user shot status to 0 
     */
    public function postResult() {
        try {
            $this->db->where('id', $this->user->id);
            $this->db->update('user', array('status' => 0));
        } catch (Exception $e) {
            //do nothing
        }
    }
    
    /**
     * Method return max number of shot for user
     */
    public function getUserMaxNumberOfShots() {
        return $this->user->shot_limit;
    }
    
    /**
     * This method will returd user cookie based on todays shots
     * in case he want to delete it from browser
     */
    public function getUserCookie() {
        return $this->user->count;
    }
   
    /**
     * Method return user Mac address
     * @return type
     */
    public static function getMacAddress() {
        ob_start(); // Turn on output buffering 
        system('ipconfig /all'); //Execute external program to display output 
        $mycom = ob_get_contents(); // Capture the output into a variable 
        ob_clean(); // Clean (erase) the output buffer 

        $findme = "Physical"; 
        $pmac = strpos($mycom, $findme); // Find the position of Physical text 
        $mac  = substr($mycom,($pmac+36),17); // Get Physical Address
        return $mac;
    }
    
    /**
     * Method return user IP address
     * @return string
     */
    public static function getIpAddress() {
        // Function to get the client IP address

        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }
        else if(getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        }
        else if(getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        }
        else if(getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        }
        else if(getenv('HTTP_FORWARDED')) {
           $ipaddress = getenv('HTTP_FORWARDED');
        }
        else if(getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        }
        else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;

    }
    
}
?>

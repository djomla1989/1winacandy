<?php


class Result extends CI_Model {
    
    const MAX_NUMBER = 1298;
    public static $possitions = array(
            0, //orange
            80, //number 7 
            165, //bar
            237, //guava
            310, //banana
            378, //cherry
            454, //orange
            539, //number 7
            624, //bar
            696, //guava
            769, //banana
            837, //cherry
            913, //orange
            1000, //number 7
            1085, //bar
            1157, //guava
            1230, //banana
            1298 //cherry
    );
    
    public static $winningArray =  array(
        0   => 1, 454 => 1,  913  => 1,
        80  => 2, 539 => 2,  1000 => 2,
        165 => 3, 624 => 3,  1085 => 3,
        237 => 4, 696 => 4,  1157 => 4,
        310 => 5, 769 => 5,  1230 => 5,
        378 => 6, 837 => 6,  1298 => 6);
    
    public static function generateResults() {
        return array('a' => rand(1, self::MAX_NUMBER), 'b' => rand(1, self::MAX_NUMBER), 'c' => rand(1, self::MAX_NUMBER));
        //return array('a' => 837, 'b' => 837, 'c' => 837);
    }
    
    public static function isWinningResult($result) {
        $checkingResultArray = array();
        foreach ($result as $key => $value) {
            foreach (Result::$possitions as $positionKey => $possitionValue) {
                if ($value < $possitionValue) {
                    $checkingResultArray[$key] = $possitionValue;
                    break;
                }
            }
        }
        if (Result::$winningArray[$checkingResultArray['a']] == Result::$winningArray[$checkingResultArray['b']] && 
                Result::$winningArray[$checkingResultArray['a']] == Result::$winningArray[$checkingResultArray['c']]) {
           return true; 
        } else {
            return false;
        }
    }
    
    public static function create($result, $user) {
        $CI         = &get_instance();
        $database   = $CI->db;
        
        $today = strtotime("00:00:00");
        $data = array(
                    'user_id'     => $user->user->id,
                    'day'         => $today,
                    'result'      => json_encode($result),
                    'ctime'       => time(),
                    'mtime'       => time());
        
        $database->insert('result', $data);
    }
}

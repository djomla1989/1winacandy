<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
    
    public $canAccess = true;
    
    public function __construct() {
        parent::__construct();
        $this->userObj   = new User();
        $this->canAccess = $this->userObj->checkUser();
        $this->load->model('user');
        $this->load->helper('url');
        $this->CI = &get_instance();
        //$config = $this->config;
        //var_dump($config);
        
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
            $data['js_to_load']  = array("jquery.min.js","custom.js","jquery.spritely.js","jquery.backgroundPosition.js","slot.js","bootstrap-modal.js");
            $data['css_to_load'] = array('bootstrap.min.css','style.css');
            $data['canAccess']   = $this->canAccess;
            $data['isLocal']     = $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
            $data['today']       = strtotime("00:00:00");
            $data['userShots']   = $this->userObj->getUserCookie();
            $data['maxNumberOfShots'] = $this->userObj->getUserMaxNumberOfShots();
            $data['prices']           = Utilities::getPrices();
            //var_dump($data);exit;
            //$data['can_play']
            //here we need to check if user already userd 50 shots?      
            $this->load->library('javascript');
            $this->load->helper('url');
            $this->load->view('header', $data);
            $this->load->view('index', $data);
            $this->load->view('footer');
        
	}
    
    /**
     * Action will log user spining
     */
    public function startSpin() {
        if ($this->canAccess) {
            $status = $this->userObj->increaseUserShot();
        }
        else {
            $status = array('status' => false);
        }
        header('Content-Type: application/json');
        echo json_encode($status);
    }
    
    /**
     * Action will log user results
     * and that retust
     */
    public function getResults() {
        $result    = Result::generateResults();
        $isWinning = Result::isWinningResult($result);
        $this->userObj->postResult();
        if ($isWinning) {
            Result::create($result, $this->userObj);
        }
        header('Content-Type: application/json');
        
        //echo json_encode($result);
        echo json_encode(array('status' => $this->canAccess, 'result' => $result));
    }
    
    /**
     * Action for paying for more shots
     */
    public function pay() {
        $post   = $this->input->post();
        $prices = Utilities::getPrices();
        $payPalConfig = Utilities::getPayPalConfig();
        
        if ($post && $post['buy'] && array_key_exists($post['buy'], $prices)) {

            $item = $post['buy'];
            $this->load->library('paypal');
            $myPaypal = $this->paypal;
            
                        // Specify your paypal email
            $myPaypal->addField('business', 'djomla@hotmail.com');

            // Specify the currency
            $myPaypal->addField('currency_code', 'USD');

            // Specify the url where paypal will send the user on success/failure
            $myPaypal->addField('return', 'http://localhost/winacandy/index/notify_payment');
            $myPaypal->addField('cancel_return', 'http://localhost/winacandy/index/cancel_payment');

            // Specify the url where paypal will send the IPN
            $myPaypal->addField('notify_url', 'http://localhost/winacandy/index/notify_buy');
            // $myPaypal->addField('notify_url', 'http://www.ejahan.org/include/cron/paypalbuyproc.php');


            // Specify the product information
            $myPaypal->addField('item_name', $prices[$item]['name']);
            $myPaypal->addField('amount', $prices[$item]['price']);
            $myPaypal->addField('item_number', $prices[$item]['value']);
            
            $prepareData = array(
                    'user_id'     => $this->userObj->user->id,
                    'item_number'  => $prices[$item]['value'],
                    'price'        => $prices[$item]['price'],
                    'currency'     => 'USD',
                    'txn_bank'     => 'Paypal',
                    'user_mail'    => 'testmail@mail.com'
            );
            
            $saleID = Sale::create($prepareData);
            
            
            
            $token  = md5($this->userObj->user->id . $prices[$item]['price'] . $prices[$item]['value'] . 'Hey bro, do not change this!');
            $custom = "wc/".$this->userObj->user->id."/".$saleID."/".$prices[$item]['value']."/".time()."/$token";

            // Specify any custom value
            $time = time();
            //$myPaypal->addField('custom', $custom);

            // Enable test mode if needed
            //	$myPaypal->enableTestMode();
            // Let's start the train!
            $myPaypal->enableTestMode();
            $myPaypal->submitPayment();
        }
        else {
           //redirect(base_url());
        }

		//$this->paypal->pay(); //Proccess the payment
    }
    
    public function notify_payment() {
        $data = print_r($this->input->post(), true);
        
        echo "<pre>$data</pre>";
    }
    
    public function cancel_payment() {
        $data = print_r($this->input->post(), true);
        
        echo "<pre>$data</pre>";
    }
    
    public function notify_buy() {
        
          file_put_contents('test.txt', 'jebem');
        $data = print_r($this->input->post(), true);
        // Create an instance of the paypal library
        $this->load->library('paypal');
        $myPaypal = $this->paypal;
        // Log the IPN results
        $myPaypal->ipnLog = TRUE;
        $myPaypal->ipnLogFile = "ipn_data.txt";

        // Enable test mode if needed
    	$myPaypal->enableTestMode();
        fopen('text.txt', 'w+');
        // Check validity and write down it
        if ($myPaypal->validateIpn())
        {
            //$token  = md5($this->userObj->user->id . $prices[$item]['price'] . $prices[$item]['value'] . 'Hey bro, do not change this!');
            //$custom = "wc/".$this->userObj->user->id."/".$saleID."/".$prices[$item]['value']."/".time()."/$token";
            $ipn = $myPaypal->ipnData;
            $custom = explode('/', $ipn['custom']);
            if ($custom[0] != 'wc' || $ipn['mc_currency'] != 'USD') exit();
            $userID = $custom[1];
            $saleID = $custom[2];
            $itemID = $custom[3];
            $price = $ipn['mc_gross'];
            $token = $custom[5];
            $ttok = md5($userID . $price . $itemID . 'Hey bro, do not change this!');
            
            if ($token != $ttok) exit();
            
            $data = array(
                'ID'        => $purID,
                'user_mail' => $ipn['payer_email'],
                'tnx_id'    => $ipn['txn_id']
            );
            
            if ($ipn['payment_status'] == 'Completed') {
                Sale::finish($data);
            }
        }

            echo "<pre>$data</pre>";
    }
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */


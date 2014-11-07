<?php
/**
 * API FOR BASE SERVICE
 * @author  SunZhenghua
 * @since   2014-07-15
 * @version v1.0.0
 * 
 * $user = YbApiClient::factory('模块')->方法名('参数');
 * 
 * @example1
 * $user = YbApiClient::factory('user');
 * $user->register('', '', '', '');
 * $user->login('', '');
 * 
 * @example2
 * YbApiClient::factory('user')->login('','');
 * 
 * @example3
 * $user = YbApiClient::factory('user');
 * $user->register('', '', '', '');
 * $news = $user->setModule('news')->addWeibo(array(), array());
 *
 * 
 * 
 ***** NOTE ******************************************************************************
 *
 * -There is no need for you to download the source file from the server or svn
 * -Only changing the apiHost would suffice you.
 * -Please make sure your apiHost is corresponding to the IP which directing to API Server
 * -For the develop environment (example):
 *      10.21.3.89
 * -For the test environment (example):
 *      10.21.3.91
 * -For the online environment (example):
 *      10.21.67.60  http://sample.yiban.cn 
 *  
 *****************************************************************************************
 * 
 * 
 */

/**
 * Class YbApiClient
 * you can change the class name to meet you need
 */
class YbApiClient
{
    /**
     * apiHost Host Address
     * Corresponding to the IP address of the API Server in the HOST file
     */
    private $apiHost   = '10.21.3.89';
    
    /**
     * clientID
     * Every platform has their own clientID
     * For the development environment, default value is 'www.yiban.cn'
     */
    private $clientID  = 'yiban.cn';
    
    /**
     * clientKey
     * Corresponding to the clientID
     */
    private $clientKey = '7622f0d078cf468395336320c3cf35a1';
    
    /**
     * module 
     * Should be one of the Module in the API, @see Wiki
     */
    private $module;
    
    /**
     * clientObj
     */
    private static $clientObj;
    
    /**
     * curlObj
     */
    private static $ch;
    
    /**
     * singleton
     */
    static public function factory($module)
    {
        if (empty(self::$clientObj)) {
            self::$clientObj = new self($module);
        }
    
        return self::$clientObj;
    }
    
    /**
     * set new module
     * @param  $module  module name
     * @return YbApiClient Object
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }
    
    /**
     * magic function to get API
     */
    public function __call($func, $args)
    {
        $data = array (
                    'clientID' => $this->clientID,
                    'passwd'   => $this->clientKey,
                    'module'   => $this->module,
                    'func'     => $func,
                    'args'     => serialize($args)
                );
        
        $result = $this->curlRequest($data);

        $resultArray = json_decode($result, true);
        //you may add log here to the data before json_decode, which may help
        if (empty($resultArray)) {
            return array('status' => false, 'data' => 107);
        }

        return $resultArray;
    }
    
    /**
     * @param  $module  module name
     */
    private function __construct($module)
    {
        $this->module = $module;
        
        //add your own config file here
        //
        //$this->apiHost = '';
    }

    /**
     * curl http request
     * @param  array $data
     * @return mixed
     */
    private function curlRequest($data)
    {
        if (empty(self::$ch)) {
            self::$ch = curl_init();
        }
        curl_setopt (self::$ch, CURLOPT_URL, $this->apiHost);
        curl_setopt (self::$ch, CURLOPT_HEADER, 0);
        curl_setopt (self::$ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt (self::$ch, CURLOPT_TIMEOUT, 6);
        curl_setopt (self::$ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec(self::$ch);
        
        if (empty($result)) {
            return json_encode(array('status' => false, 'data' => 106));
        }
        
        return $result;
    }
}
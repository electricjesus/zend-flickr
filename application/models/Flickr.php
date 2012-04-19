<?php
//written by seth
class Application_Model_Flickr
{
	//defaults
	protected $_apiKey = "56e59ea738916bfd35dbd4fb07d00675";
	protected $_apiSecret = "260754cb0de2318b";
	protected $_appName = "test application";
	protected $_client = null;
	protected $_restEndpoint = "http://api.flickr.com/services/rest/";
	protected $_restMethod = "flickr.photos.getRecent";
	protected $_pageNumber = 1;
	
	
	public function __construct(array $options = null)   {
        if (is_array($options)) {
            $this->setOptions($options);
        }
		$this->setClient();
    }
	
	public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }	
	
	public function __set($name, $value)  {
        $method = 'set' . $name;
        $this->$method($value);
    }
 
    public function __get($name)     {
        $method = 'get' . $name;
        return $this->$method();
    }
	
	public function getApiKey() {
		return $this->_apiKey;
	}	
	public function getApiSecret() {
		return $this->_apiSecret;
	}
	public function getRestEndpoint() {
		return $this->_restEndpoint;
	}
	
	public function getRestMethod() {
		return $this->_restMethod;
	}
	public function setRestMethod($value) {
		$this->_restMethod = value;
		return $this;
	}
	public function getClient() {
		if(isset($this->_client))
			return $this->_client;
		else
			return $this->setClient();
	}
	public function setClient() {
		$this->_client = new Zend_Rest_Client($this->getRestEndpoint());
		return $this;
	}
	public function setPageNumber($value) {
		$this->_pageNumber = $value;
		return $this;
	}
	
	public function getPageNumber() {
		return $this->_pageNumber;
	}
	
	public function start() {	
		$client = $this->getClient();
		$client->method($this->getRestMethod());
		$client->api_key($this->getApiKey());
		$client->per_page(10);
		$client->page($this->getPageNumber());
		return $this;
	}
	public function getResponse() {
		$result = null;
		try {
			$result = $this->getClient()->get();
		} catch (Exception $e) {
			$result = array('error' => '$e->getMessage()');
		}
		return $result;
	}
}


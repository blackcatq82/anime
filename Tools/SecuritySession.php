<?php
class SecuritySession implements Tools
{
    public $title = "SecuritySession";
    public $instance;
    public $Methods;
    public $keysNeedToken = array();

    public function Base()
    {
        $this->Methods = $this->BuilderMethods();
        $array = array('instance' => $this->instance , 'Methods' =>  $this->Methods);
        return $array;
    }
    public function BuilderMethods()
    {
        $this->instance = $this;
        $methods = get_class_methods($this);
        $array = array();
        foreach($methods as $method){ $array += [$method => $method]; }
        return $array;
    }

    //register a keys to array.
    public function SetKeys()
    {
        $keys = array('index' => false);
        $this->keysNeedToken = $keys;
    }
    // search a key by name key.
    public function FoundKey($key)
    {
        try
        {
            /* set array target needed keys */
            $this->SetKeys();
            $f = array_search('index', $this->keysNeedToken);
            return $f;
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    // create a new random token.
    public function Init()
    {
        $token = $this->CreateRandomToken();
        $this->RegisterToken($token);
        return $this->SetSessionToken($token);
    }

    /* Create a random token. */
    public function CreateRandomToken()
    {
        $token  = md5(uniqid(microtime(), true));
        return $token;
    }

    // register a key token in mysql with ip address used.
    public function RegisterToken($token)
    {
        global $tools, $conn;

        $ip = $tools->tool['BaseTools']['instance']->get_ip();
        // when we found ip address we used on mysql register.
        $query = "INSERT INTO `securitysession` (`Token`, `IpAddress`) VALUES ( ? , ? )";
        $query = $conn->prepare($query);
        $query->bind_param('ss', $token, $ip);
        $query->execute();
        
        // can use information ip api.
        print_r($tools->tool['BaseTools']['instance']->ip_info($ip));
    }


    /* Check if this toekn is exists on database or not */
    public function Check($token)
    {
        global $tools, $conn;

        $ip = $tools->tool['BaseTools']['instance']->get_ip();
        // when we found ip address we used on mysql register.
        $query = "SELECT * FROM `securitysession` WHERE Token = ? AND IpAddress = ?";
        $query = $conn->prepare($query);
        $query->bind_param('ss', $token, $ip);
        $query->execute();

        $result = $query->get_result();

        return $result->num_rows != 0;
    }


    /* Set a Session token key for use in js tools. */
    public function SetSessionToken($token)
    {
        $_SESSION['SecuritySessionToken']  = $token;
        return $token;
    }

    // remove key from a database when has used.
    public function Del($token)
    {
        global $tools, $conn;
        $ip = $tools->tool['BaseTools']['instance']->get_ip();
        // when we found ip address we used on mysql register.
        $query = "DELETE FROM `securitysession` WHERE Token = ? AND IpAddress = ?";
        $query = $conn->prepare($query);
        $query->bind_param('ss', $token, $ip);
        $result = $query->execute();
    }
}

?>
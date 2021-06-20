<?php 
/// for take setting from mysqli and use on.
include_once("InterFaces.php");
class websetting implements Plugins
{
    public $title = "websetting";
    public $instance;
    public $Methods;

    public function Builder()
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

    # we are getting a values from table SELECT * FROM `navbar`
    public function navbar()
    {
        # we will using a global value connection to mysql.
        global $conn;
        # we will create a query for select table.
        $QUERY = "SELECT * FROM `CategoryItems`";
        # we will start to prepare with connection.
        $stmt = $conn->prepare($QUERY);
        # we will execute a query mysql.
        $stmt->execute();
        # we starting to while fetch assoc.
        $result = $stmt->get_result();
        # we need to adding values on array.
        $array = array();
        # now start while and add values.
        while($row = $result->fetch_assoc())
        {
            $array[] = $row;
        }
        # now we needed to return a data.
        
        return $array;
    }
}
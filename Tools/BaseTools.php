<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("interface.php");
class BasicTools implements Tools
{
    public $title = "BaseTools";
    public $instance;
    public $Methods;
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
    /**
     * we will use it fun for get count views on anime
     */
    public function GetViewCount($Title)
    {   
        global $conn; 
        
        $query = "SELECT anime.Title , animeviews.Title ,animeviews.View FROM anime JOIN animeviews WHERE anime.Title = ? AND animeviews.Title = ?";
        $query = $conn->prepare($query);
        $query->bind_param('ss',$Title,$Title);
        $query->execute();
        $result = $query->get_result();
        $count = 0;
        while($view = mysqli_fetch_array($result))
        {
            $count += $view['view'];
        }
        $count = $this->ViewsNumber($count);

        return $count;
    }
        /**
     * we will use it fun for get count views on anime
     */
    public function GetepsViewCount($id)
    {   
        global $conn; 
        
        $query = "SELECT * FROM animeviews WHERE AnimeID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = 0;
        while($view = mysqli_fetch_array($result))
        {
            $count += $view['View'];
        }
        $count = $this->ViewsNumber($count);

        return $count;
    }


    /** we use it function for get id username */
    public function GetUsernameID($UserName)
    {   
        global $conn; 
        $query = "SELECT * FROM `users` WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $UserName);
        $stmt->execute();
        
        # we needed to invoke method get_result 
        # to return a result query if he found something or nullable.
        $result = $stmt->get_result();
        
        # we needed to use fetch assoc for get row.
        $row = $result->fetch_assoc();

        if($result->num_rows <= 0)
        {
            return -1;
        }

        return $row['ID'];
    }

    /** we use it function for get id username */
    public function GetAnimeID($Title)
    {   
        global $conn; 
        
        $query = "SELECT * FROM anime WHERE Title = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $Title);
        $stmt->execute();
        
        # we needed to invoke method get_result 
        # to return a result query if he found something or nullable.
        $result = $stmt->get_result();
        
        # we needed to use fetch assoc for get row.
        $row = $result->fetch_assoc();

        if($result->num_rows <= 0)
        {
            return -1;
        }

        return $row['ID'];
    }


    /**
     * we use the function for Converter a 1000 to 1k or 1000000 to 1m.
     */
    public function ViewsNumber($number)
    {
        if ($number >= 1000 && $number <= 999999)
        {
            return number_format(($number / 1000), 1) . 'k';
        }
        elseif ($number >= 1000 && $number > 999999)
        {
            return number_format(($number / 1000000), 1) . 'M';
        }
        else
        {
            return $number;
        }
    }
    /**
     * we remove a encode html from url or dec website.
     * first we found a %20 to replace as - just for links.
     */
    public function ReplaceEncodeHtml($value)
    {
        ///use str_replace($old , $new , $value);
        $value = str_replace(" ", "-",$value);
        $value = str_replace("%20", "-",$value);
        /// we use it for links. TO : remove just links.
        return $value;
    }
    public function RemoveEncodeHtml($value)
    {
        ///use str_replace($old , $new , $value);
        $value = str_replace("-", " ",$value);
        return $value;
    }
    /**
     *  we use it func for small a bigger context from story.
     *  the func use a default size by 310 chars.
     */
    public function SmallContext($value, $size = 150)
    {
        $length = strlen($value);
        /// we checking if the string length bigger then size.
        if($length > $size)
        {
            /// we use char-lang = utf-8 for keep chars normally.
            /// dec howto use mb_substr link : https://www.php.net/manual/en/function.mb-substr.php
            /// Example : ($value , start from index = 0 , size or stop on index 150 , char encoding utf-8);
            $value  = mb_substr($value , 0 , $size , "utf-8" );
            /// we adding string afther we cut bigger string for keep user know..
            $countine = " أقراء المزيد... ";
            $value = '' . $value . '' . $countine;
        }
        /// afther we done we should return value.
        return $value;
    }
    /** relocation a next way */
    public function GoTo()
    {
        global $dir_website;
        header("Location: " . $dir_website . "index.php");
        exit;
    }
    /**
     * this fun for get count animes we have on database.
     */
    public function GetAnimeCount()
    {
        global $conn;
        if(!isset($conn))
        {
            return;
        }
        /// Get number max rows in table.
        $query = "SELECT COUNT(*) as total FROM anime";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $row = $stmt->get_result();
        $row = $row->fetch_assoc();

        $count = (int)$row['total'];
        return (int)$count;
    }
    /**
     * get ip address
     */
    function get_ip()
    {
        if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
         // Check IP from internet.
         $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
         // Check IP is passed from proxy.
         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
         // Get IP address from remote address.
         $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

       /* information ip */
       function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) 
       {
            $output = NULL;
                if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE)
                {
                    $ip = $_SERVER["REMOTE_ADDR"];
                    if ($deep_detect) {
                        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                            $ip = $_SERVER['HTTP_CLIENT_IP'];
                    }
                }
            $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
            $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
            $continents = array(
                "AF" => "Africa",
                "AN" => "Antarctica",
                "AS" => "Asia",
                "EU" => "Europe",
                "OC" => "Australia (Oceania)",
                "NA" => "North America",
                "SA" => "South America"
            );


            
                if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) 
                {
                    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip . ":80"));
                    if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                        switch ($purpose) {
                            case "location":
                                $output = array(
                                    "city"           => @$ipdat->geoplugin_city,
                                    "state"          => @$ipdat->geoplugin_regionName,
                                    "country"        => @$ipdat->geoplugin_countryName,
                                    "country_code"   => @$ipdat->geoplugin_countryCode,
                                    "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                                    "continent_code" => @$ipdat->geoplugin_continentCode
                                );
                                break;
                            case "address":
                                $address = array($ipdat->geoplugin_countryName);
                                if (@strlen($ipdat->geoplugin_regionName) >= 1)
                                    $address[] = $ipdat->geoplugin_regionName;
                                if (@strlen($ipdat->geoplugin_city) >= 1)
                                    $address[] = $ipdat->geoplugin_city;
                                $output = implode(", ", array_reverse($address));
                                break;
                            case "city":
                                $output = @$ipdat->geoplugin_city;
                                break;
                            case "state":
                                $output = @$ipdat->geoplugin_regionName;
                                break;
                            case "region":
                                $output = @$ipdat->geoplugin_regionName;
                                break;
                            case "country":
                                $output = @$ipdat->geoplugin_countryName;
                                break;
                            case "countrycode":
                                $output = @$ipdat->geoplugin_countryCode;
                                break;
                        }
                    }
                }
            return $output;
    }
}
?>
<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

/// for take setting from mysqli and use on.
include_once("interface.php");
class views implements Plugins
{
    public $title = "views";
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

    function SetView($Title)
    {
        global $conn, $tools, $plugins;
        
        # we need to found anime by idanime in eps.
        
        # Set query insert row.
        $query = "SELECT * FROM `movies` WHERE Title = ?";
        # set on conn
        $stmt = $conn->prepare($query);
        # set param values.
        $stmt->bind_param('s', $Title);
        #execute it query;
        $stmt->execute();
        # get result
        $resuls = $stmt->get_result();
        # if there row this mean we register before and can't be more then one in table.
        if($resuls->num_rows <= 0)
        {
            print_r($resuls);
            return;//don't conit
        }

        $result = $resuls->fetch_assoc();

        $IDAnime = (int)$result['IdAnime'];

        if($IDAnime == -1)
        {
            echo 'didn\'t found id anime';
            return;
        }

        $View = 1;
        $Title = (string)$Title; // just for more ex;
        $IpAddress = $tools->tool['BaseTools']['instance']->get_ip();
        $username = '';

        if(isset($_SESSION['username']))
        {
            $username = (string)$_SESSION['username'];
        }


        # we needed to check if there row same values in database.
        
        # Set query insert row.
        $query = "SELECT * FROM `animeviews` WHERE AnimeID = ? AND Title = ? AND Ipaddress = ?";
        # set on conn
        $stmt = $conn->prepare($query);
        # set param values.
        $stmt->bind_param('sss', $IDAnime, $Title, $IpAddress);
        #execute it query;
        $stmt->execute();
        # get result
        $resuls = $stmt->get_result();
        # if there row this mean we register before and can't be more then one in table.
        if($resuls->num_rows > 0)
        {
            return;//don't conit
        }
        # Set query insert row.
        $query = "INSERT INTO `animeviews`(`AnimeID`, `View`, `Title`, `username`, `Ipaddress`) VALUES (?, ?, ?, ?, ?)";
        # set on conn
        $stmt = $conn->prepare($query);
        # set param values.
        $stmt->bind_param('sssss', $IDAnime, $View, $Title, $username, $IpAddress);
        #execute it query;
        $stmt->execute();
    }


    function GetCards()
    {
        # Connection mysql.
        global $conn, $tools, $plugins, $dir_website ;
        # check if there same value adding in cards before.
        $ArrayIDs = array();

        # check if the login to username or not.
        if(!isset($_SESSION['username']))
        {
            # stopped and return with nothing happend.
            return;
        }
        # get ipaddress client.
        $IpAddress = $tools->tool['BaseTools']['instance']->get_ip();
        # Set Query Find if we got same values.
        $query = "SELECT * FROM animeviews  WHERE Ipaddress = ? AND username = ?";
        #Stmt prepare
        $stmt = $conn->prepare($query);
        #set param
        $stmt->bind_param('ss', $IpAddress, $_SESSION['username']);
        #exeute query.
        $stmt->execute();
        #get results
        $items  = $stmt->get_result();
        if($items->num_rows <= 0)
        {
            echo '<h3> لايوجد عناصر مسجلة من قبل! </h3>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            echo '<br/>';
            return;
        }
        # i didn't understand why didn't fetch all rows with function fetch-assoc
        # but we will use fetch all if we use it method that mean table mysql name will change to array number
        # exmaple ID => 1 | Title => 2
        #while fv items
        // Array ( [index] => 1 [indexrow] => باور رينجرز الموسم الثاني [2] => 270 [3] => 1 )
        // Selected ID Table ==> print_r($result->fetch_all()[0][2]);
        while($item = mysqli_fetch_array($items, MYSQLI_ASSOC))
        {
            # get id anime on row
            $IdAnime = $item['AnimeID'];

            if(!$f = array_search('' . $IdAnime . '', $ArrayIDs))
            {
                $ArrayIDs = array('' . $IdAnime . '' => $IdAnime);
            }else
            {
                continue;
            }

            /* Bigger selected query

                select distinct anime.name, animeviews.AnimeID 
                from table a, table b 
                where a.name = b.name and a.id != b.id

            */

            
            # Set Query Find if we got same values.
            $query = "SELECT * FROM `anime` WHERE ID = ?";
            #Stmt prepare
            $stmt = $conn->prepare($query);
            #set param
            $stmt->bind_param('s', $IdAnime);
            #exeute query.
            $stmt->execute();

            #get results
            $result  = $stmt->get_result();
            #while items.
            $row = $result->fetch_assoc();
            try
            {
                // reset a story with ...readmore..
                $Story = $tools->tool['BaseTools']['instance']->SmallContext($row['Story']);
                // remove chars smy from title // use method RemoveEncodeHtml
                $Name = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($row['Title']);
                // Keep a char smy from title // use method ReplaceEncodeHtml
                $Link = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($row['Title']);
                // return a count views in this main anime by Title.
                $CountViewByTitle = $tools->tool['BaseTools']['instance']->GetViewCount($row['Title']);
                // return a count views in this main anime by ID they watch live or now.
                $CountViewByID = $plugins->plugin['online_views']['instance']->GetCountView($row['ID']); 

                echo
                '
                <!--- card basic --->
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="flip-card">
                    <h4 class="card-title-anime">' . $Name . '
                    ';
                    if(isset($_SESSION['username']))
                    {
                        $fv_status = $plugins->plugin['favorite']['instance']->GetTitleAnimes($_SESSION['username'], $row['ID']);
                        echo '<a class="btn btn-mystyles my-2 my-sm-0" id="btn-profile" type="submit" onclick="SetAsfavorite(\'' . $Link . '\');"><span id="span-' . $Link . '" class="nowrap" style="font-size:8px;"><img id="' . $Link . '" src=
                        ';
                        if($fv_status)
                        {
                            echo '"themes/img/fv_yes.png"';
                            echo '
                            title="" alt="" class="icon ic_b_no_favorite"></span> </a>';
                        }
                        else
                        {
                            echo '"themes/img/fv_no.png"';
                            echo '
                            title="" alt="" class="icon ic_b_no_favorite">إضافة للمفضلة</span> </a>';
                        }
                    }

                    echo '</h4>
                        <div class="flip-card-inner">                      
                            <!--- front --->
                            <div class="flip-card-front" style="
                                                                    background: url(' . $dir_website . 'images/' . $Link . '.png);
                                                                    background-position: center;
                                                                    background-size: 200px 200px;
                                                                    height: 250px;">
                                <div class="views">
                                    <div class="this-view">
                                        <h5 style="font-size:9px;">عدد المشاهدات'. $CountViewByTitle .' 
                                            <i class="fa fa-eye" style="color:Red;"></i>
                                        </h5>
                                    </div>
                                </div>';
         
                                if($CountViewByID > 0)
                                {
                                    echo '                                <div class="views">
                                    <div class="this-view">
                                        <h5 style="font-size:9px;"> المشاهدين الان '. $CountViewByID .' 
                                            <i class="fa fa-eye" style="color:Red;"></i>
                                        </h5>
                                    </div>
                                </div>  ';
                                }

                                echo'<div class="icon">
                                    <a class="btn-watch" href="' . $dir_website . 'cartoon/' . $Link . '.html">  مشاهدة  
                                        <i class="fa fa-play" aria-hidden="true"> </i>
                                    </a>
                                </div>
                            </div>
                            <!--- back side --->
                            <div class="flip-card-back" style="background:url(' . $dir_website . 'images/' . $Link . '.png);background-position: center;background-size: 300px 300px;    height: 300px;">
                                <div class="dec">
                                    <p class="story ps"> ' . $Story . ' </p>
                                </div>
                                <div class="icon">
                                    <a class="btn-watch backside-btn" href="' . $dir_website . 'cartoon/' . $Link . '.html">  مشاهدة  
                                        <i class="fa fa-play" aria-hidden="true"> </i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- end card --->
                ';

            }
            catch(Exception $e)
            {
                //TODO: handler error.
            }
            finally
            {
                // clear something?
            }

        }
    }
}
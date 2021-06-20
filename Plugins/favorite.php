<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022
/// this for cards anime loop in index page.
include_once("interface.php");
class favorite implements Plugins
{
    public $title = "favorite";
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


    # we needed method for set a item in fv list
    # first we should check if we got item before in list.
    # مالي خلق اشرح.
    function SetAsfavorite($Title)
    {
        # Connection mysql.
        global $conn, $tools;

        #remove char from title anime
        $Title = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($Title);

        # check if the login to username or not.
        if(!isset($_SESSION['username']))
        {
            # stopped and return with nothing happend.
            return;
        }
        # use tools for get id username.
        $IDUser = $tools->tool['BaseTools']['instance']->GetUsernameID($_SESSION['username']);
        # use tools for get id anime
        $IDAnime = $tools->tool['BaseTools']['instance']->GetAnimeID($Title);
        # Set Query Find if we got same values.
        $query = "SELECT * FROM `favorite` WHERE IDUserName = ? AND IDAnime = ?";
        #Stmt prepare
        $stmt = $conn->prepare($query);
        #set param
        $stmt->bind_param('ss', $IDUser, $IDAnime);
        #exeute query.
        $stmt->execute();
        #get results
        $result  = $stmt->get_result();

        # check if there rows or not.
        # information num_rows : https://www.php.net/manual/en/mysqli-result.num-rows.php
        if($result->num_rows > 0)
        {
            # this mean the guest wanna to remove from fv list.
            # Set Query Find if we got same values.
            $query = "DELETE FROM `favorite` WHERE IDUserName = ? AND IDAnime = ?";
            #Stmt prepare
            $stmt = $conn->prepare($query);
            #set param
            $stmt->bind_param('ss', $IDUser, $IDAnime);
            #exeute query.
            $stmt->execute();
            #get results
            $result  = $stmt->get_result();
            # Ajax use it.
            echo 'remove';

            // keep return or we will add not remove.
            return;
        }

        # Now adding a new item.
        $query = "INSERT INTO `favorite`(`TitleAnime`, `IDAnime`, `IDUserName`) VALUES (? , ? , ? )";
        #Stmt prepare
        $stmt = $conn->prepare($query);
        #set param
        $stmt->bind_param('sss',$Title, $IDAnime, $IDUser);
        #exeute query.
        $stmt->execute();
        # Ajax use it.
        echo 'add';
    }



    function GetTitleAnimes($UserName, $IDAnime)
    {
        # Connection mysql.
        global $conn, $tools;
        # check if the login to username or not.
        if(!isset($_SESSION['username']))
        {
            # stopped and return with nothing happend.
            return;
        }
        # use tools for get id username.
        $IDUser = $tools->tool['BaseTools']['instance']->GetUsernameID($_SESSION['username']);

        # Set Query Find if we got same values.
        $query = "SELECT * FROM `favorite` WHERE IDUserName = ? AND IDAnime = ?";
        #Stmt prepare
        $stmt = $conn->prepare($query);
        #set param
        $stmt->bind_param('ss', $IDUser, $IDAnime);
        #exeute query.
        $stmt->execute();
        #get results
        $result  = $stmt->get_result();
        # return true if there row else return false;
        return $result->num_rows > 0 ? true : false;
    }



    function GetCards()
    {
        # Connection mysql.
        global $conn, $tools, $plugins, $dir_website ;
        # check if the login to username or not.
        if(!isset($_SESSION['username']))
        {
            # stopped and return with nothing happend.
            return;
        }
        # use tools for get id username.
        $IDUser = $tools->tool['BaseTools']['instance']->GetUsernameID($_SESSION['username']);
        # Set Query Find if we got same values.
        $query = "SELECT * FROM `favorite` WHERE IDUserName = ?";
        #Stmt prepare
        $stmt = $conn->prepare($query);
        #set param
        $stmt->bind_param('s', $IDUser);
        #exeute query.
        $stmt->execute();
        #get results
        $items  = $stmt->get_result();

        if($items->num_rows <= 0)
        {
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
            $IdAnime = $item['IDAnime'];
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

?>
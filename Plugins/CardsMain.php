<?php 
/// this for cards anime loop in index page.
include_once("InterFaces.php");
class Cards implements Plugins
{
    public $title = "Cards";
    public $instance;
    public $Methods;
    private $page_number,$page_max;
    public function Builder()
    {
         /**
         * this function a interfaces.
         * we use it function for builder
         *
         * Building Methods List */
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

    /* this func for create cards views */
    public function GetCards()
    {
        /* use a global var by mysqli and tools plugins. */
        global $conn;
        global $tools;
        global $plugins;
        global $dir_website;
        /* we get count anime on database */
        $count_anime = $tools->tool['BaseTools']['instance']->GetAnimeCount();
        $max_pages = (int)($count_anime / 15) + 1;
        /* we needed to checking if guest use number pages */ 
        /**
         * 1 - we need to check if is set $_GET['pages'].
         * 2 - if didn't use pages we will use normal query
         * 3 - else we will use number page and check if number 
         *     is exists on database by use (int)count / 15 
         *     if number equle or smaller we will use him
         *     else we will use normal query and skip number.
         * 4 - if we use number pages we needed to move number to 
         *     navgation bar pages to use as well.
         */
        if(isset($_GET['page']))
        {
            // we will use it for keep number page start from 1
            $page = (int)((int)$_GET['page'] - 1);
            if($page <= ($max_pages - 1) && $page > -1)
            {
                //we needed to use him
                //he have a exists number page.
                $page_number = $page;
            }
            else
            {
                header('location: index.php');
                exit;
            }
        }
        /* we need to use query to get first 15 rows */
        if(!isset($page_number))
        {
            $query = "SELECT * FROM anime LIMIT 0 , 15";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        else
        {
            $page_count =(int)($page_number * 15);
            $query = "SELECT * FROM anime LIMIT ? , 15";
            $stmt = $conn->prepare($query);
            $stmt->bind_param( 's' , $page_count);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        /* fetch rows and make cards while */
        if(isset($result) && $result != null)
        {
            // while all rows
            while($row = $result->fetch_assoc())
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
                        <h4 class="card-title-anime">' . $Name . '</h4>
                        <div class="flip-card-inner">                      
                            <!--- front --->
                            <div class="flip-card-front" style="
                                                                    background: url(' . $dir_website . 'images/' . $Link . '.png);
                                                                    background-position: center;
                                                                    background-size: 300px 300px;
                                                                    height: 300px;">
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
        }
        /* and we needed to building navgation bar pages */
    }
}
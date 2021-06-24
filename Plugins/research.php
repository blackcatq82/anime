<?php

# This selected items by views high to low
# SELECT Title, AnimeID, count(*) as cunt FROM animeviews GROUP by AnimeID ORDER By cunt DESC

# This selected items by views low to high.
# SELECT Title, AnimeID, count(*) as cunt FROM animeviews GROUP by AnimeID ORDER By cunt ASC

# This selected items a to z
# SELECT * FROM `anime` ORDER by Title DESC

# This selected items z to a
# SELECT * FROM `anime` ORDER by Title ASC

# This order by name
# SELECT * FROM `anime` WHERE Title = '%?%'


#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("interface.php");
class research implements Plugins
{
    public $title = "research";
    public $instance;
    public $Methods;

    public $Limited = 10;

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

    function ResetTitle($Title)
    {
        return '%' . $Title . '%';
    }


    function ResearchByTitle($Title, $page = 0)
    {
        # we needed to take a connection mysql.
        # use as global var.
        global $conn,   $tools, $plugins,   $dir_website;

        # Check the Title didn't has empty value.
        if(empty($Title))
        {
            return;
        }

        # Reset Title with %value% for more useless in mysql query
        $Title  =    $this->ResetTitle($Title);

        # we needed to check if $page has number more then 0.
        if(isset($page))
        {
            if($page > 0)
            {
                # this mean we needed to get next 10 items from page.
            }
            else
            {
                # this mean we don't want the next rows we needed first 10 rows.
                $sql = "SELECT * FROM `anime` WHERE Title LIKE ? limit 0,?";
                $stmt = $conn->prepare($sql);

                # There we will set Title with reset and Limited count rows we will founded.
                $stmt->bind_param('ss',     $Title,     $this->Limited);
                # Execute the query as well.
                $stmt->execute();

                # now we want to get result.
                $results = $stmt->get_result();

                # check if we found items
                if($results->num_rows > 0)
                {
                    # here we needed to while it's items and printed as card html code.
                                // while all rows
            while($row = $results->fetch_assoc())
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
                else
                {
                    echo 'لا يوجد عنصر بهذا الاسم يرجاء تقديم طلب عليه.';
                }
            }
        }
    }
}
?>
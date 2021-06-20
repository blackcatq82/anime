<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("InterFaces.php");
/// we building a carousel for set a rows on them 
/// the is boostrap a link exapmle : https://bootstrap.rtlcss.com/docs/4.2/components/carousel/.
/// how to use it models.
/*
echo
'
<div class="container body-blocker">
<div id="prev" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#prev" data-slide-to="0" class=""></li>
        <li data-target="#prev" data-slide-to="1" class=""></li>
        <li data-target="#prev" data-slide-to="2" class=""></li>
        <li data-target="#prev" data-slide-to="3" class=""></li>
        <li data-target="#prev" data-slide-to="4" class=""></li>
        <li data-target="#prev" data-slide-to="5" class=""></li>
        <li data-target="#prev" data-slide-to="6" class=""></li>
        <li data-target="#prev" data-slide-to="7" class=""></li>
        <li data-target="#prev" data-slide-to="8" class=""></li>
        <li data-target="#prev" data-slide-to="9" class=""></li>
        <li data-target="#prev" data-slide-to="10" class=""></li>
        <li data-target="#prev" data-slide-to="11" class=""></li>
        <li data-target="#prev" data-slide-to="12" class=""></li>
        <li data-target="#prev" data-slide-to="13" class=""></li>
        <li data-target="#prev" data-slide-to="14" class="active"></li>
    </ol>
    <div class="carousel-inner">
';
    // FOR ADD ROWS THERE.
    $animebanner = new Banner();
    if(isset($tools))
    {
        $animebanner->Running();
    }
echo '
    </div>
    <a class="carousel-control-prev" href="#prev" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#prev" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
</div>';
*/
/**
 * this class for create anime banner auto.
 */
class Banner implements Plugins
{
    public $title = "Banner";
    public $instance;
    public $Methods;
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
    /**
     * this fun for take a random anime to add on banner.
     */
    public function Running()
    {
        // we use a global for keep tools with us.
        global $conn;
        global $tools;
        $random = rand(0 , $tools->tool['BaseTools']['instance']->GetAnimeCount());
        $random = $random;
        //Mysql
        $sql = "SELECT * FROM anime LIMIT ?,15"; 
        $sql = $conn->prepare($sql);
        $sql->bind_param('s',$random);
        $sql->execute();
        $sth = $sql->get_result();
        $first_time = true;
        while($row = mysqli_fetch_array($sth))
        {
            $name = $row['name'];
            $story = $tools->tool['BaseTools']['instance']->SmallContext($row['story']);
            $links = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($row['name']);
            // if first start we should use active on class name.
            if($first_time)
            {
                                echo 
                                '
                            <div class="carousel-item active">
                            <a href="' . $links . '.html"><img src="' . $dir_website . 'images/' . $links . '.png" alt="' . $name . '"></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>' . $name . '</h5>
                                        <p>' . $story . '</p>
                                    </div>
                            </div>';
            $first_time = false;
            }
            else
            {
                            echo '
                        <div class="carousel-item">
                        <a href="' . $links . '.html"><img src="' . $dir_website . 'images/' . $links . '.png" alt="' . $name . '"></a>
                        <div class="carousel-caption d-none d-md-block">
                            <h5>' . $name . '</h5>
                            <p>' . $story . '</p>
                                </div>
                        </div>';
            }
        }
    }
}
?>
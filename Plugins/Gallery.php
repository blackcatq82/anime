<?php 
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022
/// this for cards anime loop in index page.
include_once("interface.php");
class Gallery implements Plugins
{
    public $title = "Gallery";
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
    /* use it function to get a random gallery rows */
    public function GetGallery()
    {
        /* use a global var by mysqli and tools plugins. */
        global $conn;
        global $tools;
        global $dir_website;
        /* we get count anime on database */
        $count_anime = $tools->tool['BaseTools']['instance']->GetAnimeCount();
        /* we need to use it on data base query */
        $query = "SELECT * FROM anime WHERE ID =  ? ";
        /* we will use a for to loop 15 times */
        $first = true;
		/* count rows we will use */ 
		$count_rows = 14;
        /* we will use a random id by rand function start from 1 to max count to get a random rows */
        for($index = 0 ; $index <= $count_rows; $index++)
        {
            //return a random id anime
            $random_anime = rand(1,$count_anime);
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $random_anime);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // re set story low words.
            $Story = $tools->tool['BaseTools']['instance']->SmallContext($row['Story']);
            // reset a Title without chars.
            $Title = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($row['Title']);
            // reset a Link with chars.
            $Link = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($row['Title']);
                if($first == true)
                {
                    echo '<div class="carousel-item active">'; 
                    $first = false;
                }
                else
                {
                    echo '<div class="carousel-item">'; 
                }

               echo '<a href="' . $dir_website . 'cartoon/'. $Link . '.html" alt="'. $Title . '" title="'. $Title . '">
                    <img src="' . $dir_website . 'images/' . $Link . '.png" class="d-block img-hover-zoom" alt="' . $Title . '" style="height: auto;width: auto;">
                </a>
                <div class="carousel-caption d-none d-md-block">
                <a href="' . $dir_website . 'cartoon/'. $Link . '.html" alt="'. $Title . '" title="'. $Title . '" style="color:white">
                    <h5 style="background: #279dcf;border:1px solid #000;padding:10px;">' . $Title . '</h5>
                </a>
                    <p style="background: #1e1e24;"></p></div>
            </div>';
        }
    }
}

?>
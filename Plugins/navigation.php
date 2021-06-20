<?php 
/// this for cards anime loop in index page.
include_once("InterFaces.php");
class navpages implements Plugins
{
    public $title = "navpages";
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
    /* this fun for create navigation pages bar */
    public function navigation($page)
    {
        /* use a global var by mysqli and tools plugins. */
        global $tools;
        global $dir_website;

        if(isset($page))
        {
            /* we get count anime on database */
            $count_anime = $tools->tool['BaseTools']['instance']->GetAnimeCount();
            $max_pages = (int)($count_anime / 15) + 1;
            /* we need to set max pages and page use */
            $this->page_number = $page;
            $this->page_max = $max_pages + 1;
            /* checking if is seting values */
            if(isset($this->page_number) && isset($this->page_max))
            {
                /*calculator a more pages we have afther page number */
                $limied_next = ($this->page_max - $this->page_number);
    
                /* checking if we have more then 0 */
                if($limied_next > 0)
                {
                    /* set value from page number */
                    $page = $this->page_number;
                    /* and checking if the page is not equls 0 */
                    if($page == 0)
                    {
                        $page = 1;
                    }
                    /**
                     * $count = [we use for loop index number by 5 times];
                     * $maxrows = [this max loop can use is 5 times bcuz count = 1 start from 1 to 5];
                     */
                    $count = 1;
                    $maxrows = 5;
                    /* here we checking if $page is not more then max pages */
                    /**
                     * 1 - checking $page is not bigger then max pages (max:63);
                     * 2 - checking loop count do 5 times and stop (1 <= 5);
                     * 3 - checking if $page is not equls 0 from didnt building herf page has value = '0'
                     */
                    while($page < $this->page_max && $count <= $maxrows && $page > 0)
                    {
                        /* we here checking if $page equls $_GET['page'] this mean we on same number 
                         * 1 - this for use disabled button if this same page */
                        if($page == $this->page_number)
                        {
                            /* we here checking if we can get more old 3 page from start */
                            /* exmaple : index.php?page=1
                             * if (1 - 3) > 0 == false
                             * if (3 - 3) > 0 == false
                             * if (4 - 3) > 0 == true;
                             * this we use for pages olds */
                            if(($this->page_number - 3) > 0)
                            {
                                $uses = (int)($page - 3);
                                $firstx = true;
                                while($uses < $page)
                                {
                                    if($firstx && $uses > 0)
                                    {
                                        $firstx = false;
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';                                     }
                                    else
                                    {
                                        if($uses > 0)
                                        {
                                            echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';
                                        }
                                    }
                                    $uses++;
                                }
                            }
                            /* we here checking if we can get more old 3 page from start */
                            /* exmaple : index.php?page=1
                             * if (1 - 1) > 0 == false
                             * if (2 - 1) > 0 == false
                             * if (3 - 1) > 0 == true;
                             * this we use for pages olds */
                            else if(($this->page_number - 2) > 0)
                            {
                                $uses = (int)($page - 2);
                                $firstx = true;
                                while($uses < $page)
                                {
                                    if($firstx && $uses > 0)
                                    {
                                        $firstx = false;
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';                                     }
                                    else
                                    {
                                        if($uses > 0)
                                        {
                                            echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';  
                                        }
                                    }
                                    $uses++;
                                }
                            }
                            /* we here checking if we can get more old 3 page from start */
                            /* exmaple : index.php?page=1
                             * if (1 - 1) > 0 == false
                             * if (2 - 1) > 0 == false
                             * if (3 - 1) > 0 == true;
                             * this we use for pages olds */
                            else if(($this->page_number - 1) > 0)
                            {
                                $uses = (int)($page - 1);
                                $firstx = true;
                                while($uses < $page)
                                {
                                    if($firstx && $uses > 0)
                                    {
                                        $firstx = false;
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';  
                                    }
                                    else
                                    {
                                        if($uses > 0)
                                        {
                                            echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'index.php?page=' . $uses . '" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';  
                                        }
                                    }
                                    $uses++;
                                }
                            }
                            else
                            {
                                echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                            }
                            echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">' . $page . '</a> </li>';
                        }
                        /* this mean we are on last loop we will use for
                         * add li a last row as well */
                        else if(($count) == $maxrows)
                        {
                            if(($this->page_number + 1) <= $this->page_max)
                            {
                                $uses =($this->page_number + 1);
                                echo '<li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=' . $uses . '">التالي</a></li>';
                            }
                            
                        }
                        else
                        {
                            echo '<li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=' . $page . '"> ' . $page . '</a></li>';
                        }
                        $page++;
                        $count++;
                    }
                }
    
            }
            else
            {
                echo
                '<li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">السابق</a>
              </li>
              <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=1">1</a></li>
              <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=2">2</a></li>
              <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=3">3</a></li>
              <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=4">4</a></li>
              <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=5">5</a></li>
              <li class="page-item">
                <a class="page-link" href="' . $dir_website . 'index.php?page=2">التالي</a>
              </li>';
            }
        }
        else
        {
            echo
            '<li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">السابق</a>
          </li>
          <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=1">1</a></li>
          <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=2">2</a></li>
          <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=3">3</a></li>
          <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=4">4</a></li>
          <li class="page-item"><a class="page-link" href="' . $dir_website . 'index.php?page=5">5</a></li>
          <li class="page-item">
            <a class="page-link" href="' . $dir_website . 'index.php?page=2">التالي</a>
          </li>';
        }
    }

    /* this fun for create navigation pages bar */
    public function navigation_view($page, $count_anime)
    {
        /* use a global var by mysqli and tools plugins. */
        global $tools;
        global $dir_website;
        if(isset($page))
        {
            /* we get count anime on database */
            $max_pages = ($count_anime / 10) + 1;

            /* we need to set max pages and page use */
            $this->page_number = ((int)$page);
            $this->page_max = $max_pages;
            /* checking if is seting values */
            if(isset($this->page_number) && isset($this->page_max))
            {
                /*calculator a more pages we have afther page number */
                $limied_next = ($this->page_max - $this->page_number);
                /* checking if we have more then 0 */
                if($limied_next > 0)
                {
                    /* set value from page number */
                    $page = $this->page_number;
                    /* and checking if the page is not equls 0 */
                    if($page == 0)
                    {
                        $page = 1;
                    }
                    /**
                     * $count = [we use for loop index number by 5 times];
                     * $maxrows = [this max loop can use is 5 times bcuz count = 1 start from 1 to 5];
                     */
                    $count = 1;
                    $maxrows = 5;
                    /* here we checking if $page is not more then max pages */
                    /**
                     * 1 - checking $page is not bigger then max pages (max:63);
                     * 2 - checking loop count do 5 times and stop (1 <= 5);
                     * 3 - checking if $page is not equls 0 from didnt building herf page has value = '0'
                     */
                    while($page < $this->page_max && $count <= $maxrows && $page > 0)
                    {
                        /* we here checking if $page equls $_GET['page'] this mean we on same number 
                         * 1 - this for use disabled button if this same page */
                        if($page == $this->page_number)
                        {
                            /* we here checking if we can get more old 3 page from start */
                            /* exmaple : index.php?page=1
                             * if (1 - 3) > 0 == false
                             * if (3 - 3) > 0 == false
                             * if (4 - 3) > 0 == true;
                             * this we use for pages olds */
                            if(($this->page_number - 3) > 0)
                            {
                                $uses = (int)($page - 3);
                                $firstx = true;
                                while($uses < $page)
                                {
                                    if($firstx && $uses > 0)
                                    {
                                        $firstx = false;
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';                                     }
                                    else
                                    {
                                        if($uses > 0)
                                        {
                                            echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';
                                        }
                                    }
                                    $uses++;
                                }
                            }
                            /* we here checking if we can get more old 3 page from start */
                            /* exmaple : index.php?page=1
                             * if (1 - 1) > 0 == false
                             * if (2 - 1) > 0 == false
                             * if (3 - 1) > 0 == true;
                             * this we use for pages olds */
                            else if(($this->page_number - 2) > 0)
                            {
                                $uses = (int)($page - 2);
                                $firstx = true;
                                while($uses < $page)
                                {
                                    if($firstx && $uses > 0)
                                    {
                                        $firstx = false;
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';                                     }
                                    else
                                    {
                                        if($uses > 0)
                                        {
                                            echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';  
                                        }
                                    }
                                    $uses++;
                                }
                            }
                            /* we here checking if we can get more old 3 page from start */
                            /* exmaple : index.php?page=1
                             * if (1 - 1) > 0 == false
                             * if (2 - 1) > 0 == false
                             * if (3 - 1) > 0 == true;
                             * this we use for pages olds */
                            else if(($this->page_number - 1) > 0)
                            {
                                $uses = (int)($page - 1);
                                $firstx = true;
                                while($uses < $page)
                                {
                                    if($firstx && $uses > 0)
                                    {
                                        $firstx = false;
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                                        echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';  
                                    }
                                    else
                                    {
                                        if($uses > 0)
                                        {
                                            echo '<li class="page-item"><a class="page-link"  href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html" tabindex="-1" aria-disabled="true">' . $uses . '</a> </li>';  
                                        }
                                    }
                                    $uses++;
                                }
                            }
                            else
                            {
                                echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">السابق</a> </li>';
                            }
                            echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">' . $page . '</a> </li>';
                        }
                        /* this mean we are on last loop we will use for
                         * add li a last row as well */
                        else if(($count) == $maxrows)
                        {
                            if(($this->page_number + 1) <= $this->page_max)
                            {
                                $uses =($this->page_number + 1);
                                echo '<li class="page-item"><a class="page-link" href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $uses . '.html">التالي</a></li>';
                            }
                            
                        }
                        else
                        {
                            echo '<li class="page-item"><a class="page-link" href="' . $dir_website . 'cartoon/' . $_GET['title'] . '-page-' . $page . '.html"> ' . $page . '</a></li>';
                        }
                        $page++;
                        $count++;
                    }
                }
    
            }
            else
            {
                echo
                '<li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">السابق</a>
              </li>
              <li class="page-item"><a class="page-link" href="index.php?page=1">1</a></li>
              <li class="page-item"><a class="page-link" href="index.php?page=2">2</a></li>
              <li class="page-item"><a class="page-link" href="index.php?page=3">3</a></li>
              <li class="page-item"><a class="page-link" href="index.php?page=4">4</a></li>
              <li class="page-item"><a class="page-link" href="index.php?page=5">5</a></li>
              <li class="page-item">
                <a class="page-link" href="index.php?page=2">التالي</a>
              </li>';
            }
        }
        else
        {
            echo
            '<li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">السابق</a>
          </li>
          <li class="page-item"><a class="page-link" href="index.php?page=1">1</a></li>
          <li class="page-item"><a class="page-link" href="index.php?page=2">2</a></li>
          <li class="page-item"><a class="page-link" href="index.php?page=3">3</a></li>
          <li class="page-item"><a class="page-link" href="index.php?page=4">4</a></li>
          <li class="page-item"><a class="page-link" href="index.php?page=5">5</a></li>
          <li class="page-item">
            <a class="page-link" href="index.php?page=2">التالي</a>
          </li>';
        }
    }
}
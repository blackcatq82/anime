<?php 
include_once('IncludeAll.php');
include_once('Includes/start.php');

# tag xml we use encoding utf-8 <-- has arabic chars
# and we can use windows-1256 for arabic language.
$input = '<?xml version="1.0" encoding="UTF-8" ?>';



# Debug when add a new line in string 
# i dont understand why and how to fix it sample thing....
# just wanna to say no women no cry.
#$input .= '\r\n';


# XML tag definitions
# Information about it : https://www.sitemaps.org/protocol.html
# XML tag definitions : https://www.sitemaps.org/protocol.html#xmlTagDefinitions
echo ("started to create a site map."); 

# <urlset>	required Encapsulates the file and references the current protocol standard. <~ عنصر عام.



# <url>	required Parent tag for each URL entry. <~~ أضافة عنصر معلومات عن الرابط
# The remaining tags are children of this tag.





# <loc>	required URL of the page. <~ أضافة مسار الرابط بدون بروتوكول ssl.
# This URL must begin with the protocol (such as http) and end with a trailing slash,
# if your web server requires it. This value must be less than 2,048 characters.






# <lastmod>	optional The date of last modification of the file. <~ أضافة تاريخ تحديث او وجود الصفحة او المسار.
# This date should be in W3C Datetime format.
# This format allows you to omit the time portion,
# if desired, and use YYYY-MM-DD.






# <changefreq>	optional How frequently the page is likely to change. <~ شكل التغيرات في الصفحة 
# This value provides general information to search engines and may not correlate exactly to how often they crawl the page.
# Valid values are:
#   always <~ دائم التغير
#   hourly <~ التغير بالساعة
#   daily <~ التغير باليوم
#   weekly <~ التغير بالاسبوع
#   monthly <~ التغير شهري
#   yearly <~ التغير السنوي
#   never <~ صفحة ثابت لا تتغير العناصر فيها.
# The value "always" should be used to describe documents that change each time they are accessed.
# The value "never" should be used to describe archived URLs.   
# Please note that the value of this tag is considered a hint and not a command.
# Even though search engine crawlers may consider this information when making decisions,
# they may crawl pages marked "hourly" less frequently than that,
# and they may crawl pages marked "yearly" more frequently than that.
# Crawlers may periodically crawl pages marked "never" so that they can handle unexpected changes to those pages.
# Note that this tag is separate from the If-Modified-Since (304) header the server can return,
# and search engines may use the information from both sources differently.







#<priority>	optional The priority of this URL relative to other URLs on your site. <~ تعطي المسار او الرابط قيمة للاهميته في الموقع و الطبيعي 0.5 أما الصفحة الرئيسية تاخذ القيمة كاملة وهي واحد
# Valid values range from 0.0 to 1.0. This value does not affect how your pages are compared to pages on other sites—it only lets the search engines know which pages you deem most important for the crawlers.
#The default priority of a page is 0.5.
#Please note that the priority you assign to a page is not likely to influence the position of your URLs in a search engine's result pages.
# Search engines may use this information when selecting between URLs on the same site,
# so you can use this tag to increase the likelihood that your most important pages are present in a search index.
#Also, please note that assigning a high priority to all of the URLs on your site is not likely to help you.
# Since the priority is relative, it is only used to select between URLs on your site.









# Image sitemaps نظام السيو لقوقل
# أستخدام النظام مع الصور يحسن جودة السيو في الموقع وبشكل كبير.
# Information : https://developers.google.com/search/docs/advanced/sitemaps/image-sitemaps
# عملية اضافة سهله جداً this example about how to adding a tag image in xml sitemap.


#   <url>
#   <loc> $link  </loc>
#   <image:image> <~ tag image use : becuz we import from this xmlns : xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
#     <image:loc>http://example.com/picture.jpg</image:loc> <~ use image:loc for link image.
#     <image:caption>A funny picture of a cat eating cabbage</image:caption> <~ for adding caption about image.
#     <image:geo_location>Lyon, France</image:geo_location> <~ location take the pic we didn't needed it
#     <image:title>Cat vs Cabbage</image:title> <~ Set Title Image
#     <image:license>http://example.com/image-license</image:license> <~ license we didn't needed it too.
#   </image:image> <~ close the tag
#   </url>




# We want to use videos tag too for more power sec in google research.
# how to do it?
# first we needed to add namespace in urlset 
# include package video tags from google with : xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
# we can change xmlns:video whatever to xmlns:name or something like it or keep.
# now we should take a idea about package video sitemap

# HOW TO :
# first we needed to call tag 
#                   <name:video> Or <video:video>
# same we do in example image
# 
# video:thumbnail_loc this tag for add image about it video.
#   Example:
#           <video:thumbnail_loc> http://index.com/imagevideo0.png </video:thumbnail_loc>
# video:title Tag for title video.
# video:description tag for description about it video.
# video:content_loc path mp4 or link the video should end with mp4 or types video
# video:player_loc offset when video is start.
# Example : 
#                  <video:player_loc>http://www.example.com/videoplayer.php?video=123</video:player_loc>
# <video:duration> : The duration of the video, in seconds. Value must be from 1 to 28800 (8 hours) inclusive.
# <video:expiration_date> : The date after which the video is no longer be available.
# <video:rating> : The rating of the video. Supported values are float numbers in the range 0.0 (low) to 5.0 (high), inclusive.
# <video:view_count> : The number of times the video has been viewed.
# <video:publication_date> : The date the video was first published.
# <video:family_friendly> : Whether the video is available with SafeSearch
# <video:restriction>	: Whether to show or hide your video in search results from specific countries.
# <video:platform> : Whether to show or hide your video in search results on specified platform types
# <video:tag> : An arbitrary string tag describing the video
# <video:category> : A short description of the broad category that the video belongs to

# Create a input string for keep data on srtring before build a new sitemap.xml
$input .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
$IndexOffsets = array(0 => 'index.html', 1 => 'index.php', 2 => '');
$count_pageMain = 0;
$count_cateGory = 0;
$count_anime = 0;

    echo ("create main page site base. \r\n"); 
        foreach($IndexOffsets as $key => $Offset)
        {
            $input .= '
            <url>
                <loc>' . $dir_website . $Offset .'</loc>
                <image:image>
                    <image:loc>'. $dir_website .'assets/img/blackcat.jpg</image:loc>
                    <image:caption>نقدم لكم افضل المسلسلات الكرتونية العربية مدبلجة لـ جميع الاعمار ولكن مخصصة للاطفال بدون إعلانات في الحلقات وأنتمى لكم مشاهدة طيبة..!</image:caption>
                    <image:title>' . $title_website . '</image:title>
                </image:image>
                <lastmod>' . $tomorrow  . '</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.00</priority>
            </url>';

            echo ("Add ~> [". $key ."]:" . $dir_website . $Offset . ". \r\n");  
            $count_pageMain++;
        }
        echo ("finish to adding items length:" . $count_pageMain . "\r\n"); 
        global $conn;
        
        # Add category website links.
        $sql = "SELECT * FROM `categoryitems` WHERE side = 'TOP'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        echo ("started to adding category items. \r\n"); 
        #check if there items
        if($result->num_rows > 0)
        {
            # while items with assoc
            while($cate = $result->fetch_assoc())
            {
                $input .= '
                <url>
                    <loc>' . $dir_website . $cate['href'] .'</loc>
                    <lastmod>' . $tomorrow  . '</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.50</priority>
                </url>';

                echo ("Add ~> Title:[" . $cate['title'] ."] [Link]:" . $dir_website . $cate['href'] . ". \r\n"); 
                $count_cateGory++;
            }
            echo ("finish to adding items length:" . $count_cateGory . "\r\n"); 
        }




        # Select all item in database anime.
        $sql = "SELECT * FROM `anime`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        # get items
        $results = $stmt->get_result();
        if($results->num_rows > 0)
        {
            echo ("started to adding anime items. \r\n"); 
            while($item = $results->fetch_assoc())
            {
                echo ("add anime id:[" . $count_anime ."]. \r\n"); 
                $count_anime++;
                // reset a story with ...readmore..
                // lower chars in string.
                //$Story = $tools->tool['BaseTools']['instance']->SmallContext($item['Story']);

                // larger chars unlimited.
                $Story = $item['Story'];

                // remove chars smy from title // use method RemoveEncodeHtml
                $Name = $tools->tool['BaseTools']['instance']->RemoveEncodeHtml($item['Title']);

                // Keep a char smy from title // use method ReplaceEncodeHtml
                $Link = $tools->tool['BaseTools']['instance']->ReplaceEncodeHtml($item['Title']);

                $input .= '
                <url>
                    <loc>' . $dir_website . 'cartoon/' . $Link . '.html</loc>
                    <image:image>
                        <image:loc>' . $dir_website . 'images/' . $Link . '.png</image:loc>
                        <image:caption>' . $Story . '</image:caption>
                        <image:title>' . $Name  . '</image:title>
                    </image:image>
                    <lastmod>' . $dayBuilder  . '</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>0.50</priority>
                </url>';


                # we needed to add eps while by anime id.
                $Movies = $tools->tool['BaseTools']['instance']->GetMovieByIdAnime($item['ID']);
                # foreach items movies by fetch_all array.
                foreach($Movies as $key => $item)
                {
                    $title = $item[3];
                    $input .= '
                <url>
                    <loc>' . $dir_website . 'view/' . $title . '.html</loc>
                    <image:image>
                        <image:loc>' . $dir_website . 'images/' . $Link . '.png</image:loc>
                        <image:caption>' . $Story . '</image:caption>
                        <image:title>' . $title  . '</image:title>
                    </image:image>
                    <lastmod>' . $dayBuilder  . '</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>0.50</priority>
                </url>';
                }
            }
        }
       $input .= '\r\n</urlset>';

       # we needed to del file before create a new one.
       $file_pointer = "sitemap.xml";
       if (file_exists($file_pointer))
       {
            if (!unlink($file_pointer)) 
            { 
                echo ("$file_pointer cannot be deleted due to an error"); 
            } 
            else 
            { 
                # Create a file sitemap.xml and set all data on him.
                file_put_contents("sitemap.xml", $input);
                echo ("$file_pointer has been update."); 
            }
            exit;
       }

       file_put_contents("sitemap.xml", $input);
       echo ("$file_pointer has been update."); 
?>

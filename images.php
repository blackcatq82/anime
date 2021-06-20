<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

include_once("IncludeAll.php");
include_once("Includes/start.php");
include_once("db/db.php");
$conn = new db();
$conn = $conn->Connect();
// checking if we are getting a values from get methods.
/**
 * this for find images by id without title
 * 1. we should get a number from get id methods
 * 2. we should checking if the value is int.
 * 3. we should finding on data base if we have a results by id
 * 4. if we finding a results by id we should take a name from 
 * =- the results we found and header location to images/name.png 
 * =- for use the name title as well.  
 */
if(isset($_GET['id']) && !isset($_GET['title']))
{
    // we here use (int) for take a just number without char or string.
    $id = (int)$_GET['id'];
    // we here checking if we have number bigger then 0.
	if($id > 0)
	{
        // we use data base for but the number and found 
        // the results if we have exists number by id.
	   $sql = "SELECT * FROM anime WHERE ID = ?";
	   $stmt = $conn->prepare($sql);
	   $stmt->bind_param('s',$id);
	   $stmt->execute();
	   $rows = $stmt->get_result();
	   $result = $rows->fetch_assoc();
	   $name = $result['ImagePath'];

	   header ('location: images/' . $name .'.png');
	}
}
// checking if we are getting a values from get methods.
/**
 * this for find images by title without id.
 * 1. we should get a title from get title methods
 * 2. we should checking if the value is a string.
 * 3. we should finding on data base if we have a results by title.
 * 4. if we finding a results by title we should put data images.png
 */
elseif(!isset($_GET['id']) && isset($_GET['title']))
{
    /// we are taking as string.
	$title = (string)$_GET['title'];
    /// we checking if string is empty this mean we should go home page.
    if(empty($title)){header('location:../index.php');}
    /// if we have $title not empty we will use at database for found blob image data.
	if(isset($title))
	{
        /// we use replace for checking - to space and
        /// the reasion use the from remove from url %20
        /// for a good seo page.
		$title = str_replace('-',' ', $title);
		$title = str_replace('20%',' ', $title);
		$sql = "SELECT * FROM anime WHERE Title = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s',$title);
		$stmt->execute();
		$rows = $stmt->get_result();
		$anime = $rows->fetch_assoc();
		if(isset($anime)){if(isset($anime['ImagePath'])){}else{header('location:../index.php');}}else{header('location:../index.php');}
		if($anime == null)
		{
			header('location:../index.php');
			exit;
		}

		//load a bytes from path.
		$path = $dir_website . 'Img/' . $anime['ImagePath'] . ".jpg";
		$data = file_get_contents($path,true);

        /// afhter the use header type image/png for put data image as well.
		header ('Content-Type: image/png');
		echo $data;
	}
}
else
{
    ///here we will back at home page if something a wrong use 
    /// at get methods.
	header('location:../index.php');
}
// we should close database always.
include_once("Includes/end.php");
?>
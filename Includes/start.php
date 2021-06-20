<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

ob_start();
session_start();

/* WE NEEDED TO CREATE A profile guest session. */
$Security = $tools->tool['SecuritySession']['instance'];

/* System location */
$locations = $tools->tool['Location']['instance'];

/* get key location for check if needed token or not */
$key_location = $locations->GetLocationByName();

// now we will start to found key in list.
$UsedToken = $Security->FoundKey($key_location);

if($UsedToken)
{
    if(!isset($_GET['Token']))
    {
        // we needed to reset him to main page.
        // he didnt use protcol.
        $location = $dir_website . 'index.php';
        echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
        exit;
    }
    else
    {
        # Create a new token.
        $Security->Init();

        # Check if there post token in request.
        if(isset($_GET['Token']))
        {
            $token = $_GET['Token'];

            if(empty($token))
            {
                header ('location: ' . $dir_website . '/index.php');
            }

            /* Check if this client has token register on database. */
            if(!$Security->Check($token))
            {
                $location = $dir_website . 'index.php';
                echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$location.'">';
                exit;
            }
            /* then we needed to dele the old token in data base */
            $Security->Del($token);
        }
    }
}

$plugins->plugin['online']['instance']->SetOnline();

?>
<?php
#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022
/* how to checking if connection is running... */
if(isset($conn))
{
	if($conn != null)
	{
		$conn = $conn->Close();
		$conn = null;
	}
}
ob_end_flush();
?>
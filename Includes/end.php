<?php
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
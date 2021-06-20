<?php


echo '<div id="list-gallery" class="carousel slide" data-ride="carousel" style="margin: auto;width: 30%;">
  <ol class="carousel-indicators" style="display: none;">
    <li data-target="#list-gallery" data-slide-to="0" class="active"></li>
    <li data-target="#list-gallery" data-slide-to="1"></li>
    <li data-target="#list-gallery" data-slide-to="2"></li>
    <li data-target="#list-gallery" data-slide-to="3"></li>
    <li data-target="#list-gallery" data-slide-to="4"></li>
    <li data-target="#list-gallery" data-slide-to="5"></li>
    <li data-target="#list-gallery" data-slide-to="6"></li>
    <li data-target="#list-gallery" data-slide-to="7"></li>
    <li data-target="#list-gallery" data-slide-to="8"></li>
    <li data-target="#list-gallery" data-slide-to="9"></li>
    <li data-target="#list-gallery" data-slide-to="10"></li>
    <li data-target="#list-gallery" data-slide-to="11"></li>
    <li data-target="#list-gallery" data-slide-to="12"></li>
    <li data-target="#list-gallery" data-slide-to="13"></li>
    <li data-target="#list-gallery" data-slide-to="14"></li>
  </ol>
	<div class="carousel-inner" style="padding-top: 30px;">';
	/* call fun for create a random gallery */
    $plugins->plugin['Gallery']['instance']->GetGallery();
	echo
	'</div><a class="carousel-control-next blue" href="#list-gallery" role="button"  title="السابق" data-slide="next">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">السابق</span>
	</a>
	<a class="carousel-control-prev blue" href="#list-gallery" role="button"  title="التالي" data-slide="prev">
		<span class="carousel-control-next-icon blue" aria-hidden="true"></span>
		<span class="sr-only blue">التالي</span>
    </a>
</div>';
?>
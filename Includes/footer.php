<!--- start footer --->
<div class="footer-clean">
	<footer>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-sm-4 col-md-3 item">
					<h3>وظائف الموقع</h3>
					<ul>
					<?php 

					if(isset($nav_rows))
					{
						foreach($nav_rows as $navtop)
						{
						  if($navtop['side'] == 'R')
						  {
							if(strpos($navtop['title'], '<i class') === false)
							{
								echo
								'<li><a href="' . $dir_website . ''. $navtop['href'] . '" class="Pointer" title="'. $navtop['title'] . '">'. $navtop['title'] . '</a></li>';
								}
							else
							{
								echo
								'<li><a href="' . $dir_website . ''. $navtop['href'] . '" class="Pointer">'. $navtop['title'] . '</a></li>';
							}
						  }
						}
					}
					?>
					</ul>
				</div>
				<div class="col-sm-4 col-md-3 item">
					<h3>شروط الموقع</h3>
					<ul>
					<?php 

					if(isset($nav_rows))
					{
						foreach($nav_rows as $navtop)
						{
						  if($navtop['side'] == 'M')
						  {
							if(strpos($navtop['title'], '<i class') === false)
							{
								echo
								'<li><a href="' . $dir_website . ''. $navtop['href'] . '" class="Pointer" title="'. $navtop['title'] . '">'. $navtop['title'] . '</a></li>';
								}
							else
							{
								echo
								'<li><a href="' . $dir_website . ''. $navtop['href'] . '" class="Pointer">'. $navtop['title'] . '</a></li>';
							}						  }
						}
					}
					?>
					</ul>
				</div>
				<div class="col-sm-4 col-md-3 item">
					<h3>خدمات الموقع</h3>
					<ul>
					<?php 

					if(isset($nav_rows))
					{
						foreach($nav_rows as $navtop)
						{
						  if($navtop['side'] == 'L')
						  {
							if(strpos($navtop['href'], 'onclick') === false)
							{
								echo
								'<li><a href="' . $dir_website . ''. $navtop['href'] . '" class="Pointer" title="'. $navtop['title'] . '">'. $navtop['title'] . '</a></li>';
							}
							else
							{
								echo
								'<li><a class="Pointer" title="'. $navtop['title'] . '" '. $navtop['href'] . '">'. $navtop['title'] . '</a></li>';
							}
						  }
						}
					}
					?>
					</ul>
				</div>
				<div class="col-lg-3 item social"><a href="#"><i class="icon ion-social-twitter"></i></a>
					<p class="copyright">صنع من [❤] لكم © 2020</p>
				</div>
			</div>
		</div>
	</footer>
</div>
    <script src="<?php  echo $dir_website; ?>assets/js/jquery.min.js"></script>
    <script src="<?php  echo $dir_website; ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php  echo $dir_website; ?>assets/js/script.min.js"></script>
    <script src="<?php  echo $dir_website; ?>assets/js/mysrcipt.js"></script>
	<script src="<?php  echo $dir_website; ?>assets/js/SearchMp4.js"></script>
<!--- end footer --->
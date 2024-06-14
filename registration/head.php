<head>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	 <meta http-equiv="refresh" content="1800"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">




	<!-- bootstrap 4.3.1 CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- bootstrap 4.3.1 CSS end-->

	<!-- fontawesome -->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- fontawesome end-->

	<!-- jquery CSS -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- jquery CSS end-->

	<!-- jquery 3.4.1 -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<!-- jquery 3.4.1 end-->



	<!-- fancy box CSS-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.css"/>
	<!-- fancy box CSS end-->



</head>



<?php
// define('ROOT_URI', 'http://localhost');
$today_date = date("m/d/Y");
$one_year_old_date = date("m/d/Y",strtotime('-1 years'));

?>	

<script>

</script>
<?php  

	$users_query="select * from users where id='".$_SESSION['user_id']."'";
	$mysqli_rs=sqlQuery($users_query,"select");
	$mysqli_fetch=mysqli_fetch_assoc($mysqli_rs);
	$mysqli_fetch['privilege_right'] = explode(',',$mysqli_fetch['privilege_right']);
	//echo '<pre>';print_r($mysqli_fetch['privilege_right']);echo '</pre>';
	// if($_SESSION['user_id'] <= 0 || $_SESSION['lms_flag'] !=1){ logout(); }
?>
<!-- menu Start-->
  
	<div>

		<style type="text/css">
			body {
				background: #f0f0f0;
			}
			/* custom css*/
			.dropdown_submenu.right-menu {
				left: -100% !important;
			}
			.navbar-nav .nav-item{
				border-right:1px solid #fff;
				text-align: center;
			}
			.dropright .dropdown_submenu .show {
				margin-left: -94%;
				margin-top: -20px;
			}
			.dropdown-submenu {
				position: relative;
			}
			.dropdown-submenu>a:after {
				content: "\f0da";
				float: right;
				border: none;
				font-family: 'FontAwesome';
			}

			.dropdown-submenu>.dropdown-menu {
				top: 0;
				left: 100%;
				margin-top: 0px;
				margin-left: 0px;
			}
			.dropdown_submenu.right-menu {
				left: -100%;
			}


			code {
				color: #B06AB3;
				background: #fff;
				padding: 0.1rem 0.2rem;
				border-radius: 0.2rem;
			}
			.dropdown-menu{
				left: -6px;
			}
			.logo{
				width:120px;
			}
			/*.dropdown-toggle::after{
				display: none;
			}*/

			@media (max-width: 425px) {
				.logo{
					width:120px;
				}
				.navbar-nav .nav-item{
					border-bottom: 1px solid #fff;
					border-right: 0;
					text-align: left;
				}
			}
			@media (min-width: 991px) {
			  .dropdown-menu {
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				width: 145px;
			  }
			}
			.navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
				color: black;
			}
			.dropdown-item:hover {
				color: #fff;
				text-decoration: none;
				background-color: #2a80b9;
			}
			a:hover {
				color: #000;
				text-decoration: underline;
			}

			.dropdown-item {
				display: block;
				width: 100%;
				padding: .25rem 1.5rem;
				clear: both;
				font-weight: 400;
				color: #fff !important;
				text-align: inherit;
				white-space: nowrap;
				background-color: transparent;
				border: 0;
			}
			.dropdown-menu li {
				border-bottom: 1px dotted #ddd;
			}
			.dropdown-menu li a:has(> .nav-link.dropdown-toggle){
				background: #green;
			}
			.nav_custom{
				background: #2a80b9 !important;
				border-bottom: solid 1px #fff;
				margin: 0 !important;
				padding: 0px 15px !important;
				height: 64px;
			}
			.nav-link{display: inherit;}
		</style>

		<!--Demo purpose css-->
		<style>
			.navbar {
				margin:  40px 0;
			}
		</style>

		<!--Demo purpose css-->
		<style>
			/*=-====Bootstrapthemes.co btco-hover-menu=====*/

			.navbar-light .navbar-nav .nav-link {
				color: white;
			}
			.btco-hover-menu a ,  .navbar > li > a {
				text-transform: capitalize;
				padding: 0px 0px;
			}
			.btco-hover-menu .collapse ul ul li {
			    padding: 7px 0px 7px 0px;
			    position: relative;
			}
			.btco-hover-menu .active a,
			.btco-hover-menu .active a:focus,
			.btco-hover-menu .active a:hover,
			.btco-hover-menu li a:hover,
			.btco-hover-menu li a:focus ,
			.navbar>.show>a,  .navbar>.show>a:focus,  .navbar>.show>a:hover{
				color: #000;
				background: transparent;
				outline: 0;
			}

			/*submenu style start from here*/
			.dropdown-menu {
				padding: 0px 0; 
				margin: 0 0 0; 
				border: 0px solid transition !important;
				border: 0px solid rgba(0,0,0,.15);  
				border-radius: 0px;
				-webkit-box-shadow: none !important;
				box-shadow: none !important;

			}
			/*first level*/
			.btco-hover-menu .collapse ul > li:hover > a{background: #fff;color: #000;}
			.btco-hover-menu .collapse ul ul > li:hover > a, .navbar .show .dropdown-menu > li > a:focus, .navbar .show .dropdown-menu > li > a:hover{background: #2a80b9;}
			/*second level*/
			.btco-hover-menu .collapse ul ul ul > li:hover > a{background: #fff;}

			/*third level*/
			.btco-hover-menu .collapse ul ul, .btco-hover-menu .collapse ul ul.dropdown-menu{background: #2a80b9;}
			.btco-hover-menu .collapse ul ul ul, .btco-hover-menu .collapse ul ul ul.dropdown-menu{background:#f5f5f5}
			.btco-hover-menu .collapse ul ul ul ul, .btco-hover-menu .collapse ul ul ul ul.dropdown-menu{background:#f5f5f5}

			/*Drop-down menu work on hover*/
			/*.btco-hover-menu{background: none;margin: 0;padding: 0;min-height:20px}*/

			@media only screen and (max-width: 991px) {
				.btco-hover-menu .show > .dropdown-toggle::after{
					transform: rotate(-90deg);
				}
				.nav_custom{
					height: auto;
				}
			}
			@media only screen and (min-width: 991px) {

				.btco-hover-menu .collapse ul li{position:relative;}
				.btco-hover-menu .collapse ul li:hover> ul{display:block}
				.btco-hover-menu .collapse ul ul{position:absolute;top:101%;left:0;min-width:154px;display:none}
				/*******/
				.btco-hover-menu .collapse ul ul li{position:relative}
				.btco-hover-menu .collapse ul ul li:hover> ul{display:block}
				.btco-hover-menu .collapse ul ul ul{position:absolute;top:0;left:100%;min-width:154px;display:none}
				/*******/
				.btco-hover-menu .collapse ul ul ul li{position:relative}
				.btco-hover-menu .collapse ul ul ul li:hover ul{display:block}
				.btco-hover-menu .collapse ul ul ul ul{position:absolute;top:0;left:-100%;min-width:154px;display:none;z-index:1}

			}
			
			.jumbotron{background-color: #1f1f1f;color: #fff;}



		</style>

		<!-- Static navbar -->
		<nav class="navbar navbar-expand-md navbar-light bg-light btco-hover-menu nav_custom">
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<?php
				if(isset($_SESSION['user_id'])){ 
				?>
					<ul class="navbar-nav">
						<!-- <li class="nav-item">
							<a class="nav-link" href="#">Pricing</a>
						</li> -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle  mine_a" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 8px;">
								<i class="fa fa-user-circle-o " aria-hidden="true" ></i><br>Welcome <?php $user_name = explode(" ", $_SESSION['user_name']); echo $user_name[0]; ?>
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							
								
								<li>
									<a href="dashboard.php" ><button type="submit" class="dropdown-item"><i class="fa fa-info" aria-hidden="true"></i> Dashboard</button></a>
									
								</li>
								<li>
									<a href="mysettings.php" ><button type="submit" class="dropdown-item"><i class="fa fa-cog" aria-hidden="true"></i> Settings</button></a>
									
								</li>
	
								<li>
									<a href="logout.php" ><button type="submit" class="dropdown-item"><i class="fa fa-power-off" aria-hidden="true" style="color:red;"></i> Logout </button></a>
								</li>

							</ul>
						</li>

			</div>
		</nav>

		<script type="text/javascript">
			
			/*!
			 * Bootstrap 4 multi dropdown navbar ( https://bootstrapthemes.co/demo/resource/bootstrap-4-multi-dropdown-navbar/ )
			 * Copyright 2017.
			 * Licensed under the GPL license
			 */


			$( document ).ready( function () {
				$( '.dropdown-menu a.dropdown-toggle' ).on( 'click', function ( e ) {
					var $el = $( this );
					var $parent = $( this ).offsetParent( ".dropdown-menu" );
					if ( !$( this ).next().hasClass( 'show' ) ) {
						$( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
					}
					var $subMenu = $( this ).next( ".dropdown-menu" );
					$subMenu.toggleClass( 'show' );
					
					$( this ).parent( "li" ).toggleClass( 'show' );

					$( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function ( e ) {
						$( '.dropdown-menu .show' ).removeClass( "show" );
					} );
					
					 if ( !$parent.parent().hasClass( 'navbar-nav' ) ) {
						$el.next().css( { "top": $el[0].offsetTop, "left": $parent.outerWidth() - 4 } );
					}

					return false;
				} );
			} );
		</script>

		<!-- old nav -->
		
	</div>
		<?php 
		} 
		?>



<script>
    $(document).ready(function(){
       $('#end-this-break').click(function(){
        user_id='<?= $_SESSION['user_id'] ?>';
        $.ajax({
            type:'POST',
            dataType:'json',
            data:{user_id:user_id,action:'end break'},
            url:'<?= $break_release_url ?>',
            success:function(response){
                if(response.code==1){
                    location.reload();
                }
            }
            });
        }); 
    });
</script>
 <script type="text/javascript">
 	function show_popup(){
 		$("body").css('overflow','hidden');
 		$("#page_loader").show();
 	}
	
	function hide_popup(){
		$("#page_loader").hide();
		$("body").css('overflow','auto');
	}

</script> 

<script>    
	    show_popup();
	    $(window).on('load', function(){
	    	//alert('on load');
	        hide_popup();
	    });
	</script>  


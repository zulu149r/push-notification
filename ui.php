<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<style>
			/*
			* Style tweaks
			* --------------------------------------------------
			*/
			html,
			body {
				overflow-x: hidden; /* Prevent scroll on narrow devices */
			}
			body {
				padding-top: 100px;
			}
			footer {
				padding: 30px 0;
			}

			/*
			 * Custom styles
			 */
			.navbar-brand {
				font-size: 24px;
			}

			.navbar-container {
				padding: 20px 0 20px 0;
			}

			.navbar.navbar-fixed-top.fixed-theme {
				background-color: #222;
				border-color: #080808;
				box-shadow: 0 0 5px rgba(0,0,0,.8);
			}

			.navbar-brand.fixed-theme {
				font-size: 18px;
			}

			.navbar-container.fixed-theme {
				padding: 0;
			}

			.navbar-brand.fixed-theme,
			.navbar-container.fixed-theme,
			.navbar.navbar-fixed-top.fixed-theme,
			.navbar-brand,
			.navbar-container{
				transition: 0.8s;
				-webkit-transition:  0.8s;
			}
		</style>
		<script>
			$(document).ready(function(){
			/**
			 * This object controls the nav bar. Implement the add and remove
			 * action over the elements of the nav bar that we want to change.
			 *
			 * @type {{flagAdd: boolean, elements: string[], add: Function, remove: Function}}
			 */
			var myNavBar = {

				flagAdd: true,

				elements: [],

				init: function (elements) {
					this.elements = elements;
				},

				add : function() {
					if(this.flagAdd) {
						for(var i=0; i < this.elements.length; i++) {
							document.getElementById(this.elements[i]).className += " fixed-theme";
						}
						this.flagAdd = false;
					}
				},

				remove: function() {
					for(var i=0; i < this.elements.length; i++) {
						document.getElementById(this.elements[i]).className =
								document.getElementById(this.elements[i]).className.replace( /(?:^|\s)fixed-theme(?!\S)/g , '' );
					}
					this.flagAdd = true;
				}

			};

			/**
			 * Init the object. Pass the object the array of elements
			 * that we want to change when the scroll goes down
			 */
			myNavBar.init(  [
				"header",
				"header-container",
				"brand"
			]);

			/**
			 * Function that manage the direction
			 * of the scroll
			 */
			function offSetManager(){

				var yOffset = 0;
				var currYOffSet = window.pageYOffset;

				if(yOffset < currYOffSet) {
					myNavBar.add();
				}
				else if(currYOffSet == yOffset){
					myNavBar.remove();
				}

			}

			/**
			 * bind to the document scroll detection
			 */
			window.onscroll = function(e) {
				offSetManager();
			}

			/**
			 * We have to do a first detectation of offset because the page
			 * could be load with scroll down set.
			 */
			offSetManager();
			});
		</script>
	</head>
	<body>
		<nav style="background-color:white;" id="header" class="navbar navbar-fixed-top">
            <div id="header-container" class="container navbar-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="brand" class="navbar-brand" href="#">Push Sender</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->

        <div class="container">

            <div class="row row-offcanvas row-offcanvas-right">

                <div class="col-xs-12 col-sm-9">
                    <p class="pull-right visible-xs">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                    </p>
                    <div class="jumbotron">
                        <h3>Fill up the required correctly</h3>
                        <form action="sendingprocess.php" method="POST" name="pushSender" enctype="multipart/form-data" class="form-group">
							<div style="margin:0 auto;">
								<label for="message">Message:</label>
								<textarea class="form-control" name="message" rows="3" id="message"></textarea>
							</div>
							<br />
							<div style="margin:0 auto; text-align:center;" class="input-group">
								<h5>Select the organizations</h5>
								<select style="margin:0 auto; width:250px;" name="orgID" multiple size="3" class="form-control input-sm dropdown">
									<option name="orgIDofNexval">Nexval</option>
									<option name="orgIDofCN">Calcutta News</option>
									<option name="orgIDofCTVN">CTVN</option>
									<option name="orgIDofDropKaffe">DropKaffe</option>
									<option name="orgIDofDropKaffe">Wipro</option>
									<option name="orgIDofDropKaffe">TCS</option>
									<option name="orgIDofDropKaffe">CTS</option>
									<option name="orgIDofDropKaffe">Capgemini</option>
								</select>
							</div>
							<br />
							<div style="margin:0 auto;" class="input-group">
								<span>
									Please select desired platform:-
								</span>
								<input type="radio" style="margin-left:10px;" name="platform" value="both" /><span> Both</span>
								<input type="radio" style="margin-left:10px;" name="platform" value="ios" /><span> iOS</span> 
								<input type="radio" style="margin-left:10px;" name="platform" value="android" /><span> Android</span> 
							</div>
							<br />
							<div style="margin:0 auto;" class="input-group">
								<button style="margin:0 auto; border:none; background:transparent;" type="submit" class="form-control" name="submit" value="Send Push"><i class="glyphicon glyphicon-send"></i> Send Push</button>
							</div>
						</form>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-lg-4">
                            <h2>Heading</h2>
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                        </div><!--/.col-xs-6.col-lg-4-->
                        <div class="col-xs-6 col-lg-4">
                            <h2>Heading</h2>
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                        </div><!--/.col-xs-6.col-lg-4-->
                        <div class="col-xs-6 col-lg-4">
                            <h2>Heading</h2>
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                        </div><!--/.col-xs-6.col-lg-4-->
                        <div class="col-xs-6 col-lg-4">
                            <h2>Heading</h2>
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                        </div><!--/.col-xs-6.col-lg-4-->
                        <div class="col-xs-6 col-lg-4">
                            <h2>Heading</h2>
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                        </div><!--/.col-xs-6.col-lg-4-->
                        <div class="col-xs-6 col-lg-4">
                            <h2>Heading</h2>
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                            <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                        </div><!--/.col-xs-6.col-lg-4-->
                    </div><!--/row-->
                </div><!--/.col-xs-12.col-sm-9-->

                <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
					    <a href="https://firebase.google.com/docs/cloud-messaging/?gclid=EAIaIQobChMI29KskaWT2QIVTIyPCh1Bdw3DEAAYASAAEgL0mvD_BwE" class="list-group-item active">Read about fcm and apn</a>
                        <a href="www.pushtry.com" class="list-group-item">pushtry</a>
                        <a href="www.apns-gcm.bryantan.info" class="list-group-item">apns-gcm.bryantan</a>
                        <a href="https://pushover.net/" class="list-group-item">pushover</a>
                        <a href="www.pushwatch.com/gcm" class="list-group-item">pushwatch</a>
                        <a href="www.testpush.com" class="list-group-item">testpush</a>
                        <a href="https://techstricks.com/test-gcm-and-apns-push-notifications-online" class="list-group-item">techstricks</a>
                        <a href="www.catapush.com" class="list-group-item">catapush</a>
                        <a href="https://onesignal.com/" class="list-group-item">onesignal.com</a>
                        <a href="https://pusher.com/push-notifications" class="list-group-item">Pusher.com</a>
                    </div>
                </div><!--/.sidebar-offcanvas-->
            </div><!--/row-->

            <hr>

            <footer>
                <p>© Nexval Info Tech Pvt Ltd(2018)</p>
            </footer>

        </div><!--/.container-->
 	</body>
</html>
<?php 
	$baseurl = '';
	$baseurl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
	$baseurl .= '://'. $_SERVER['HTTP_HOST'];
	$baseurl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	
	
	$path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
	
	
	$uri = $_SERVER['REQUEST_URI'];
	
	$uris = explode('/', $uri);
	
	$peekobjectid = $uris[count($uris) - 1];
?>
<!DOCTYPE html>

<html>
	<head>
	    <meta charset="utf-8">
	    <title>Peek</title>
	    <link rel="shortcut icon" type="image/png" href="<?php echo $baseurl?>images/favicon.ico" sizes="128x128">
	    
	    <script src="<?php echo $baseurl?>js/jquery-1.9.0.min.js" type="text/javascript"></script>
	    <script type="text/javascript" src="http://www.parsecdn.com/js/parse-1.3.0.min.js"></script>
	    <script type="text/javascript" src="<?php echo $baseurl?>js/jquery.skippr.min.js"></script>
	    
	    <link rel="stylesheet" media="screen" href="<?php echo $baseurl?>css/main.css">
	    <link rel="stylesheet" href="<?php echo $baseurl?>css/jquery.skippr.css">
	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	    <meta name="application-name" content="Peek" />
	    <script>
	    	$(function(){


		    	Parse.initialize("mROa1ftBr3FVjvSArtMWGuH8U5bIIxAtHViFW5xI"
	    	    	    , "Cd27LX80RKmCA2owGw0PClQpprEpY9s1L9bgTZTG");
	    	    
	    	    var PeekObject = Parse.Object.extend("Peek");
	    	    var query = new Parse.Query(PeekObject);
	    	    query.equalTo("objectId", "<?php echo $peekobjectid?>");
	    	    query.find({
	    	      success: function(results) {

		    	      if(results.length == 0)
			    	      return;
		    	      
		    	      var photo1 = results[0].get('photo1');
		    	      var photo2 = results[0].get('photo2');

		    	      var caption = results[0].get('caption');
		    	      var lower_caption = results[0].get('lower_caption');

					  var createdAt = results[0].createdAt;
		    	      var startTime = new Date();
		    	      var elapsed = (startTime.getTime() - createdAt.getTime()) / 1000; 

		    	      var created = '';
			    	  if(elapsed < 60)
			    	  {
				    	  // second
			    		  created = 'Just now';
				    	  
			    	  } else if( elapsed >= 60 && elapsed < 3600 )
			    	  {
				    	  // minutes

			    		  created = Math.round(elapsed / 60) + ' min ago';
			    		  
			    	  } else if ( elapsed >= 3600 && elapsed < 24*3600 )
			    	  {
				    	  // hours

			    		  created = Math.round(elapsed / 3600) + ' hours ago';
			    		  
			    	  } else {
				    	  // day

			    		  created = Math.round(elapsed / (24*3600)) + ' days ago';
			    	  }
		    	      		    	      
		    	      $('.bubble-caption').text(caption);
		    	      $('#posted').text(created);

		    	      $('.peekcaption').show();

		    	      // show image
		    	      
		    	      $photodiv = $('<img />');

		    	      $photodiv.attr('src', photo1.url());
		    	       
		    	      $("#random").append($photodiv);


		    	      $photodiv = $('<img />');

		    	      $photodiv.attr('src', photo2.url());
		    	      $photodiv.addClass('overlay');
		    	       
		    	      $("#random").append($photodiv);


		    	      $('#random img:eq(0)').mousedown(function() {
		    	    	  $('.peekhand').removeClass('blink');
		    	    	  $(this).fadeOut(300);
		    	    		$('#random img:eq(1)').fadeIn(1000);
		    	   	  });
				
		    	      $('#random img:eq(1)').mouseup(function() {
				        	$(this).fadeOut(1000);
				        	$('#random img:eq(0)').fadeIn(1000, function(){
				        		$('.peekhand').addClass('blink');
					        });
				        	
    		        	});


		    	      
		    	     $('.peekhand').addClass('blink');
			    	 
				        
		    	      //$("#random").skippr();


		    	     // get full name from user id

		    	      var UserObject = Parse.Object.extend("User");
			    	  var userquery = new Parse.Query(UserObject);
			    	  userquery.equalTo("objectId", results[0].get('user_id'));
			    	  userquery.find({
			    	      success: function(results1) {
				    	      if(results1.length == 0)
					    	      return;

				    	      $('.username').text(results1[0].get('fullname'));


				    	      $('.container').fadeIn();
			    	      },
			    	      error: function(error) {

			    	      }
			    	    });
	    	      },
	    	      error: function(error) {
	    	        alert("Error: " + error.code + " " + error.message);
	    	      }
	    	    });
		   	});
	    </script>
	    
	    <style type="text/css">
	    
	    #peekplayer img {
	    	width: 360px;
	    }
	    </style>
	    
	    <script type="text/javascript">
		    

 		</script>
		<style type="text/css">
		<!--
		   .hoverbox { position: relative; }
		   .main { width: 243px; height: 117px; }
		   .overlay { position: absolute; top: 0; left: 0; display: none; }
		-->
		</style>
		
    </head>
<body>
<div class="all">
    <header>
        <div style="position: relative;">
        	<div>
        		<a href="http://peek.com"><img class="head-logo" src="<?php echo $baseurl?>images/peek-logo.png"/></a>	
        	</div>
            
			<div id="action-bar" class="clearfix" style="position: absolute; top: 21px; right: 1px;">
			
				<a href="https://itunes.apple.com/us/app/peek-curiously-creative/id910377405?mt=8" target="itunes_store">
                	<img class="download-badge" src="<?php echo $baseurl?>images/download-button.png"/>
                </a>
                
            </div>
            <div class="sub-title">Two photos. One hidden. <span style="text-decoration: underline;">Click</span> to reveal the story.</div>
        </div>
        
    </header>

    <div id="peeksection">
        <div class="container">
            <div id="peekplayer">
            	<div id="random" class="hoverbox"></div>
            	<div id="peekhand" class="peekhand"></div>
            	<div class="peekbottom-logo"></div>
            </div>
            <div class="peekhead clearfix">
                <div class="user-meta clearfix">
                    <div class="user-profile-image left-col"></div>
                    <div class="right-col">
                        <div class="username"></div>
                        <div id="posted" class="time"></div>
                    </div>
                </div>
                <div class="peekcaption clearfix" style="display:none">
                    <div class="bubble-caption">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="description" content="Demonstrates some basic HTML form elements" />
  <meta name="keywords" content="HTML, CSS, tags, PHP" />
  <meta name="author" content="A Referral"  />
  <title>Refer</title>
 <link href="style/description.css" rel="stylesheet"/>
 <link href="style/style.css" rel="stylesheet"/>
 <link href="style/refer.css" rel="stylesheet"/>
 
</head>
<body>
    <?php include("header.inc"); ?>
<hr>
<h1 id="r0">Refer a Friend<a class="image1" href="jobs.php" title="Return"><img src="images/images-removebg-preview.png" alt="Return arrow"/></a></h1>
	<p id="r1">Happen to know a friend who fit the criteria?</p>
	<p id="r2">Fill out the form and earn your keep!</p>
<form method="post" action="http://mercury.swin.edu.au/it000000/formtest.php">
<div class="form">
	<fieldset>
		<legend>Your details</legend>
		<p><label for="refername">Full Name</label> 
			<input id="refername" type="text" name= "refername" class="studentid" maxlength="20" size="10" required="required"/>
		</p>
		<br><label for="referemail">Your Email</label> 
			<input id= "referemail" type="email" name= "referemail" class="givenname" maxlength="20" size="10" required="required"/>
		
		

		
		<label class="phone" for="referphone">Your Phone Number</label>
		<select id="referphone" class="countrycode" name="countrycode">
				
			<option value="+84 vn">+84</option>			
			<option value="+1 usa">+1</option>
			<option value="+61 au">+61</option>
			<option value="+65 sg">+65</option>

		</select>
		<input type="tel" name="referphone" pattern="[0-9]{10}">
	
	
	</fieldset>
	<fieldset>
		<legend>Your Friend details</legend>
		<p id="r4">Note: Make sure your friend fits the minimum requirements and is consulted about this. Refer to our policy.</p>
		<br><label for="friendname">Full Name</label> 
			<input id="friendname" type="text" name= "friendname" class="studentid" maxlength="20" size="10" required="required"/>
	
		<br><label for="friendemail">Their Email</label> 
			<input  id="friendemail" type="email" name= "friendemail" class="givenname" maxlength="20" size="10" required="required"/>
		
		

		
		<label class="phone" for="friendphone">Their Phone Number</label>
		<select id="friendphone" class="countrycode" name="countrycode">
				
			<option value="+84 vn">+84</option>			
			<option value="+1 usa">+1</option>
			<option value="+61 au">+61</option>
			<option value="+65 sg">+65</option>

		</select>
		<input  type="tel" name="friendphone" pattern="[0-9]{10}">
	

		
	</fieldset>
			
	
	 <div class="re">
	<input  type= "submit" value="Refer"/>
	<input  type= "reset" value="Reset Form"/>
	</div> 
</div>		
</form>
<?php include("footer.inc"); ?>


</body>
</html>
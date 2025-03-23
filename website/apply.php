<!DOCTYPE HTML>
<HTML lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="creating Web Applications">
	<meta name="keywords" content="HTML, CSS, Javascript">
	<meta name="author" content="Minh">
	<link href="style/style.css" rel="stylesheet">
	<link href="style/apply.css" rel="stylesheet">
	<title>Job Applications</title>
</head>

<body>
	<?php include("header.inc") ?>
	
	<section class="apply">
		<h1>Job Application</h1>
		<form action="process_eoi.php" method="POST">
			<table>
				<tr>
					<td class="title"><label for="job_mun">Job reference number:</label></td>
					<td class="inputarea"><input type="text" name="job_num" id="job_mun" pattern="[A-Z0-9]{5}" required="required"></td>
				</tr>
				<tr>
					<td class="title"><label for="fname">First name:</label></td>
					<td class="inputarea"><input type="text" name="fname" id="fname" pattern="[a-zA-z]{2,20}" required="required"></td>
				</tr>
				<tr>
					<td class="title"><label for="lname">Last name:</label></td>
					<td class="inputarea"><input type="text" name="lname" id="lname" pattern="[a-zA-z]{2,20}" required="required"></td>
				</tr>
			</table>
			
			<fieldset>
				<legend>Gender</legend>
				<div>
					<input type="radio" name="gender" id="male" value="male">
					<label for="male">Male</label>
				</div>
				<div>
					<input type="radio" name="gender" id="female" value="female">
					<label for="female">Female</label>
				</div>
				<div>
					<input type="radio" name="gender" id="other" value="other">
					<label for="other">Other</label>
				</div>
			</fieldset>
			<br>
			
			<table>
				<tr>
					<td class="title"><label for="dob">Date of birth:</label></td>
					<td class="inputarea"><input type="text" name="dob" id="dob" pattern="\d{2}/\d{2}/\d{4}" required="required" placeholder="dd/mm/yyyy"></td>
				</tr>
				<tr>
					<td class="title"><label for="str_address">Street address:</label></td>
					<td class="inputarea"><input type="text" name="str_address" id="str_address" pattern="[a-zA-Z0-9,]{1,40}" required="required"></td>
				</tr>
				<tr>
					<td class="title"><label for="town">Suburb/Town:</label></td>
					<td class="inputarea">
						<div class="townname">
						<input type="text" name="town" id="town" pattern="[a-zA-Z0-9,]{1,40}" class="townname_input" required="required">
						<select class="state_select" name="state">
							<option value="" disabled selected hidden>State</option>
							<option value="VIC">VIC</option>
							<option value="NSW">NSW</option>
							<option value="QLD">QLD</option>
							<option value="NT">NT</option>
							<option value="WA">WA</option>
							<option value="SA">SA</option>
							<option value="TAS">TAS</option>
							<option value="ACT">ACT</option>
						</select>
						</div>
					</td>
				</tr>
				<tr>
					<td class="title"><label for="postcode">Postcode:</label></td>
					<td class="inputarea"><input type="text" name="postcode" id="postcode" pattern="\d{4}" required="required" placeholder="xxxx"></td>
				</tr>
				<tr>
					<td class="title"><label for="email">Email:</label></td>
					<td class="inputarea"><input type="text" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" required="required"></td>
				</tr>
				<tr>
					<td class="title"><label for="phone">Phone number:</label></td>
					<td class="inputarea"><input type="text" name="phone" id="phone" pattern=[\d\s]{8,12} required="required"></td>
				</tr>
			</table>

			<div class="skill">
				<Label class="skill_label">Skill:</Label>

				<div class="skill1">
					<div>
						<input type="checkbox" name="skill[]" id="html" value="html">
						<label for="html">HTML</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="css" value="css">
						<label for="css">CSS</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="ui/ux" value="ui/ux">
						<label for="ui/ux">UI/UX design</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="js" value="js">
						<label for="js">Javascript</label>
					</div>
				</div>

				<div class="skill2">
					<div>
						<input type="checkbox" name="skill[]" id="php" value="php">
						<label for="php">PHP</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="sql" value="sql">
						<label for="sql">SQL</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="python" value="python">
						<label for="python">Python</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="c/c++" value="c/c++">
						<label for="c/c++">C/C++</label>
					</div>
				</div>

				<div class="skill3">
					<div>
						<input type="checkbox" name="skill[]" id="java" value="java">
						<label for="java">Java</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="statistic" value="statistic">
						<label for="statistic">Statistic</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="cybersecurity" value="cybersecurity">
						<label for="cybersecurity">Cyber security</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="otherskill" value="otherskill">
						<label for="otherskill">Other</label>
					</div>
				</div>
			</div>
				
			<div>
			<label for="otherdes">Other skill:</label><br>
			<textarea name="otherdes" id="otherdes" placeholder="What skill do you have?"></textarea>
			</div>

			<div class="button-group">
				<input class="button" type="submit" value="Submit">
				<input class="button" type="reset" value="Reset">
			</div>
		</form>
	</section>

	<?php include("footer.inc")?>
</body>
</HTML>
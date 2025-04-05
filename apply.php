<?php
session_start();
 // PHP 5.4 
if ($_SERVER["REQUEST_METHOD"] === "GET" && !isset($_SESSION['from_process']) && !isset($_SESSION['from_jobs1'])) {
    unset($_SESSION['errors']);
    unset($_SESSION['input_data']);
	unset($_SESSION['job_ref_num']);
} 

unset($_SESSION['from_process']);
#echo "<pre>";
#print_r($_SESSION);
#echo "</pre>";
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$input_data = isset($_SESSION['input_data']) ? $_SESSION['input_data'] : [];
?>
<!DOCTYPE HTML>
<HTML lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="creating Web Applications">
	<meta name="keywords" content="HTML, CSS, Javascript">
	<meta name="author" content="Minh hai edited">
	<link href="style/style.css" rel="stylesheet">
	<link href="style/apply.css?ver=2" rel="stylesheet">
	<title>Job Applications</title>
</head>




<body>
    <?php include("header.inc") ?>

    <section class="apply">
        <h1>Job Application</h1>
		<?php
			if (isset($errors) && !empty($errors)) {
				echo '<div class="error-box">';
				echo "<h2 class='error-h2'>We have detected some errors in your form!</h2>";
				foreach ($errors as $error) {
					echo "<p class='error-msg'>$error</p>";
				}
				echo '</div>';
				unset($errors); // Clear errors after displaying
			}
		?>
        <form action="process_eoi.php" method="POST" novalidate>
		
            <table>
                <tr>
                    <td class="title"><label for="job_mun">Job reference number:</label></td>
                    <td class="inputarea"><input type="text" name="job_num" id="job_mun" pattern="[A-Z0-9]{5}" required="required" placeholder="Please enter Job Reference number. E.g: AB123"
                    value="<?php echo htmlspecialchars(
						isset($input_data['jobnum']) ? $input_data['jobnum'] : 
						(isset($_SESSION['from_jobs1']) && isset($_SESSION['job_ref_num']) ? $_SESSION['job_ref_num'] : '')
						); ?>"></td>
                </tr>
                <tr>
                    <td class="title"><label for="fname">First name:</label></td>
                    <td class="inputarea"><input type="text" name="fname" id="fname" pattern="[a-zA-Z]{2,20}" required="required" placeholder="Please enter your First name (2-20 alpha characters)"
                    value="<?php echo htmlspecialchars(isset($input_data['fname']) ? $input_data['fname'] : ''); ?>"></td>
                </tr>
                <tr>
                    <td class="title"><label for="lname">Last name:</label></td>
                    <td class="inputarea"><input type="text" name="lname" id="lname" pattern="[a-zA-Z]{2,20}" required="required" placeholder="Please enter your Last name (2-20 alpha characters)"
                    value="<?php echo htmlspecialchars(isset($input_data['lname']) ? $input_data['lname'] : ''); ?>"></td>
                </tr>
            </table>

            <fieldset>
                <legend>Gender</legend>
                <div>
                    <input type="radio" name="gender" id="male" value="male" 
                    <?php echo (isset($input_data['gender']) && $input_data['gender'] == 'male') ? 'checked' : ''; ?>>
                    <label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" name="gender" id="female" value="female"
                    <?php echo (isset($input_data['gender']) && $input_data['gender'] == 'female') ? 'checked' : ''; ?>>
                    <label for="female">Female</label>
                </div>
                <div>
                    <input type="radio" name="gender" id="other" value="other"
                    <?php echo (isset($input_data['gender']) && $input_data['gender'] == 'other') ? 'checked' : ''; ?>>
                    <label for="other">Other</label>
                </div>
            </fieldset>
            <br>

            <table>
                <tr>
                    <td class="title"><label for="dob">Date of birth:</label></td>
                    <td class="inputarea"><input type="text" name="dob" id="dob" pattern="\d{2}/\d{2}/\d{4}" required="required" placeholder="dd/mm/yyyy; UTC+11"
                    value="<?php echo htmlspecialchars(isset($input_data['dob']) ? $input_data['dob'] : ''); ?>"></td>
                </tr>
                <tr>
                    <td class="title"><label for="str_address">Street address:</label></td>
                    <td class="inputarea"><input type="text" name="str_address" id="str_address" pattern="[a-zA-Z0-9,]{1,40}" required="required" placeholder="Max 40 characters"
                    value="<?php echo htmlspecialchars(isset($input_data['street']) ? $input_data['street'] : ''); ?>"></td>
                </tr>
                <tr>
                    <td class="title"><label for="town">Suburb/Town:</label></td>
                    <td class="inputarea">
                        <div class="townname">
                        <input type="text" name="town" id="town" pattern="[a-zA-Z0-9,]{1,40}" class="townname_input" required="required" placeholder="Max 40 characters"
                        value="<?php echo htmlspecialchars(isset($input_data['town']) ? $input_data['town'] : ''); ?>">
                        <select class="state_select" name="state">
                            <option value="" disabled selected hidden>State</option>
                            <option value="VIC" <?php echo (isset($input_data['state']) && $input_data['state'] == 'VIC') ? 'selected' : ''; ?>>VIC</option>
                            <option value="NSW" <?php echo (isset($input_data['state']) && $input_data['state'] == 'NSW') ? 'selected' : ''; ?>>NSW</option>
                            <option value="QLD" <?php echo (isset($input_data['state']) && $input_data['state'] == 'QLD') ? 'selected' : ''; ?>>QLD</option>
                            <option value="NT" <?php echo (isset($input_data['state']) && $input_data['state'] == 'NT') ? 'selected' : ''; ?>>NT</option>
                            <option value="WA" <?php echo (isset($input_data['state']) && $input_data['state'] == 'WA') ? 'selected' : ''; ?>>WA</option>
                            <option value="SA" <?php echo (isset($input_data['state']) && $input_data['state'] == 'SA') ? 'selected' : ''; ?>>SA</option>
                            <option value="TAS" <?php echo (isset($input_data['state']) && $input_data['state'] == 'TAS') ? 'selected' : ''; ?>>TAS</option>
                            <option value="ACT" <?php echo (isset($input_data['state']) && $input_data['state'] == 'ACT') ? 'selected' : ''; ?>>ACT</option>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="title"><label for="postcode">Postcode:</label></td>
                    <td class="inputarea"><input type="text" name="postcode" id="postcode" pattern="\d{4}" required="required" placeholder="xxxx"
                    value="<?php echo htmlspecialchars(isset($input_data['postcode']) ? $input_data['postcode'] : ''); ?>"></td>
                </tr>
				<tr>
					<td class="title"><label for="email">Email:</label></td>
					<td class="inputarea"><input type="text" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" required="required" placeholder="example123@email.com"
					value="<?php echo htmlspecialchars(isset($input_data['email']) ? $input_data['email'] : ''); ?>"></td>
				</tr>
				<tr>
					<td class="title"><label for="phone">Phone number:</label></td>
					<td class="inputarea"><input type="text" name="phone" id="phone" pattern=[\d\s]{8,12} required="required" placeholder="Please enter your phone number (8-12 digits)"
					value="<?php echo htmlspecialchars(isset($input_data['phone']) ? $input_data['phone'] : ''); ?>"></td>
				</tr>
            </table>

            <div class="skill">
				<Label class="skill_label">Skill:</Label>

				<div class="skill1">
					<div>
						<input type="checkbox" name="skill[]" id="html" value="html"
						<?php echo (isset($input_data['skill']) && in_array('html', $input_data['skill'])) ? 'checked' : ''?>>
						<label for="html">HTML</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="css" value="css"
						<?php echo (isset($input_data['skill']) && in_array('css', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="css">CSS</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="ui_ux" value="ui_ux"
						<?php echo (isset($input_data['skill']) && in_array('ui_ux', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="ui/ux">UI/UX design</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="js" value="js"
						<?php echo (isset($input_data['skill']) && in_array('js', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="js">Javascript</label>
					</div>
				</div>

				<div class="skill2">
					<div>
						<input type="checkbox" name="skill[]" id="php" value="php"
						<?= (isset($input_data['skill']) && in_array('php', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="php">PHP</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="sql" value="sql"
						<?= (isset($input_data['skill']) && in_array('sql', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="sql">SQL</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="python" value="python"
						<?= (isset($input_data['skill']) && in_array('python', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="python">Python</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="c/c++" value="c/c++"
						<?= (isset($input_data['skill']) && in_array('c/c++', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="c/c++">C/C++</label>
					</div>
				</div>

				<div class="skill3">
					<div>
						<input type="checkbox" name="skill[]" id="java" value="java"
						<?= (isset($input_data['skill']) && in_array('java', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="java">Java</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="statistic" value="statistic"
						<?= (isset($input_data['skill']) && in_array('statistic', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="statistic">Statistic</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="cybersecurity" value="cybersecurity"
						<?= (isset($input_data['skill']) && in_array('cybersecurity', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="cybersecurity">Cyber security</label>
					</div>
					<div>
						<input type="checkbox" name="skill[]" id="otherskill" value="otherskill"
						<?= (isset($input_data['skill']) && in_array('otherskill', $input_data['skill'])) ? 'checked' : '' ?>>
						<label for="otherskill">Other</label>
					</div>
				</div>
			</div>
				
			<div>
			<label for="otherdes">Other skill:</label><br>
			<textarea name="otherdes" id="otherdes" placeholder="What skill do you have?"><?php echo isset($input_data['otherskill']) ? htmlspecialchars($input_data['otherskill']) : '';  ?></textarea>
			</div>

			<div class="button-group">
				<input class="button" type="submit" value="Submit">
				<input class="button" type="reset" value="Reset">
			</div>
		</form>

    </section>


	<?php 
	$errors = [];
	$input_data = [];
	unset($_SESSION['from_jobs1']);
	#if (isset($_SESSION['from_process'])) {
	#	unset($_SESSION['from_process']);
	#	session_unset();
	#	session_destroy();
	#}
		?>
	

	<?php include("footer.inc")?>
</body>
</HTML>
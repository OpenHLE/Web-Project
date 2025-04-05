<!DOCTYPE HTML>
<HTML lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="creating Web Applications">
	<meta name="keywords" content="HTML, CSS, Javascript">
	<meta name="author" content="Minh">
	<link href="style/style.css" rel="stylesheet">
	<link href="style/confirm.css" rel="stylesheet">
	<title>Application Confirmation</title>

    <link href="style/confirm.css" rel="stylesheet"/>
</head>
<?php
session_start();
?>
<body>
<?php include("header.inc") ?>
<div  class = "cbox">
<!--Encase in a box-->
<section class="title">
    <h2 id="text1">Application Confirmation</h2>
    <a id="text2">
    <?php
    if (isset($_SESSION['success'])) {
        echo "<h3 class='success' style='color: green;'>" . $_SESSION['success'] . "<br>Your EOI ID is " . $_SESSION['eoi_id'] . "!</h3>";
        unset($_SESSION['success']); // Clear success message
    } else {
        echo "<p>No form submission detected.</p>";
    }
   

    ?> </a>
    <a href="jobs.php">
    <div class="returnbox">
    Return
    
    </div>
    </a>
    </section>
    
</div>
<?php include("footer.inc") ?>
</body>

</HTML>

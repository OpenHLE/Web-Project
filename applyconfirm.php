
<!DOCTYPE HTML>
<HTML lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="creating Web Applications">
	<meta name="keywords" content="HTML, CSS, Javascript">
	<meta name="author" content="Hai">
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
        echo "<h3 style='color: green;'>" . $_SESSION['success'] . "</h3>";
        unset($_SESSION['success']); // Clear success message
    } else {
        echo "<p>No form submission detected.</p>";
    }
   

    ?> </a>
    <a href="apply.php">
    <div class="returnbox">
    Return
    
    </div>
    </a>
    </section>
    
</div>

</body>
<?php include("header.inc") ?>
</HTML>

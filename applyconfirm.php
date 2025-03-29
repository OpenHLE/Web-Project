<!DOCTYPE HTML>
<HTML lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="creating Web Applications">
	<meta name="keywords" content="HTML, CSS, Javascript">
	<meta name="author" content="Minh">
	<link href="style/style.css" rel="stylesheet">
	<link href="style/apply.css" rel="stylesheet">
	<title>Application Confirmation</title>
</head>
<?php
session_start();
?>
<body>
    <h2>Application Confirmation</h2>

    <?php
    if (isset($_SESSION['success'])) {
        echo "<h3 style='color: green;'>" . $_SESSION['success'] . "</h3>";
        unset($_SESSION['success']); // Clear success message
    } else {
        echo "<p>No form submission detected.</p>";
    }
    ?>

</body>
</HTML>
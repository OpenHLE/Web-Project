<?php 
session_start();
$job_found = $_SESSION["job_found"];
$title = isset($_GET["Title"]) ? $_GET["Title"] : "";
$loca = isset($_GET["Location"]) ? $_GET["Location"] : "";

function display_other_jobs($currentTitle) {
  global $job_found;
  $otherJobs = [];

  
  foreach ($job_found as $job) {
      if ($job["Title"] !== $currentTitle && trim(strtolower($job["Status"])) === "available") {
          $otherJobs[] = $job["Title"];
      }
  }

  
  shuffle($otherJobs);
  $validJobs = [];
foreach ($otherJobs as $jobTitle) {
    foreach ($job_found as $job) {
        if ($job["Title"] === $jobTitle && trim(strtolower($job["Status"])) === "available") {
            $validJobs[] = $jobTitle;
            break; 
        }
    }
}
$otherJobs = array_slice($validJobs, 0, 3);

  // Display section
  if (!empty($otherJobs)) {
      echo '<h2 id="othertitle">Other Jobs You Might Be Interested In</h2>';
      foreach ($otherJobs as $jobTitle) {
        foreach ($job_found as $job) {
            if ($job["Title"] === $jobTitle && trim(strtolower($job["Status"])) === "available") {
                echo '<p><a id="otherscontainer" class="others" href="jobs1.php?Title=' . urlencode($jobTitle) . '&Location=' . urlencode($job["Locations"]) . '">' . htmlspecialchars($jobTitle) . '</a></p>';
                break; // Stop after finding the correct job
            }
          }
     }
  }
}


for ($a = 0; $a < count($job_found); $a++) {
  $selected = $job_found[$a];
  if (strcasecmp($title, $selected["Title"]) == 0 && strcasecmp($loca, $selected["Locations"]) == 0) {
    $locations = $selected["Locations"];
    $employmenttype = $selected["EmploymentType"];
    $department = $selected["Department"];
    $reportto = $selected["ReportsTo"];
    $referencenumber = $selected["ReferenceNumber"];
    $expectedincome = $selected["ExpectedIncome"];
    $benefit1 = $selected["Benefits1"];
    $benefit2 = $selected["Benefits2"];
    $benefit3 = $selected["Benefits3"];
    $overview = $selected["Overview"];
    $status = $selected["Status"];
    $responsabilities = json_decode($selected["Responsibilities"], true);
    $requirement = json_decode($selected["Requirement"], true);
    $preferable = json_decode($selected["Preferable"], true);
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="description" content="Job Description" />
  <meta name="keywords" content="HTML, tags, CSS, Javascript, PHP" />
  <meta name="author" content="Huy, Souju"  />
  <title>TECHYA</title>
  <link href="style/style.css" rel="stylesheet"/>
  <link href="style/description.css" rel="stylesheet"/>
</head>

<body>
    <?php 
    include("header.inc");

    echo ("<hr>");

    echo ("<h1 class=\"job\">" . $title . "<a class=\"image1\" href=\"jobs.php\" title=\"Return\"><img src=\"images/images-removebg-preview.png\" alt=\"arrow icon\"/></a></h1>");


    echo ("<div class=\"sidebar\">");

    echo ("<ul class=\"fixed\"> ");
    echo ("<li class=\"title\"> Location </li>");
    echo ("<li class=\"basicinfo\"><strong>" . $locations . "</strong></li>");
    echo ("<li  class=\"title\">Employment Type</li>");
    echo ("<li class=\"basicinfo\"><strong>" . $employmenttype . "</strong></li>");
    echo ("<li  class=\"title\">Department </li>");
    echo ("<li class=\"basicinfo\"><strong>" . $department . "</strong></li>");
    echo ("<li  class=\"title\">Reports to </li>");
    echo ("<li class=\"basicinfo\"><strong>" . $reportto . "</strong></li>");
    echo ("<li  class=\"title\">Job Reference No. </li>");
    echo ("<li class=\"basicinfo\"><strong>" . $referencenumber . "</strong></li>");
    echo ("<li  class=\"title\">Expected Income</li>");
    echo ("<li class=\"basicinfo\"><strong>" . $expectedincome . "</strong> </li>");
    echo ("<li id=\"a0\"> Additional possible benefits may include:</li>");

    echo ("</ul>");


    echo ("<ul class=\"additional\">");

    echo ("    <li id=\"a1\">1." . $benefit1 . "</li>");
    echo ("    <li id=\"a2\">2." . $benefit2 . "</li>");
    echo ("    <li id=\"a3\">3." . $benefit3 . "</li>");

    echo ("</ul>");

    echo ("</div>");


    echo ("<div class=\"container\">");
    echo ("    ");
    echo ("<article class=\"box\" id=\"m1\">");
    echo ("    ");
    echo ("<h2>Job Overview</h2>");
    echo ("<p >" . $overview . "</p>");

    echo ("</article>");


    echo ("<div class=\"box\" id=\"m2\">");
    echo ("<section >");

    echo ("<h2>Responsibilities</h2>");
    echo ("<ul class=\"list2\">");
    foreach ($responsabilities as $item) {
      echo ("<li>" . htmlspecialchars($item['text']) . "</li>");
    }
    echo ("</ul>");

    echo ("</section>");
    echo ("</div>");


    echo ("<div class=\"box\" id=\"m3\">");
    echo ("<section >");

    echo ("<h2>Required Qualifications</h2>");
    echo ("<ul class=\"list3\">");
    foreach ($requirement as $item) {
      echo ("<li>" . htmlspecialchars($item['text']) . "</li>");
    }
    echo ("</ul>");

    echo ("</section>");
    echo ("</div>");


    echo ("<div class=\"box\" id=\"m4\">");
    echo ("<section >");

    echo ("<h2>Qualities we prefer:</h2>");
    echo ("<ol class=\"list4\">");
    foreach ($preferable as $item) {
      echo ("<li><strong>" . htmlspecialchars($item['title']) . "</strong></li>");
      echo ("<p>" . htmlspecialchars($item['description']) . "</p>");
    }
    echo ("</ol>");

    echo ("</section>");
    echo ("</div>");


    echo ("<aside>");
    echo ("<h2 class=\"question\">Why Should You Work For Us?</h2>");
    echo ("<p class=\"answer\">Here, you'll be part of a mission-driven team dedicated to transforming global education. We offer a collaborative, innovative work environment where you can grow professionally while making a real impact on the world. With access to world-class learning resources, negotiable competitive salaries with benefits, and a culture that values continuous improvement, Company is the perfect place to build your career.</p>  ");
    echo ("</aside>");

    echo ("</div>");
    $_SESSION['from_jobs1'] = true;
    if ($status == "Available") {
      $_SESSION['job_ref_num'] = $referencenumber;

      echo ("<div id=\"refer\">");
      echo ("<h3 class=\"Apply\"><a id=\"ap1\" href=\"apply.php\">Apply Now</a></h3>");
      echo ("<h3 class=\"Refer\"><a  id= \"r-1\" href=\"Refer.php\">Refer A Friend</a></h3>");
      echo ("</div>");
    }
    
    display_other_jobs($title);


    include("footer.inc");
    ?>

</body>
</html>

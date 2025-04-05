<?php
session_start();
//Kết nối database
include_once("settings.php");
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

// Kiểm tra kết nối
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy data trong database apppend vào array
$_SESSION["job_found"] = [];

$sql = "SELECT * FROM Jobs1 ORDER BY Status ASC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    array_push($_SESSION["job_found"], $row);
}

session_write_close();
$job_found = $_SESSION["job_found"];


function print_all() {
    global $job_found;
    for ($a = 0; $a < count($job_found); $a++) {
        $selected = $job_found[$a];
        if (strtolower($selected["Status"]) == "available") {
            $title = $selected["Title"];
            $status = $selected["Status"];
            $loca = $selected["Locations"];
            $ref_num = $selected["ReferenceNumber"];
            echo ("<tr data-info = \"" . $ref_num . "\">
                    <td>". $title ."</td>
                    <td>". $loca ."</td>
                    <td><a href = \"jobs1.php?Title=" . $title . "&Location=" . $loca . "\">INFO</a></td>
                    <td><a href = \"apply.php?Refnum=" . $ref_num . "\">Apply</a></td>
                    <td>". $status ."</td>
                </tr>");
        }
    }
}

function search_job($search) {
    global $job_found;
    for ($a = 0; $a < count($job_found); $a++) {
        $selected = $job_found[$a];
        if (strpos(strtolower($selected["Title"]), strtolower($search)) !== false) {
            if (strtolower($selected["Status"]) == "available") {
             $title = $selected["Title"];
             $status = $selected["Status"];
             $loca = $selected["Locations"];
             $ref_num = $selected["ReferenceNumber"];
            echo ("<tr data-info = \"" . $ref_num . "\">
                <td>". $title ."</td>
                <td>". $loca ."</td>
                <td><a href = \"jobs1.php?Title=" . $title . "&Location=" . $loca . "\">INFO</a></td>
                <td><a href = \"apply.php?Refnum=" . $ref_num . "\">Apply</a></td>
                <td>". $status ."</td>
            </tr>");   
            }
            if (strtolower($selected["Status"]) == "unavailable") {
                $title = $selected["Title"];
                $status = $selected["Status"];
                $loca = $selected["Locations"];
                echo ("<tr>
                    <td class=\"unv\">". $title ."</td>
                    <td class=\"unv\">". $loca ."</td>
                    <td class=\"unv1\"><a href = \"jobs1.php?Title=" . $title . "&Location=" . $loca . "\">INFO</a></td>
                    <td class=\"unv\"><a>Apply</a></td>
                    <td class=\"unv\">". $status ."</td>
                </tr>");      
            }
            
        }
        
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Career</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="style/style.css" rel="stylesheet"/>
    <link href="style/jobs.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
</head>
<body>
    <?php include("header.inc") ?>

    
    <section class="careers">
        <h2>CAREERS</h2>

            <form method="GET" action="jobs.php">
            <div class="search">
            <span class="search-icon material-symbols-outlined">search</span>
            <input class = "search-input" type="text" name="search" placeholder="Enter Job Position..."> 
            <button type="submit" class="search-btn">Search</button>
            <button type="button" class="clear-btn" onclick="window.location.href='?'">Clear</button>
            </div>
            </form>

            <!-- Bảng danh sách công việc -->
            <table class="jobs-table">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Location</th>
                        <th>Info</th>
                        <th>Apply</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <?php
                    
                    if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                    } else {
                        $search = null;
                    }

                    if (!$search) {
                        print_all();
                    } else {
                        search_job($search);
                    }

                ?>
            </table>
        </section>
    
</body>

<?php include("footer.inc") ?>
</html>

<?php
$conn->close();
?>
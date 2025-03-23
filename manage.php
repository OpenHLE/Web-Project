<?php
// Database connection parameters
$host = "localhost"; 
$user = "root";      
$password = "";     
$database = "eoi_db"; // Database name

    // Create database connection (only enable when mysql is present)
// $conn = mysqli_connect($host, $user, $password, $database);

    // Check connection (only enable when mysql is present)
//if (!$conn) {
//    die("Connection failed: " . mysqli_connect_error());
//}

// Initialize variables
$message = "";
$results = [];
$action = "";

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";
    
    // List all EOIs
    if ($action == "list_all") {
        $results = listAllEOIs($conn);
    }
    
    // List EOIs for a specific job reference
    elseif ($action == "list_by_job") {
        $job_ref = $_POST["job_ref"] ?? "";
        if (!empty($job_ref)) {
            $results = listEOIsByJobRef($conn, $job_ref);
        } else {
            $message = "Please enter a job reference number.";
        }
    }
    
    // List EOIs for a specific applicant
    elseif ($action == "list_by_applicant") {
        $first_name = $_POST["first_name"] ?? "";
        $last_name = $_POST["last_name"] ?? "";
        if (!empty($first_name) || !empty($last_name)) {
            $results = listEOIsByApplicant($conn, $first_name, $last_name);
        } else {
            $message = "Please enter at least a first name or last name.";
        }
    }
    
    // Delete EOIs for a specific job reference
    elseif ($action == "delete_by_job") {
        $job_ref = $_POST["job_ref"] ?? "";
        if (!empty($job_ref)) {
            $message = deleteEOIsByJobRef($conn, $job_ref);
        } else {
            $message = "Please enter a job reference number.";
        }
    }
    
    // Change status of an EOI
    elseif ($action == "change_status") {
        $eoi_id = $_POST["eoi_id"] ?? "";
        $new_status = $_POST["new_status"] ?? "";
        if (!empty($eoi_id) && !empty($new_status)) {
            $message = changeEOIStatus($conn, $eoi_id, $new_status);
        } else {
            $message = "Please enter an EOI ID and select a new status.";
        }
    }
}

// Function to list all EOIs
function listAllEOIs($conn) {
    $sql = "SELECT id, job_reference, first_name, last_name, 
            street_address, suburb, state, postcode, 
            email, phone, skill1, skill2, other_skills
            FROM eoi";
    $result = mysqli_query($conn, $sql);
    
    $eois = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eois[] = $row;
        }
    }
    
    return $eois;
}

// Function to list EOIs by job reference number
function listEOIsByJobRef($conn, $job_ref) {
    $sql = "SELECT * FROM eoi WHERE job_reference = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $job_ref);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $eois = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eois[] = $row;
        }
    }
    
    return $eois;
}

// Function to list EOIs by applicant name
function listEOIsByApplicant($conn, $first_name, $last_name) {
    $sql = "SELECT * FROM eoi WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($first_name)) {
        $sql .= " AND first_name LIKE ?";
        $first_name = "%$first_name%";
        $params[] = $first_name;
        $types .= "s";
    }
    
    if (!empty($last_name)) {
        $sql .= " AND last_name LIKE ?";
        $last_name = "%$last_name%";
        $params[] = $last_name;
        $types .= "s";
    }
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $eois = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eois[] = $row;
        }
    }
    
    return $eois;
}

// Function to delete EOIs by job reference
function deleteEOIsByJobRef($conn, $job_ref) {
    $sql = "DELETE FROM eoi WHERE job_reference = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $job_ref);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return mysqli_stmt_affected_rows($stmt) . " EOI(s) deleted successfully.";
    } else {
        return "No EOIs found with the given job reference number.";
    }
}

// Function to change EOI status
function changeEOIStatus($conn, $eoi_id, $new_status) {
    $sql = "UPDATE eoi SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $eoi_id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return "EOI status updated successfully.";
    } else {
        return "Failed to update EOI status or EOI not found.";
    }
}

// Close connection - commented out to allow the HTML part to access $conn
// mysqli_close($conn);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="EOI Management System">
    <meta name="keywords" content="EOI, Management, PHP, MySQL">
    <meta name="author" content="Le Tuan Huy">
    <link href="style/style.css" rel="stylesheet">
    <link href="style/manage.css" rel="stylesheet">
    <title>EOI Management</title>
</head>
<body>
    <header class="navbar">   
        <div class="brand">
            <img class="logo" src="images/logo.png" alt="logo">
            <h1>Techya</h1>            
        </div>
        <nav>
            <ul>
                <li id="home"><a href="index.html">Home</a></li>
                <li id="jobs"><a href="jobs.html">Career</a></li>
                <li id="apply"><a href="apply.html">Apply</a></li>
                <li id="abt"><a href="about.html">About</a></li>
                <li id="enhancement"><a href="enhancement.html">Enhance</a></li>
            </ul>
        </nav>   
    </header>
    
    <div class="container">
        <h1>EOI Management System</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-section">
            <h2>List All EOIs</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="list_all">
                <input type="submit" value="List All EOIs">
            </form>
        </div>
        
        <div class="form-section">
            <h2>List EOIs by Job Reference Number</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="list_by_job">
                <input type="text" name="job_ref" placeholder="Job Reference Number" pattern="[A-Z0-9]{5}" title="5 characters, uppercase letters and numbers only">
                <input type="submit" value="Search">
            </form>
        </div>
        
        <div class="form-section">
            <h2>List EOIs by Applicant Name</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="list_by_applicant">
                <input type="text" name="first_name" placeholder="First Name">
                <input type="text" name="last_name" placeholder="Last Name">
                <input type="submit" value="Search">
            </form>
        </div>
        
        <div class="form-section">
            <h2>Delete EOIs by Job Reference Number</h2>
            <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete all EOIs with this job reference number?');">
                <input type="hidden" name="action" value="delete_by_job">
                <input type="text" name="job_ref" placeholder="Job Reference Number" pattern="[A-Z0-9]{5}" title="5 characters, uppercase letters and numbers only" required>
                <input type="submit" value="Delete">
            </form>
        </div>
        
        <div class="form-section">
            <h2>Change EOI Status</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="change_status">
                <input type="text" name="eoi_id" placeholder="EOI ID" required>
                <select name="new_status" required>
                    <option value="">Select Status</option>
                    <option value="New">New</option>
                    <option value="Current">Current</option>
                    <option value="Final">Final</option>
                    <option value="Rejected">Rejected</option>
                </select>
                <input type="submit" value="Update Status">
            </form>
        </div>
        
        <?php if (!empty($results)): ?>
            <h2>Search Results</h2>
            <table>
                <thead>
                    <tr>
                        <th>EOI Number</th>
                        <th>Job Reference</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Street Address</th>
                        <th>Suburb/Town</th>
                        <th>State</th>
                        <th>Postcode</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Skill 1</th>
                        <th>Skill 2</th>
                        <th>Other Skills</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $eoi): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($eoi['id']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['job_reference']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['street_address']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['suburb']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['state']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['postcode']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['email']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['phone']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['skill1']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['skill2']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['other_skills']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($action && empty($message)): ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
    
    <footer>
        <div class="brandfooter">
           <img class="logo" src="images/logo.png" alt="logo">
           <h1>Techya</h1>            
       </div>
       
       <p class="contact">Contact us:
            <br>
            <a href="https://youtube.com/"><img src=images/youtube-logo.png alt="ytb logo"></a>
            <a href="https://github.com/OpenHLE/Web-Project"><img src=images/github-logo.png alt="github logo"></a>
            <a href="mailto:105550542@student.swin.edu.au"><img src=images/mail-logo.png alt="mail logo"></a>
       </p>
       <div class="location">
           <p>Our location:</p>
           
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.042153278479!2d105.78157517829588!3d21.03099928045221!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135bfa667a7dee9%3A0x2ac9ba5f99e4f389!2sSwinburne%20Innovation%20Space!5e0!3m2!1svi!2s!4v1740037300397!5m2!1svi!2s" width="200" height="150" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
       </div>

       <p class="copyright">&copy; 2025 Techya. All rights reserved.</p>
   </footer>
</body>
</html>

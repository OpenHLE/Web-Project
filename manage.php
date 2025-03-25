<?php
// Include database connection settings
require_once("settings.php");
// Include enhancements
require_once("phpenhancements.php");

// Create database connection
$conn = mysqli_connect($host, $user, $pwd, $sql_db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$message = "";
$results = [];
$action = $_POST["action"] ?? "";
$sort_field = $_POST["sort_field"] ?? "id";  // Default sort by EOI number
$sort_order = $_POST["sort_order"] ?? "ASC"; // Default ascending order

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // List all EOIs
    if ($action == "list_all") {
        $results = listAllEOIs($conn, $sort_field, $sort_order);
    }
    
    // List EOIs for a specific job reference
    elseif ($action == "list_by_job") {
        $job_ref = $_POST["job_ref"] ?? "";
        if (!empty($job_ref)) {
            $results = listEOIsByJobRef($conn, $job_ref, $sort_field, $sort_order);
        } else {
            $message = "Please enter a job reference number.";
        }
    }
    
    // List EOIs for a specific applicant
    elseif ($action == "list_by_applicant") {
        $first_name = $_POST["first_name"] ?? "";
        $last_name = $_POST["last_name"] ?? "";
        if (!empty($first_name) || !empty($last_name)) {
            $results = listEOIsByApplicant($conn, $first_name, $last_name, $sort_field, $sort_order);
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
function listAllEOIs($conn, $sort_field = "id", $sort_order = "ASC") {
    $sql = "SELECT EOInumber as id, JobReferenceNumber as job_reference, FirstName as first_name, 
            LastName as last_name, StreetAddress as street_address, TownOrSuburbs as suburb, 
            State as state, Postcode as postcode, Email as email, PhoneNumber as phone, 
            Status as status, OtherSkills as other_skills
            FROM EOI";
    
    // Apply sorting from phpenhancements.php
    $sql = enhanceQueryWithSorting($sql, $sort_field, $sort_order);
    
    $result = mysqli_query($conn, $sql);
    
    $eois = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Get skills for this EOI
            $skills_sql = "SELECT Skills FROM EOI_Skills WHERE EOInumber = " . $row['id'];
            $skills_result = mysqli_query($conn, $skills_sql);
            
            $skills = [];
            if (mysqli_num_rows($skills_result) > 0) {
                while($skill_row = mysqli_fetch_assoc($skills_result)) {
                    $skills[] = $skill_row['Skills'];
                }
            }
            
            // Add skills to row
            if (!empty($skills)) {
                $row['skill1'] = $skills[0] ?? '';
                $row['skill2'] = $skills[1] ?? '';
            }
            
            $eois[] = $row;
        }
    }
    
    return $eois;
}

// Function to list EOIs by job reference number
function listEOIsByJobRef($conn, $job_ref, $sort_field = "id", $sort_order = "ASC") {
    $sql = "SELECT EOInumber as id, JobReferenceNumber as job_reference, FirstName as first_name, 
            LastName as last_name, StreetAddress as street_address, TownOrSuburbs as suburb, 
            State as state, Postcode as postcode, Email as email, PhoneNumber as phone, 
            Status as status, OtherSkills as other_skills
            FROM EOI WHERE JobReferenceNumber = ?";
    
    // Apply sorting from phpenhancements.php
    $sql = enhanceQueryWithSorting($sql, $sort_field, $sort_order);
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $job_ref);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $eois = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Get skills for this EOI
            $skills_sql = "SELECT Skills FROM EOI_Skills WHERE EOInumber = " . $row['id'];
            $skills_result = mysqli_query($conn, $skills_sql);
            
            $skills = [];
            if (mysqli_num_rows($skills_result) > 0) {
                while($skill_row = mysqli_fetch_assoc($skills_result)) {
                    $skills[] = $skill_row['Skills'];
                }
            }
            
            // Add skills to row
            if (!empty($skills)) {
                $row['skill1'] = $skills[0] ?? '';
                $row['skill2'] = $skills[1] ?? '';
            }
            
            $eois[] = $row;
        }
    }
    
    return $eois;
}

// Function to list EOIs by applicant name
function listEOIsByApplicant($conn, $first_name, $last_name, $sort_field = "id", $sort_order = "ASC") {
    $sql = "SELECT EOInumber as id, JobReferenceNumber as job_reference, FirstName as first_name, 
            LastName as last_name, StreetAddress as street_address, TownOrSuburbs as suburb, 
            State as state, Postcode as postcode, Email as email, PhoneNumber as phone, 
            Status as status, OtherSkills as other_skills
            FROM EOI WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($first_name)) {
        $sql .= " AND FirstName LIKE ?";
        $first_name = "%$first_name%";
        $params[] = $first_name;
        $types .= "s";
    }
    
    if (!empty($last_name)) {
        $sql .= " AND LastName LIKE ?";
        $last_name = "%$last_name%";
        $params[] = $last_name;
        $types .= "s";
    }
    
    // Apply sorting from phpenhancements.php
    $sql = enhanceQueryWithSorting($sql, $sort_field, $sort_order);
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $eois = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Get skills for this EOI
            $skills_sql = "SELECT Skills FROM EOI_Skills WHERE EOInumber = " . $row['id'];
            $skills_result = mysqli_query($conn, $skills_sql);
            
            $skills = [];
            if (mysqli_num_rows($skills_result) > 0) {
                while($skill_row = mysqli_fetch_assoc($skills_result)) {
                    $skills[] = $skill_row['Skills'];
                }
            }
            
            // Add skills to row
            if (!empty($skills)) {
                $row['skill1'] = $skills[0] ?? '';
                $row['skill2'] = $skills[1] ?? '';
            }
            
            $eois[] = $row;
        }
    }
    
    return $eois;
}

// Function to delete EOIs by job reference
function deleteEOIsByJobRef($conn, $job_ref) {
    // First get EOI IDs to delete skills
    $get_ids_sql = "SELECT EOInumber FROM EOI WHERE JobReferenceNumber = ?";
    $stmt = mysqli_prepare($conn, $get_ids_sql);
    mysqli_stmt_bind_param($stmt, "s", $job_ref);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $eoi_ids = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eoi_ids[] = $row['EOInumber'];
        }
    }
    
    // Delete from EOI_Skills first
    if (!empty($eoi_ids)) {
        foreach ($eoi_ids as $eoi_id) {
            $delete_skills_sql = "DELETE FROM EOI_Skills WHERE EOInumber = ?";
            $stmt = mysqli_prepare($conn, $delete_skills_sql);
            mysqli_stmt_bind_param($stmt, "i", $eoi_id);
            mysqli_stmt_execute($stmt);
        }
    }
    
    // Then delete from EOI
    $sql = "DELETE FROM EOI WHERE JobReferenceNumber = ?";
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
    $sql = "UPDATE EOI SET Status = ? WHERE EOInumber = ?";
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
    <?php include("header.inc") ?>
    
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
                <?php echo getSortFormInputs($sort_field, $sort_order); ?>
                <input type="submit" value="List All EOIs">
            </form>
        </div>
        
        <div class="form-section">
            <h2>List EOIs by Job Reference Number</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="list_by_job">
                <input type="text" name="job_ref" placeholder="Job Reference Number" pattern="[A-Z]{2}[0-9]{3}" title="2 uppercase letters followed by 3 digits, e.g., AB123">
                <?php echo getSortFormInputs($sort_field, $sort_order); ?>
                <input type="submit" value="Search">
            </form>
        </div>
        
        <div class="form-section">
            <h2>List EOIs by Applicant Name</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="list_by_applicant">
                <input type="text" name="first_name" placeholder="First Name">
                <input type="text" name="last_name" placeholder="Last Name">
                <?php echo getSortFormInputs($sort_field, $sort_order); ?>
                <input type="submit" value="Search">
            </form>
        </div>
        
        <div class="form-section">
            <h2>Delete EOIs by Job Reference Number</h2>
            <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete all EOIs with this job reference number?');">
                <input type="hidden" name="action" value="delete_by_job">
                <input type="text" name="job_ref" placeholder="Job Reference Number" pattern="[A-Z]{2}[0-9]{3}" title="2 uppercase letters followed by 3 digits, e.g., AB123" required>
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
            <h2 id="results">Search Results (Click on the titles in the table to sort in order)</h2>
            <table>
                <thead>
                    <tr>
                        <th><?php 
                            // Create additional parameters array based on current action
                            $params = [];
                            if ($action == 'list_by_job' && !empty($_POST['job_ref'])) {
                                $params['job_ref'] = $_POST['job_ref'];
                            } elseif ($action == 'list_by_applicant') {
                                $params['first_name'] = $_POST['first_name'] ?? '';
                                $params['last_name'] = $_POST['last_name'] ?? '';
                            }
                            echo getSortableHeaderLink('id', 'EOI Number', $sort_field, $sort_order, $action, $params); 
                        ?></th>
                        <th><?php echo getSortableHeaderLink('job_reference', 'Job Reference', $sort_field, $sort_order, $action, $params); ?></th>
                        <th><?php echo getSortableHeaderLink('first_name', 'First Name', $sort_field, $sort_order, $action, $params); ?></th>
                        <th><?php echo getSortableHeaderLink('last_name', 'Last Name', $sort_field, $sort_order, $action, $params); ?></th>
                        <th>Street Address</th>
                        <th>Suburb/Town</th>
                        <th>State</th>
                        <th>Postcode</th>
                        <th><?php echo getSortableHeaderLink('email', 'Email', $sort_field, $sort_order, $action, $params); ?></th>
                        <th>Phone</th>
                        <th>Skill 1</th>
                        <th>Skill 2</th>
                        <th>Other Skills</th>
                        <th><?php echo getSortableHeaderLink('status', 'Status', $sort_field, $sort_order, $action, $params); ?></th>
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
                            <td><?php echo htmlspecialchars($eoi['skill1'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($eoi['skill2'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($eoi['other_skills']); ?></td>
                            <td><?php echo htmlspecialchars($eoi['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($action && empty($message)): ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
    
    <?php include("footer.inc")?>
</body>
</html>
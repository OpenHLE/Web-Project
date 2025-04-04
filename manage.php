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
$action = isset($_POST["action"]) ? $_POST["action"] : "";
$sort_field = isset($_POST["sort_field"]) ? $_POST["sort_field"] : "id";  // Default sort by EOI number
$sort_order = isset($_POST["sort_order"]) ? $_POST["sort_order"] : "ASC"; // Default ascending order
$editing = false;
$edit_eoi = null;
$updated_status_id = null; // To track the ID of recently updated EOI

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // List all EOIs
    if ($action == "list_all") {
        $results = listAllEOIs($conn, $sort_field, $sort_order);
    }
    
    // List EOIs for a specific job reference
    elseif ($action == "list_by_job") {
        $job_ref = isset($_POST["job_ref"]) ? $_POST["job_ref"] : "";
        if (!empty($job_ref)) {
            $results = listEOIsByJobRef($conn, $job_ref, $sort_field, $sort_order);
        } else {
            $message = "Please enter a job reference number.";
        }
    }
    
    // List EOIs for a specific applicant
    elseif ($action == "list_by_applicant") {
        $first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : "";
        $last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : "";
        if (!empty($first_name) || !empty($last_name)) {
            $results = listEOIsByApplicant($conn, $first_name, $last_name, $sort_field, $sort_order);
        } else {
            $message = "Please enter at least a first name or last name.";
        }
    }
    
    // Delete EOIs for a specific job reference
    elseif ($action == "delete_by_job") {
        $job_ref = isset($_POST["job_ref"]) ? $_POST["job_ref"] : "";
        if (!empty($job_ref)) {
            $message = deleteEOIsByJobRef($conn, $job_ref);
        } else {
            $message = "Please enter a job reference number.";
        }
    }
    
    // Change status of an EOI
    elseif ($action == "change_status") {
        $eoi_id = isset($_POST["eoi_id"]) ? $_POST["eoi_id"] : "";
        $new_status = isset($_POST["new_status"]) ? $_POST["new_status"] : "";
        if (!empty($eoi_id) && !empty($new_status)) {
            $message = changeEOIStatus($conn, $eoi_id, $new_status);
            // Load all EOIs after changing status to keep the table visible
            $results = listAllEOIs($conn, $sort_field, $sort_order);
            // Store the updated EOI ID to highlight it in the table
            $updated_status_id = $eoi_id;
        } else {
            $message = "Please enter an EOI ID and select a new status.";
        }
    }
    
    // Edit EOI data
    elseif ($action == "edit_eoi") {
        $eoi_id = isset($_POST["eoi_id"]) ? $_POST["eoi_id"] : "";
        if (!empty($eoi_id)) {
            // Get EOI data for editing
            $edit_eoi = getEOIById($conn, $eoi_id);
            $editing = true;
            // Jút load current EOI selected for editing
            // $results = listAllEOIs($conn, $sort_field, $sort_order);
            $results = []; // Empty results to avoid displaying all rows
        } else {
            $message = "Invalid EOI ID.";
        }
    }
    
    // Update EOI data
    elseif ($action == "update_eoi") {
        $eoi_id = isset($_POST["eoi_id"]) ? $_POST["eoi_id"] : "";
        if (!empty($eoi_id)) {
            $message = updateEOIData($conn, $_POST);
            // Set the action to list_all for redisplay after update
            $action = "list_all";
            $results = listAllEOIs($conn, $sort_field, $sort_order);
        } else {
            $message = "Invalid EOI ID.";
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
            
            // Add skills to row as array
            $row['skills'] = $skills;
            
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
            
            // Add skills to row as array
            $row['skills'] = $skills;
            
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
        // Replace argument unpacking (...$params) with call_user_func_array
        $ref_array = array(&$stmt, &$types);
        foreach($params as &$param) {
            $ref_array[] = &$param;
        }
        call_user_func_array('mysqli_stmt_bind_param', $ref_array);
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
            
            // Add skills to row as array
            $row['skills'] = $skills;
            
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

// Function to get a specific EOI by ID
function getEOIById($conn, $eoi_id) {
    $sql = "SELECT EOInumber as id, JobReferenceNumber as job_reference, FirstName as first_name, 
            LastName as last_name, StreetAddress as street_address, TownOrSuburbs as suburb, 
            State as state, Postcode as postcode, Email as email, PhoneNumber as phone, 
            Status as status, OtherSkills as other_skills
            FROM EOI WHERE EOInumber = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $eoi_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $eoi = mysqli_fetch_assoc($result);
        
        // Get skills for this EOI
        $skills_sql = "SELECT Skills FROM EOI_Skills WHERE EOInumber = ?";
        $stmt = mysqli_prepare($conn, $skills_sql);
        mysqli_stmt_bind_param($stmt, "i", $eoi_id);
        mysqli_stmt_execute($stmt);
        $skills_result = mysqli_stmt_get_result($stmt);
        
        $skills = [];
        if (mysqli_num_rows($skills_result) > 0) {
            while($skill_row = mysqli_fetch_assoc($skills_result)) {
                $skills[] = $skill_row['Skills'];
            }
        }
        
        // Add skills to row
        $eoi['skills'] = $skills;
        
        return $eoi;
    }
    
    return null;
}

// Function to update EOI data
function updateEOIData($conn, $data) {
    $eoi_id = isset($data['eoi_id']) ? $data['eoi_id'] : '';
    $job_reference = isset($data['job_reference']) ? $data['job_reference'] : '';
    $first_name = isset($data['first_name']) ? $data['first_name'] : '';
    $last_name = isset($data['last_name']) ? $data['last_name'] : '';
    $street_address = isset($data['street_address']) ? $data['street_address'] : '';
    $suburb = isset($data['suburb']) ? $data['suburb'] : '';
    $state = isset($data['state']) ? $data['state'] : '';
    $postcode = isset($data['postcode']) ? $data['postcode'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $phone = isset($data['phone']) ? $data['phone'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $other_skills = isset($data['other_skills']) ? $data['other_skills'] : '';
    $skills = isset($data['skills']) ? $data['skills'] : '';
    
    // Start transaction
    mysqli_autocommit($conn, FALSE);
    
    try {
        // Update EOI table
        $sql = "UPDATE EOI SET 
                JobReferenceNumber = ?, 
                FirstName = ?, 
                LastName = ?, 
                StreetAddress = ?, 
                TownOrSuburbs = ?, 
                State = ?, 
                Postcode = ?, 
                Email = ?, 
                PhoneNumber = ?, 
                Status = ?, 
                OtherSkills = ? 
                WHERE EOInumber = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 
            "sssssssssssi", 
            $job_reference, 
            $first_name, 
            $last_name, 
            $street_address, 
            $suburb, 
            $state, 
            $postcode, 
            $email, 
            $phone, 
            $status, 
            $other_skills, 
            $eoi_id
        );
        
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            throw new Exception("Failed to update EOI data");
        }
        
        // Delete existing skills
        $delete_sql = "DELETE FROM EOI_Skills WHERE EOInumber = ?";
        $stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($stmt, "i", $eoi_id);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            throw new Exception("Failed to delete existing skills");
        }
        
        // Insert new skills
        if (!empty($skills)) {
            // Skills might be submitted as a comma-separated string
            if (is_string($skills)) {
                $skills_array = array_map('trim', explode(',', $skills));
            } else {
                $skills_array = $skills;
            }
            
            foreach ($skills_array as $skill) {
                if (!empty($skill)) {
                    $insert_sql = "INSERT INTO EOI_Skills (EOInumber, Skills) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $insert_sql);
                    mysqli_stmt_bind_param($stmt, "is", $eoi_id, $skill);
                    $result = mysqli_stmt_execute($stmt);
                    
                    if (!$result) {
                        throw new Exception("Failed to insert skill: " . $skill);
                    }
                }
            }
        }
        
        // Commit transaction
        mysqli_commit($conn);
        mysqli_autocommit($conn, TRUE);
        return "EOI data updated successfully.";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        mysqli_autocommit($conn, TRUE);
        return "Error updating EOI data: " . $e->getMessage();
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
        
        <div class="form-section">
            <h2>List All EOIs</h2>
            <form method="post" action="#results-section">
                <input type="hidden" name="action" value="list_all">
                <?php echo getSortFormInputs($sort_field, $sort_order); ?>
                <input type="submit" value="List All EOIs">
            </form>
        </div>
        
        <div class="form-section">
            <h2>List EOIs by Job Reference Number</h2>
            <form method="post" action="#results-section">
                <input type="hidden" name="action" value="list_by_job">
                <input type="text" name="job_ref" placeholder="Job Reference Number" pattern="[A-Za-z]{2}[0-9]{2,3}" title="2 letters followed by 2-3 digits (e.g., DB01, AB123)">
                <?php echo getSortFormInputs($sort_field, $sort_order); ?>
                <input type="submit" value="Search">
            </form>
        </div>
        
        <div class="form-section">
            <h2>List EOIs by Applicant Name</h2>
            <form method="post" action="#results-section">
                <input type="hidden" name="action" value="list_by_applicant">
                <input type="text" name="first_name" placeholder="First Name">
                <input type="text" name="last_name" placeholder="Last Name">
                <?php echo getSortFormInputs($sort_field, $sort_order); ?>
                <input type="submit" value="Search">
            </form>
        </div>
        
        <div class="form-section">
            <h2>Delete EOIs by Job Reference Number</h2>
            <form method="post" action="#results-section" onsubmit="return confirm('Are you sure you want to delete all EOIs with this job reference number?');">
                <input type="hidden" name="action" value="delete_by_job">
                <input type="text" name="job_ref" placeholder="Job Reference Number" pattern="[A-Za-z]{2}[0-9]{2,3}" title="2 letters followed by 2-3 digits (e.g., DB01, AB123)" required>
                <input type="submit" value="Delete">
            </form>
        </div>
        
        <div class="form-section">
            <h2>Change EOI Status</h2>
            <form method="post" action="#results-section">
                <input type="hidden" name="action" value="change_status">
                <input type="text" name="eoi_id" placeholder="EOI ID" required>
                <select name="new_status" required>
                    <option value="">Select Status</option>
                    <option value="New">New</option>
                    <option value="Current">Current</option>
                    <option value="Final">Final</option>
                </select>
                <input type="submit" value="Update Status">
            </form>
        </div>
        
        <?php if (!empty($results) || ($editing && $edit_eoi)): ?>
            <div class="results-header" id="results-section">
                <h2 id="results"><?php echo $editing ? "Edit EOI #" . $edit_eoi['id'] : "Search Results (Click on the titles in the table to sort in order)"; ?></h2>
                <?php if (!empty($message)): ?>
                    <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <?php if (!$editing): ?>
                <div class="edit-eoi-form">
                    <form method="post" action="#results-section">
                        <input type="hidden" name="action" value="edit_eoi">
                        <input type="hidden" name="sort_field" value="<?php echo $sort_field; ?>">
                        <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>">
                        <input type="text" name="eoi_id" placeholder="Enter EOI ID to edit info" required>
                        <input type="submit" value="Edit">
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><?php 
                                // Create additional parameters array based on current action
                                $params = [];
                                if ($action == 'list_by_job' && !empty($_POST['job_ref'])) {
                                    $params['job_ref'] = $_POST['job_ref'];
                                } elseif ($action == 'list_by_applicant') {
                                    $params['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
                                    $params['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
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
                            <th>Skills</th>
                            <th><?php echo getSortableHeaderLink('status', 'Status', $sort_field, $sort_order, $action, $params); ?></th>
                        </tr>
                    </thead>
                    <tbody>
    <?php 
    if ($editing && $edit_eoi) {
        // Only show the row being edited
        $eoi = $edit_eoi;
    ?>
        <tr>
            <form method="post" action="#results-section" id="edit-form">
                <td><?php echo htmlspecialchars($eoi['id']); ?></td>
                <td><input type="text" name="job_reference" 
value="<?php echo htmlspecialchars($eoi['job_reference']); ?>" 
pattern="[A-Za-z]{2}[0-9]{2,3}" 
title="2 letters followed by 2-3 digits (e.g., DB01, AB123)"
required></td>
                <td><input type="text" name="first_name" value="<?php echo htmlspecialchars($eoi['first_name']); ?>" required></td>
                <td><input type="text" name="last_name" value="<?php echo htmlspecialchars($eoi['last_name']); ?>" required></td>
                <td><input type="text" name="street_address" value="<?php echo htmlspecialchars($eoi['street_address']); ?>" required></td>
                <td><input type="text" name="suburb" value="<?php echo htmlspecialchars($eoi['suburb']); ?>" required></td>
                <td>
                    <select name="state" required>
                        <?php $states = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
                        foreach ($states as $state): ?>
                            <option value="<?php echo $state; ?>" <?php echo $eoi['state'] == $state ? 'selected' : ''; ?>><?php echo $state; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" name="postcode" value="<?php echo htmlspecialchars($eoi['postcode']); ?>" pattern="[0-9]{4}" required></td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($eoi['email']); ?>" required></td>
                <td><input type="text" name="phone" value="<?php echo htmlspecialchars($eoi['phone']); ?>" required></td>
                <td>
                    <input type="text" name="skills" value="<?php 
                        // Convert skills array to comma-separated string
                        if (!empty($eoi['skills'])) {
                            echo htmlspecialchars(implode(', ', $eoi['skills']));
                        }
                    ?>" placeholder="Skills (comma separated)">
                    <br>
                    <input type="text" name="other_skills" value="<?php echo htmlspecialchars($eoi['other_skills']); ?>" placeholder="Other Skills">
                </td>
                <td>
                    <select name="status" required>
                        <?php $statuses = ['New', 'Current', 'Final'];
                        foreach ($statuses as $status): ?>
                            <option value="<?php echo $status; ?>" <?php echo $eoi['status'] == $status ? 'selected' : ''; ?>><?php echo $status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <input type="hidden" name="action" value="update_eoi">
                <input type="hidden" name="eoi_id" value="<?php echo htmlspecialchars($eoi['id']); ?>">
                <input type="hidden" name="sort_field" value="<?php echo $sort_field; ?>">
                <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>">
            </form>
        </tr>
    <?php 
    } else {
        // Show all results
        foreach ($results as $eoi):
    ?>
        <tr <?php echo $updated_status_id && $eoi['id'] == $updated_status_id ? 'class="highlight-row"' : ''; ?>>
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
            <td><?php 
                $all_skills = [];
                
                // Add skills from EOI_Skills table
                if (!empty($eoi['skills'])) {
                    $all_skills = $eoi['skills'];
                }
                
                // Add other skills if present
                if (!empty($eoi['other_skills'])) {
                    $all_skills[] = $eoi['other_skills'];
                }
                
                echo htmlspecialchars(implode(', ', $all_skills)); 
            ?></td>
            <td><?php echo htmlspecialchars($eoi['status']); ?></td>
        </tr>
    <?php 
        endforeach;
    }
    ?>
</tbody>
                </table>
            </div>
            <?php if ($editing && $edit_eoi): ?>
                <div class="save-button-container">
                    <input type="submit" form="edit-form" value="Save Changes" class="save-button">
                    <form method="post" action="#results-section" style="display: inline;">
                        <input type="hidden" name="action" value="list_all">
                        <input type="hidden" name="sort_field" value="<?php echo $sort_field; ?>">
                        <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>">
                        <input type="submit" value="Cancel" class="cancel-button">
                    </form>
                </div>
            <?php endif; ?>
        <?php elseif ($action && empty($message) && !($editing && $edit_eoi)): ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
    
    <?php include("footer.inc")?>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//block direct link access, redirect to apply page instead
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: apply.php"); 
    exit();
}
/////Data sanitize and format/////
//
function sanitise_input($data){
    $data = trim($data);
    $data = ucfirst($data);
    $data = htmlspecialchars($data);
    return $data;
}
function var_input($formdata){
    if (isset($_POST[$formdata])) {
        
        return sanitise_input($_POST[$formdata]);;
    } else {
        header("location: apply.php");
        exit();
    }
}

//////////////////-----EXTRACT DATA-----////////////////////////////////////
    $job_num = var_input("job_num");
    $fname = var_input("fname");
    $lname = var_input("lname");

    if (isset($_POST["gender"])){
       
            if ($_POST["gender"]=="male") $gender = "Male";
            if ($_POST["gender"]=="female") $gender = "Female";
            if ($_POST["gender"]=="other") $gender = "Other";
    } else {
        header("location: apply.php");
        exit();
    }

    $dob = var_input("dob");
    $street = var_input("str_address");
    $town = var_input("town");
    $state = var_input("state");
    $postcode = var_input("postcode");
    $email = var_input("email");
    $phone = var_input("phone");
    $otherskill = var_input("otherdes");
    if (isset($_POST["skill"])){
        $skills = $_POST["skill"];      //skill[] is an array in html form
    } else {
        header("location: apply.php");
        exit();
    }
    $status = "New";
//////////////////////////////////////////////////////////////////////
echo "<pre>";
print_r($_POST);
echo "</pre>";
////////////////------VALIDATE DATA-----/////////////////////////////
$errmsg = [];   //store error message
//job ref num e.g: DB123  (5 alphanumeric in total)
if (!preg_match('/^[A-Z]{2}\d{3}$/', $job_num)) {
    $errmsg[] .= "Invalid job reference number (must be 2 uppercase letters followed by 3 digits, e.g., AB123).";
    echo"jobnum";
}
//first name & last name: max 20 alpha chars
if (!preg_match('/^[a-zA-Z]{2,20}$/', $fname)) {
    $errmsg[] .= "First name must be 2-20 letters.";
    echo"fname";
}
if (!preg_match('/^[a-zA-Z]{2,20}$/', $lname)) {
    $errmsg[] .= "Last name must be 2-20 letters.";
    echo"lname";
}
// Validate format: dd/mm/yyyy
if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
    $errmsg[] = "Date of birth must be in dd/mm/yyyy format.";
} else {
    $dob_parts = explode('/', $dob);
    if (count($dob_parts) == 3) {
        $dob_day = $dob_parts[0];
        $dob_month = $dob_parts[1];
        $dob_year = $dob_parts[2];

        // Ensure inputs are digits
        if (!ctype_digit($dob_year) || !ctype_digit($dob_month) || !ctype_digit($dob_day)) {
            $errmsg[] = "Invalid date format.";
        } else {
            // Convert to DateTime object
            $dob = DateTime::createFromFormat("d/m/Y", "$dob_day/$dob_month/$dob_year");

            // Ensure date is valid (handles leap years)
            if (!$dob || $dob->format('d') != $dob_day || $dob->format('m') != $dob_month || $dob->format('Y') != $dob_year) {
                $errmsg[] = "Invalid date of birth.";
            } else {
                $today = new DateTime();
                $age = $today->diff($dob)->y;
                $dob_this_year = new DateTime($today->format('Y') . "-$dob_month-$dob_day");

                $min_age = 15;
                $max_age = 80;

                // Handle people turning 15 today or in the next few days
                if ($age < $min_age || ($age == $min_age && $dob_this_year > $today)) {
                    $errmsg[] = "You must be at least 15 years old.";
                }
                // Handle people turning 81 tomorrow or in the next few days
                elseif ($age > $max_age || ($age == $max_age && $dob_this_year < $today)) {
                    $errmsg[] = "You must be younger than 80 years old.";
                }
            }
        }
    }
}


//Gender
if (!in_array($gender, ['Male', 'Female', 'Other'])) {
    $errmsg[] .= "Invalid gender selection.";
}
//street & town max 40 alpha char
if (!preg_match('/^[a-zA-Z0-9, ]{1,40}$/', $street)) {
    $errmsg[] .= "Street address must be 1-40 characters long (letters, numbers, comma).";
}
if (!preg_match('/^[a-zA-Z0-9, ]{1,40}$/', $town)) {
    $errmsg[] .= "Suburb/Town must be 1-40 characters.";
}
//state One of VIC(3000, 8000), NSW(1000), QLD(4000, 9000), NT,WA(6000),SA(5000),TAS,ACT(0200)
$valid_states = ['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'];
if (!in_array($state, $valid_states)) {
    $errmsg[] .= "Invalid state: $state";
}
//post code exactly 4 digits, matches state 
$state_postcode_ranges = [
    'NSW' => [['1000', '1999'], ['2000', '2599'], ['2619', '2899'], ['2921', '2999']],
    'VIC' => [['3000', '3996'], ['8000', '8999']],
    'QLD' => [['4000', '4999'], ['9000', '9999']],
    'SA'  => [['5000', '5999']],
    'WA'  => [['6000', '6797'], ['6800', '6999']],
    'TAS' => [['7000', '7999']],
    'ACT' => [['0200', '0299'], ['2600', '2618'], ['2900', '2920']],
    'NT'  => [['0800', '0999']]
];      //postcode data taken from wikipedia
if (!preg_match('/^\d{4}$/', $postcode)) {
    $errmsg[] = "Postcode must be exactly 4 digits.";
} elseif (!isset($state_postcode_ranges[$state])){
    $errmsg[] .= "Postcode requied for $state";
} else { 
    $valid_postcode = false;
    foreach ($state_postcode_ranges[$state] as $range) {
        if ($postcode >= $range[0] && $postcode <= $range[1]) {
            $valid_postcode = true;
            break; // Stop checking further, it's valid
        }
    }
    if (!$valid_postcode) {
        $errmsg[] = "Invalid postcode $postcode for $state.";
    }
}
//email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errmsg[] .= "Invalid email format.";
}
//phone 8-12 or spaces
if (!preg_match('/^(\d[-\s]?){7,11}\d$/', $phone)) {
    $errmsg[] .= "Phone number must be 8-12 digits.";
}

//other skills

if (!empty($errmsg)) {
    foreach ($errmsg as $errmsg) {
        echo "<p style='color:red;'>$errmsg</p>";
    }
    exit; // Stop execution if there are errors
}
//////////////////////////////////////////////////////////////////


// If no errors, process the data (e.g., save to database)
echo "<p style='color:green;'>Form submitted successfully!</p>";
///////////////////////-----table exist(?)-----//////////////////////////
require_once "settings.php";
$dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
$checkTable = "SHOW TABLES LIKE 'EOI'";
$result = $dbconn->query($checkTable);


////////////////////////////////////////////////////////////////////////////////

////////////////////////-----PREPARED STATEMENT FOR DATA INSERTION-----///////////////
//in prepared statement, SQL treats user input as data, not part of the query, => prevent SQL injection and syntax error, boost process speed (not really)
//so it is recommended that we use this approach instead of regular queries

if ($dbconn){
    //Prepare SQL statement
    $insertEOI = "INSERT INTO EOI (JobReferenceNumber, FirstName, LastName, BirthDate, BirthMonth, BirthYear, Gender, StreetAddress, TownOrSuburbs, State, Postcode, Email, PhoneNumber, OtherSkills, Status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statementEOI = mysqli_prepare($dbconn, $insertEOI);
    if (!$statementEOI) {
        die("Preparation failed: " . mysqli_error($dbconn));
    }

    //Bind parameters
    mysqli_stmt_bind_param($statementEOI, "sssssssssssssss",
        $job_num, $fname, $lname, $dob_day, $dob_month, $dob_year, 
        $gender, $street, $town, $state, $postcode, $email, $phone, $otherskill, $status);

    //execute
    if (!mysqli_stmt_execute($statementEOI)) {
        die("Execution failed: " . mysqli_stmt_error($statementEOI));
    }
    
    // Get the auto-generated EOI id for the inserted record
    $eoi_id = mysqli_insert_id($dbconn);
    mysqli_stmt_close($statementEOI);

    if (!$eoi_id) {
        die("Error: Could not retrieve EOInumber.");
    }
    echo "Newly inserted EOInumber: $eoi_id<br>";

    $insertSkill = "INSERT INTO EOI_Skills (EOInumber, Skills)
                    VALUES (?, ?)";
    $stmtSkill = mysqli_prepare($dbconn, $insertSkill);
    if (!$stmtSkill) {
        die ("Skill statement prep failed: " . mysqli_error($dbconn));
    }
    // Loop through the skills array and bind & execute for each skill.
    foreach ($skills as $skill){
        if (!is_string($skill)) {
            die("Error: Skill value is not a string: " . var_export($skill, true));
        }
    
        if (!mysqli_stmt_bind_param($stmtSkill, "is", $eoi_id, $skill)) {
            die("Binding failed for skill ($skill): " . mysqli_stmt_error($stmtSkill));
        }
        
        if (!mysqli_stmt_execute($stmtSkill)) {
            die("Execution failed for skill ($skill): " . mysqli_stmt_error($stmtSkill));
        }
        echo "Inserted skill: $skill<br>"; // Debugging
    }

} else {die("Connection failed: " );}

?>
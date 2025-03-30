-- Create table
CREATE TABLE EOI (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobReferenceNumber varchar(5),
    FirstName varchar(20),
    LastName varchar(20),
    BirthDate varchar(2),
    BirthMonth varchar(2),
    BirthYear varchar(4),
    Gender ENUM('Male', 'Female', 'Other'),
    StreetAddress varchar(40),
    TownOrSuburbs varchar(40),
    State varchar(20),
    Postcode varchar(4),
    Email varchar(255),
    PhoneNumber varchar(12),
    OtherSkills TEXT,
    Status ENUM('New', 'Current', 'Final') DEFAULT 'New'
);


-- Sample data for local testing, only put in after create table
CREATE TABLE EOI_Skills (
    EOInumber INT,
    Skills VARCHAR(50),
    FOREIGN KEY (EOInumber) REFERENCES EOI (EOInumber) ON DELETE CASCADE
);

INSERT INTO EOI (JobReferenceNumber, FirstName, LastName, BirthDate, BirthMonth, BirthYear, Gender, 
    StreetAddress, TownOrSuburbs, State, Postcode, Email, PhoneNumber, OtherSkills, Status) 
VALUES 
    ('DB01', 'John', 'Smith', '15', '03', '1990', 'Male', '123 Main Street', 'Melbourne', 'VIC', '3000', 
    'john.smith@email.com', '0412345678', 'Project Management, Leadership', 'New'),
    
    ('DB02', 'Sarah', 'Johnson', '22', '07', '1995', 'Female', '456 High Street', 'Sydney', 'NSW', '2000',
    'sarah.j@email.com', '0423456789', 'Communication, Problem Solving', 'Current'),
    
    ('DB03', 'Alex', 'Wong', '30', '11', '1988', 'Other', '789 Park Road', 'Brisbane', 'QLD', '4000',
    'alex.w@email.com', '0434567890', 'Team Building, Agile Methodologies', 'Final');

INSERT INTO EOI_Skills (EOInumber, Skills) 
VALUES 
    (1, 'Java'),
    (1, 'Python'),
    (1, 'SQL'),
    (2, 'JavaScript'),
    (2, 'HTML'),
    (2, 'CSS'),
    (3, 'PHP'),
    (3, 'MySQL'),
    (3, 'React');
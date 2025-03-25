-- ENTER ALL OF THIS INTO THE SQL TAB IN PHPMYADMIN
-- Create the EOI table
CREATE TABLE IF NOT EXISTS EOI (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobReferenceNumber VARCHAR(10) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    BirthDate VARCHAR(2) NOT NULL,
    BirthMonth VARCHAR(2) NOT NULL,
    BirthYear VARCHAR(4) NOT NULL,
    Gender VARCHAR(10) NOT NULL,
    StreetAddress VARCHAR(100) NOT NULL,
    TownOrSuburbs VARCHAR(50) NOT NULL,
    State VARCHAR(3) NOT NULL,
    Postcode VARCHAR(4) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    OtherSkills TEXT,
    Status VARCHAR(20) DEFAULT 'New' NOT NULL
);

-- Create the EOI_Skills table
CREATE TABLE IF NOT EXISTS EOI_Skills (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    EOInumber INT NOT NULL,
    Skills VARCHAR(50) NOT NULL,
    FOREIGN KEY (EOInumber) REFERENCES EOI(EOInumber)
);

-- Insert sample data for testing
INSERT INTO EOI (JobReferenceNumber, FirstName, LastName, BirthDate, BirthMonth, BirthYear, Gender, StreetAddress, TownOrSuburbs, State, Postcode, Email, PhoneNumber, OtherSkills, Status)
VALUES
('AB123', 'John', 'Doe', '15', '05', '1985', 'Male', '123 Main St', 'Brisbane', 'QLD', '4000', 'john@example.com', '0400123456', 'Leadership, Communication', 'New'),
('CD456', 'Jane', 'Smith', '21', '08', '1990', 'Female', '456 Park Ave', 'Sydney', 'NSW', '2000', 'jane@example.com', '0400654321', 'Project Management', 'Current'),
('EF789', 'Bob', 'Johnson', '03', '12', '1988', 'Male', '789 Beach Rd', 'Melbourne', 'VIC', '3000', 'bob@example.com', '0401234567', 'Problem Solving', 'Final'),
('AB123', 'Alice', 'Wilson', '27', '04', '1992', 'Female', '321 Hill St', 'Adelaide', 'SA', '5000', 'alice@example.com', '0412345678', 'Time Management', 'New'),
('CD456', 'Michael', 'Brown', '10', '11', '1980', 'Male', '654 Lake Dr', 'Perth', 'WA', '6000', 'michael@example.com', '0423456789', 'Teamwork', 'Rejected'),
('EF789', 'Sarah', 'Davis', '19', '02', '1993', 'Female', '987 River Rd', 'Hobart', 'TAS', '7000', 'sarah@example.com', '0434567890', 'Critical Thinking', 'Current');

-- Insert skills for sample data
INSERT INTO EOI_Skills (EOInumber, Skills)
VALUES
(1, 'PHP'),
(1, 'JavaScript'),
(2, 'Python'),
(2, 'Java'),
(3, 'C#'),
(3, 'SQL'),
(4, 'HTML'),
(4, 'CSS'),
(5, 'React'),
(5, 'Angular'),
(6, 'Node.js'),
(6, 'MongoDB'); 
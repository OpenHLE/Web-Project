<?php
// PHP version of the about page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="About Us" />
    <meta name="keywords" content="HTML, CSS, PHP" />
    <meta name="author" content="Le Tuan Huy" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/about.css">
    <link rel="stylesheet" href="style/style.css">

    <title>About Us</title>
</head>
<body class="about-page">
    <header class="navbar">   
        <div class="brand">
            <img class="logo" src="images/logo.png" alt="Company Logo">
            <h1>TECHYA</h1>            
        </div>
            
        <nav>
            <ul>
                <li id="home"><a href="index.php">Home</a></li>
                <li id="jobs"><a href="jobs.php">Career</a></li>
                <li id="apply"><a href="apply.php">Apply</a></li>
                <li id="abt"><a href="#" class="active">About</a></li>
                <li id="enhancement"><a href="enhancement.php">Enhance</a></li>
            </ul>
            <span class="nav-highlight"></span>
        </nav>   
    </header>

    <main>
        <!-- Group Information Section -->
        <section class="group-info">
            <h2>About Us</h2>
            <h3>Group Information</h3>
            <div class="info-list">
                <div>
                    <dt>Group Name:</dt>
                    <dd>Group 20</dd>
                    <p>(We don't have a group name)</p>
                </div>

                <div>
                    <dt>Group ID:</dt>
                    <dd>Group 20</dd>
                </div>

                <div>
                    <dt>Tutor's Name:</dt>
                    <dd>Mr. Vu Ngoc Binh</dd>
                </div>

            </div>
        </section>

        <!-- Group Photo Section -->
        <section class="team-photo">
            <h2>Our Team</h2>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="images/logo.png" alt="Team Group Photo" width="600">
                    </div>
                    <div class="flip-card-back">
                    </div>
                </div>
            </div>
            
        </section>

        <section class="scroll-arrow">
            <div id="scroll">
                <p>Scroll down for more info</p>
                <img src="images/ArrowDown.png" alt="Scroll down arrow icon">
            </div>
        </section>

        <!-- Members Contribution Section -->
        <section class="members">
            <h2>Members Contribution</h2>
            <?php
            // Define members data array
            $members = [
                [
                    'name' => 'Trần Minh Hải',
                    'image' => 'images/tmh.jpg',
                    'contributions' => [
                        'Home page (index.php)',
                        'Position Descriptions page (jobs.php)',
                        'Backend Integration',
                        'Database Design'
                    ]
                ],
                [
                    'name' => 'Vũ Huy Chris',
                    'image' => 'images/vhc.jpg',
                    'contributions' => [
                        'Position Descriptions page (jobs.php)',
                        'PHP Form Handling',
                        'User Authentication',
                        'Security Implementation'
                    ]
                ],
                [
                    'name' => 'Nguyễn Đăng Nhật Minh',
                    'image' => 'images/ndnm.jpg',
                    'contributions' => [
                        'Job application page (apply.php)',
                        'Database Connection',
                        'Application Processing',
                        'Email Notifications'
                    ]
                ],
                [
                    'name' => 'Lê Tuấn Huy',
                    'image' => 'images/lth.jpg',
                    'contributions' => [
                        'About page (about.php)',
                        'Responsive Design',
                        'PHP Implementation',
                        'Data Visualization'
                    ]
                ]
            ];
            ?>
            <div class="member-cards">
                <?php foreach ($members as $member): ?>
                <div class="member-flip-card">
                    <div class="member-flip-card-inner">
                        <div class="member-flip-card-front">
                            <img src="<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>">
                        </div>
                        <div class="member-flip-card-back">
                            <h3><?php echo $member['name']; ?></h3>
                            <p>
                                <?php foreach ($member['contributions'] as $contribution): ?>
                                    <b><?php echo $contribution; ?></b><br>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <p>Hover on the images to view more info</p>
        </section>

        <!-- Timetable Section -->
        <section class="timetable">
            <h2>Project Timetable</h2>
            <?php
            // Define timetable data
            $timeSlots = ['Morning', 'Afternoon', 'Evening', 'Night'];
            $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            
            // Define project activities
            $activities = [
                // Format: [day_index][time_slot_index] => activity
                0 => [0 => 'Team Meeting', 1 => 'Backend Dev', 2 => 'Database Design', 3 => 'Code Review'],
                1 => [0 => 'UI Design', 1 => 'Frontend Dev', 2 => 'Testing', 3 => 'Documentation'],
                2 => [0 => 'API Integration', 1 => 'Bug Fixing', 2 => 'Feature Dev', 3 => 'Security Check'],
                3 => [0 => 'Client Meeting', 1 => 'Backend Dev', 2 => 'Database Optimization', 3 => 'Deployment'],
                4 => [0 => 'Sprint Planning', 1 => 'Frontend Dev', 2 => 'Testing', 3 => 'Performance Tuning'],
                5 => [0 => 'Code Review', 1 => 'Bug Fixing', 2 => 'Feature Dev', 3 => 'Security Update'],
                6 => [0 => 'Team Meeting', 1 => 'Integration', 2 => 'Testing', 3 => 'Deployment']
            ];
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <?php foreach ($daysOfWeek as $day): ?>
                            <th><?php echo $day; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($timeSlots as $index => $timeSlot): ?>
                        <tr>
                            <td><?php echo $timeSlot; ?></td>
                            <?php foreach ($daysOfWeek as $dayIndex => $day): ?>
                                <td><?php echo $activities[$dayIndex][$index]; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Our team's weekly development schedule</p>
        </section>
    </main>

    <footer>
         <div class="brandfooter">
            <img class="logo" src="images/logo.png" alt="Company Logo">
            <h1>TECHYA</h1>            
        </div>
        
        <p class="contact">Contact us:
            <br>
            <a href="https://youtube.com/"><img src="images/youtube-logo.png" alt="YouTube"></a>
            <a href="https://github.com/OpenHLE/Web-Project"><img src="images/github-logo.png" alt="GitHub"></a>
            <a href="mailto:105550542@student.swin.edu.au"><img src="images/mail-logo.png" alt="Email"></a>
        </p>
        <div class="location">
            <p>Our location:</p>
            
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.042153278479!2d105.78157517829588!3d21.03099928045221!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135bfa667a7dee9%3A0x2ac9ba5f99e4f389!2sSwinburne%20Innovation%20Space!5e0!3m2!1svi!2s!4v1740037300397!5m2!1svi!2s" width="200" height="150" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <p class="copyright">&copy; <?php echo date('Y'); ?> TECHYA. All rights reserved.</p>
    </footer>

    <script>
        // Fix for navbar highlight
        document.addEventListener("DOMContentLoaded", function() {
            const navItems = document.querySelectorAll('nav ul li');
            const highlight = document.querySelector('.nav-highlight');
            
            // Set initial position for About page
            highlight.style.transform = "translateX(317px)";
            highlight.style.width = "80px";
            
            // Add hover event listeners
            navItems.forEach((item, index) => {
                item.addEventListener('mouseenter', function() {
                    switch(index) {
                        case 0: // Home
                            highlight.style.transform = "translateX(0)";
                            highlight.style.width = "85px";
                            break;
                        case 1: // Career
                            highlight.style.transform = "translateX(107px)";
                            highlight.style.width = "85px";
                            break;
                        case 2: // Apply
                            highlight.style.transform = "translateX(210px)";
                            highlight.style.width = "85px";
                            break;
                        case 3: // About
                            highlight.style.transform = "translateX(317px)";
                            highlight.style.width = "80px";
                            break;
                        case 4: // Enhance
                            highlight.style.transform = "translateX(427px)";
                            highlight.style.width = "85px";
                            break;
                    }
                });
                
                // Return to default position when mouse leaves the navbar
                item.addEventListener('mouseleave', function() {
                    // Small delay to prevent flickering during transitions between items
                    setTimeout(() => {
                        if (!navItems.some(li => li.matches(':hover'))) {
                            highlight.style.transform = "translateX(317px)";
                            highlight.style.width = "80px";
                        }
                    }, 50);
                });
            });
        });
    </script>
</body>
</html>

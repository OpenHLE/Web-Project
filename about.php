<?php
// PHP version of the about page
// Set current page for navbar highlighting
$currentPage = "about";
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
<body class="<?php echo $currentPage; ?>-page">
    <?php include("header.inc") ?>

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
                        '- Home page (index.php)',
                        '- Position Descriptions page (jobs.php)',
                        '- Enhancement Page',
                        '- SQL Database',
                    ]
                ],
                [
                    'name' => 'Vũ Huy Chris',
                    'image' => 'images/vhc.jpg',
                    'contributions' => [
                        '- Position Descriptions page (jobs.php)',
                        '- Enhancement Page',
                        '- SQL Database',
                    ]
                ],
                [
                    'name' => 'Nguyễn Đăng Nhật Minh',
                    'image' => 'images/ndnm.jpg',
                    'contributions' => [
                        '- Job application page (apply.php)',
                        '- Improved Header and Footer',
                    ]
                ],
                [
                    'name' => 'Lê Tuấn Huy',
                    'image' => 'images/lth.jpg',
                    'contributions' => [
                        '- About page (about.php)',
                        '- Responsive Design',
                        '- Data Management (manage.php)',
                        '- PHP Enhancement'
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

    <?php include("footer.inc")?>
</body>
</html>
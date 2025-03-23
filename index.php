<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Job Application" />
    <meta name="keywords" content="HTML5, CSS"/>
    <meta name="author" content="TranMinhHai"  />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!--responsive website-->
    <title>Home - TECHYA</title>
    <link href="style/style.css" rel="stylesheet"/>
    <link href="style/index.css" rel="stylesheet"/>
</head>
<!------------------------------------------------------------------------>
<body>
    <?php include("header.inc") ?>
<!--------------------------------------------------------------------->
    <section class="hero">
        <div class="herobg"></div>
        <div class="herocontent">
            <h1>TECHYA</h1>
            <h2>The best tool for self-education</h2>
            <p>You want certifications to brighten up your CV? We can provide the best courses to assist your jouney!</p>
        </div>
        <div id="scroll">
            <p>Scroll down for more info</p>
            <img src="images/ArrowDown.png" alt="Pls scroll down">
        </div>
    </section>
<!--------------------------------------------------------------------->
    <div class="container">
        <section>
            <article class="box" id="introbox">
                <h3>Introduction</h3>
                <p>With professional Lecturer and Course Designers, we are proud to be one of the best education website on the internet.
                    No matter where your starting point is, hard work will be paid off. Start your Learning Journey with us right now!</p>

            </article>
        </section>
        <section>
            <article class="box" id="missionbox">
                <h3>Our Mission</h3>
                <p>We aim to develop the IT job market, create promising future for CS students. And big things can not happen without dedicated learners</p>
            </article>
        </section>
        <section class="box" id="featuresbox">

                <h3>Features</h3>
                <ul>
                    <li>Professional course designs.</li>
                    <li>Real-life experience from seniors.</li>
                    <li>Hands-on coding project.</li>
                    <li>Practice tests for every certification.</li>
                </ul>
            
        </section>
    </div>
<!--------------------------------------------------------------------->
    <?php include("footer.inc")?>
</body>
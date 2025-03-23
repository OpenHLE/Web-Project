
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Job Description" />
    <meta name="keywords" content="HTML, tags, CSS, Javascript, PHP" />
    <meta name="author" content="TranMinhHai"  />
    <title>Career</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!--responsive website-->
    <link href="style/style.css" rel="stylesheet"/>
    <link href="style/jobs.css" rel="stylesheet"/>
</head>

<body>
    <?php include("header.inc") ?>

    <main>
        
        <section class="careers">
            <h2>CAREERS</h2>
          
            <div class="jobslist">
            
            <input type="checkbox" id="toggle-filters" />
            <label for="toggle-filters" class="filter-icon">
                <img src="images/filter-icon.png" alt="Filter Icon" />
            </label>
              
           
            <input type="checkbox" id="filter-frontend" checked />
            <label for="filter-frontend">Frontend</label>
          
            <input type="checkbox" id="filter-backend" checked />
            <label for="filter-backend">Backend</label>
          
            <input type="checkbox" id="filter-data" checked />
            <label for="filter-data">Data</label>
          
            <input type="checkbox" id="filter-support" checked />
            <label for="filter-support">Support</label>
          
            <!-- Job Listings Table -->
            <table class="jobs-table">
                <thead>
                    <tr>
                        <th>Available</th>
                        <th>Location</th>
                        <th>Info</th>
                        <th>Apply</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr class="frontend" data-info="ID: FD647">
                        <td>Frontend Developer</td>
                        <td>Hanoi</td>
                        <td><a href="jobs3.html">Info</a></td>
                        <td><a href="apply.html">Apply</a></td>
                    </tr>

                    <tr class="backend" data-info="ID: BD137">
                        <td>Backend Developer</td>
                        <td>Hanoi</td>
                        <td><a href="jobs4.html">Info</a></td>
                        <td><a href="apply.html">Apply</a></td>
                    </tr>
                
                    <tr class="data" data-info="ID: DM153">
                        <td>Database Administrator</td>
                        <td>Hanoi</td>
                        <td><a href="jobs1.html">Info</a></td>
                        <td><a href="apply.html">Apply</a></td>
                    </tr>

                    <tr class="support" data-info="ID: IS765">
                        <td>IT Support</td>
                        <td>Hanoi</td>
                        <td><a href="jobs2.html">Info</a></td>
                        <td><a href="apply.html">Apply</a></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </section>

    </main>

    <!--------------------------------------------------------------------->
    <?php include("footer.inc")?>
</body>





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Job Description" />
    <meta name="keywords" content="HTML, tags, CSS, Javascript, PHP" />
    <meta name="author" content="TranMinhHai"  />
    <title>Enchancement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!--responsive website-->
    <link href="style/style.css" rel="stylesheet"/>
    <link href="style/enhancement.css" rel="stylesheet"/>
</head>

<body>
    <?php include("header.inc") ?>

<h2 id="e1">Glossary</h2>

<p id="gl1"><a href="#e2">Header: Navigation Bar</a></p>
<p id="gl2"><a href="#e3">Career: Filtering and Page Branching</a> </p>
<p id="gl3"><a href="#e4">About: Flip Cards</a> </p>
<p id="gl4"><a href="#e5">Responsive Design</a></p>
<p id="gl5"><a href="#e6">Glossary</a></p>
<p id="gl6"><a href="#e7">Map</a></p>
<p id="gl7"><a href="#e8">Jobs Search</a></p>
<p id="gl8"><a href="#e9">Autofill, Auto Refill and Error Messages</a></p>
<p id="gl9"><a href="#e10">Table Sorting and Update</a></p>
<br><hr><br>
<!------------------------------------------------------------------------->

<section id="e2">
<h2 >Header: Navigation Bar</h2>
<img src="images/Navbar.png" alt="Navbar">
<article>
    <h3>How It Functions:</h3>
<p>The Header, other than the Company title and image, includes 5 words/tags called "Home", "Career", "Apply", "About", "Enhance" representing the 5 main pages/htmls. There will be a red rounded rectangular boxes that indicates which page the user is on by default, and when the user hover to other tags, the box will follow the mouse and highlight it. If the user didn't click on any tags and unhover(the mouse leaving the area of the tags), the box will naturally return to its default position (based on the page the user is on). On the other hand, if the user did click on any other tags, the box will be affixed to the tag as it transitions to that page.</p>
    <h3>How It Enhances:</h3>
<p>Greattly improve user's experience by clearly indicating which page they are currently on. Not only that, smooth transitions when hovering over each tab really soothe people's eyes.</p>
    <h3>Code:</h3>
    <img src="images/NavbarCode1.png" alt="Navbar code">
    <p>The HTML empty li tag is used for colouring the background under an element in the list.</p>
    <img src="images/NavbarCode2.png" alt="Navbar code">
    <p>When a list's child is hovered, it's direct sibling (the li tag id nav-highlight) will move accordingly. The last part of the code diverses between each page because it is used to determined the position of the highlight.</p>
    <h3>Key Usages:</h3>
    <p> Hovering; combinators (~) for subsequent-sibling; and animations</p>
    <h3>Link: <a id="linki" href="index.html">Here</a></h3>
    <p>Back to: <a href="#e1">Glossary</a></p>
</article>
</section>
<br><hr><br>
<!------------------------------------------------------------------------->

<section id="e3">
    <h2 >Career: Filtering and Page Branching</h2>
    <p>Before filtering:</p>
    <img src="images/Filter.png" alt="filter pic">
    <p>After:</p>
    <img src="images/Filter1.png" alt="filter pic">
    <article>
        <h3>How It Functions:</h3>
        <p>On The Career Page, there are two functions that we consider as enhancement, called a Filter (For Jobs) and Page Branching (For Info)</p>
        
        <h3>How It Enhances:</h3>
        <p>The main career page now only shows a list of Available jobs instead of huge chunks of jobs information. Each element of the list contains jobs name, location, info (which links to the info page of the chosen job), and apply (direct link to apply page). Upon hovering on each job, it slightly scales up and blurs out other jobs for better concentration; moreover, job reference number is also displayed next to apply link in case they really want the job and apply at first sight.</p>
        <p>Another great function is filtering. The filter icon when pressed will display the current preferred jobs. Checking or un-checking the box correlated to each job preference will displayed the chosen job.
        </p>
        <h3>Code:</h3>
        <h4>The filter icon:</h4>
        <p>It is actually a checkbox with input box hidden. When clicked, the status of the checkbox is turned to (:checked) and shows their siblings (other checkboxes and labels for categories) through combinator (~) </p>
        <img src="images/FilterCode1.png" alt="filter code">
        <h4>The Filtering logic:</h4>
        <p>Each category checkbox and a table row has a unique id (backend, frontend, data,...) When a category is checked/unchecked, its direct sibling (the table) and the table's child (each tagged row) will react accordingly through combinators (susequent siblings and descendant)</p>
        <img src="images/FilterCode2.png" alt="filter code">
        <p>Uses of subsequent-sibling combinators for both the fliter button and filtering logic force most of the HTML elements in careers class to be direct siblings (the table, category checkboxes and labels, and filter icon (acheckbox)).</p>
        <h3>Key Usages:</h3>
        <p>CSS :checked and :not Pseudo-class; Descendant combinators (space); subsequent-sibling combinators (~)</p>
        <h3 >Link: <a href="jobs.html" id="linki">Here</a></h3>
        <p>Back to: <a href="#e1">Glossary</a></p>       
    </article>
</section>
<br><hr><br>
<!------------------------------------------------------------------------->

<section id="e4">
<h2 >About: Flip Cards</h2>
<p>Demonstration:</p>
<img src="images/hover1.png" alt="flipcard">
<img src="images/hover2.png" alt="flipcard">
<article>
    <h3>How It Functions:</h3>
    <p>When a flipcard is hovered on, it does a flipping animation and shows information on the rear surface.</p>
    <h3>How It Enhances:</h3>
    <p>It makes the webpage more stylish and dynamic, it also saves more spaces so that more elements can be displayed on the webpage.</p>
    <h3>Code:</h3>
    <p>Inspired by W3Schools. Everything about the flipcard animation is explained with comments within the code.</p>
    <img src="images/flipcard1.png" alt="flipcard">
    <img src="images/flipcard2.png" alt="flipcard">
    <h3>Key Usages:</h3>
    <p>Hover trigger and flipping animation (transform); 3D perspective for flipcard (perspective); 3D smooth animation (transform-style, transition).</p>
    <h3>Link:  <a href="about.html" id="linki">Here</a></h3>
    <p>Back to: <a href="#e1">Glossary</a></p>
</article>
</section>
<br><hr><br>
<!------------------------------------------------------------------------->

<section id="e5">
<h2>Responsive Design</h2>
<p>Demonstration:</p>
<img src="images/resize1.png" alt="flipcard">
<img src="images/resize2.png" alt="flipcard">
<article>
    <h3>How It Functions:</h3>
    <p>When the web browser window is resized, the webpages automatically resize and re-align their elements themselves to fit in and display on the web browser window properly.</p>
    <h3>How It Enhances:</h3>
    <p>It helps the webpages to be more dynamic and better for multi-tasking and compatible with many different devices with diffrent screen size and aspect ratio.</p>
    <h3>Code:</h3>
    <p>CSS rules and properties will change according to the size set in "@media screen and (max/min-width: )"</p>
    <img src="images/responsive.png" alt="responsive">
    <h3>Key Usages:</h3>
    <p>Flexible layouts, responive navigation/content.</p>
    <h3>Link:  <a href="" id="linki">Here</a></h3>  
    <p>Back to: <a href="#e1">Glossary</a></p>  
</article>
</section>
<br><hr><br>
<!------------------------------------------------------------------------->

<section id="e6">
    <h2 >Glossary</h2>
    <article>
    <img src="images/Glossary.png" alt="Glossary">
        <h3>How It Functions:</h3>
    <p>As it names implies, this enhancement contains entries' titles of different enhancements that will be reported in the page, each encased in stadium shape box. Upon hover, the box will turn color to indicate hover that when clicked, will teleport the user to the beginning of the entry clicked.</p>
    <img src="images/GlossaryHover.png" alt="Glossary hover">    
        <h3>How It Enhances:</h3>
    <p>It allows the user to quickly navigate to any entries at the beginning of the page. Additionally, there's also a link back to it at the end of every article to allow user for much easier navigation.</p>
        <h3>Code:</h3>
    <img src="images/GlossaryCode1.png" alt="Glossary code">
    <p>This part allows the letter to be displayed and link with sections using href and sections' ids.</p>
    <img src="images/GlossaryCode2.png" alt="Glossary code">
    <p>These are the settings that help create the stadium (box-radius) boxes that encased the text, alongside settings that makes every part of the box link-able.</p>
    <img src="images/GlossaryCode3.png" alt="Glossary code">
    <img src="images/GlossaryCode4.png" alt="Glossary code">
    <p>These are settings that allow the hover to kickstart animation that indicates the action.</p>
        <h3>Key Usages:</h3>
        <h3>Link:  <a href="#e1" id="linki">Here</a></h3>  
        <p>Back to: <a href="#e1">Glossary</a></p>  
    </article>
</section>
<br><hr><br>
<!-------------------------------------------------------------------------------->

<section id="e7">
    <h2 >Footer: Map</h2>
    <article>
        <img src="images/Map.png" alt="map pic">
        <h3>How It Functions:</h3>
    <p>It simply shows the map (or location of the campus on Google Map)</p>
        
        <h3>How It Enhances:</h3>
    <p>Shows the physical location of a place, pressed on will direct users to Google Map with this point pinned.</p>
        <h3>Code:</h3>
        <img src="images/MapCode.png" alt="map code">
        <h3>Key Usages:</h3>
        <p>HTML iframe tag (not covered in lectures)</p>
        <h3>Link:  <a href="#footershowcase" id="linki">Here</a></h3>  
        <p>Back to: <a href="#e1">Glossary</a></p>  
    </article>
</section>

<!-------------------------------------------------------------------------------->

<section id="e8">
    <h2 >Jobs Search</h2>
    <article>
        <img src="images/" alt="Search Job pic">
        <h3>How It Functions:</h3>
    <p>...</p>
    <!---May enter more details on the code part-->
        <h3>How It Enhances:</h3>
    <p>...</p>
        <h3>Code:</h3>
        <img src="images/" alt="">
    <p>...</p>
        <h3>Key Usages:</h3>
    <p>...</p>
        <h3>Link:  <a href="" id="linki">Here</a></h3>  
        <p>Back to: <a href="#e1">Glossary</a></p>  
    </article>
</section>

<!-------------------------------------------------------------------------------->

<section id="e9">
    <h2>Autofill, Auto Refill and Error Messages</h2>
    <article>
        <img src="images/" alt="applyfeature">
        <h3>How It Functions:</h3>
    <p>...</p>
    <p>...</p>
    <p>...</p>
        
        <h3>How It Enhances:</h3>
    <p>...</p>
        <h3>Code:</h3>
        <img src="images/" alt="">
    <p>...</p>
        <h3>Key Usages:</h3>
    <p>...</p>
        <h3>Link:  <a href="" id="linki">Here</a></h3>  
    <p>Back to: <a href="#e1">Glossary</a></p>  
    </article>
</section>

<!-------------------------------------------------------------------------------->

<section id="e10">
    <h2>Table Sorting and Inline Editing</h2>
    <article>
        <h1 class="sort-title">Before Sorting</h1>
        <img src="images/sort1.png" alt="sort1" class="sort-image">
        <h1 class="sort-title">After Sorting</h1>
        <img src="images/sort2.png" alt="sort2">
        <h1 class="sort-title inline-title">Inline Editing Function</h1>
        <video class="demo-video" controls>
            <source src="images/update.mp4" type="video/mp4" alt="update">
        </video>

        <h3>How It Functions:</h3>
    <p>- Table Sorting:</p>  
    <p>+ When clicked on a field, the table will sort the data in an particular order.</p>
    <p>+ Additionally there are also arrows to indicate the order and which field is being sorted </p>

    <p>- Inline Editing Function:</p>  
    <p>+ Enter EOI number so select which field to edit, then change any info within the table with the right format.</p>
    <p>+ After clicking Save Changes, the data will be automatically updated both in the table and the MySQL database.</p>    
        <h3>How It Enhances:</h3>
    <p>- Table Sorting:</p>  
    <p>+ Sorting data in order will make it easier for the user to view and find data.</p>

    <p>- Inline Editing Function:</p>  
    <p>+ Creates a more user-friendly and simple UI.</p>    
        <h3>Code:</h3>
        <h1 class="code-title">Sorting Code</h1>
        <img src="images/sortcode.png" alt="sortcode">
        <h1 class="code-title">Inline Editing Code</h1>
        <img src="images/inlinecode.png" alt="inlinecode">
  
        <h3>Key Usages:</h3>
    <p>- Table Sorting:</p>  
    <p>+ Click on different titles to sort data in order.</p>

    <p>- Inline Editing Function:</p>  
    <p>+ Enter EOI number to edit specific data, saved changes will also affect the MySQL database</p>
    
        <h3>Link:  <a href="" id="linki">Here</a></h3>  
        <p>Back to: <a href="#e1">Glossary</a></p>  
    </article>
</section>

<br><hr><br>

    <?php include("footer.inc")?>

</body>
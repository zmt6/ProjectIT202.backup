<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(session_status() == PHP_SESSION_ACTIVE && $_SESSION['id'] != '') {
  //echo 'Session is active';
}
else{
  header("Location: index.php#loginPrompt");
  //echo 'Session is not active';
}

require('config.php');
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$db = new PDO($conn_string, $username, $password);

  $id = $_SESSION['id'];
  $appointmentTable = $id."appointments";
  $insert_queryTable = "UPDATE projectAccounts SET appointmentTable = '$appointmentTable' WHERE id = '$id'";
  $stmt = $db->prepare($insert_queryTable);
  $r = $stmt->execute();
  
  $query = "create table if not exists $appointmentTable(
    `id` int auto_increment not null,
		`dogName` varchar(64),
    `dogBreed` varchar(64),
    `dogSize` varchar(64),
    `date` datetime,
    PRIMARY KEY (`id`)
		) CHARACTER SET utf8 COLLATE utf8_general_ci";
    $stmt = $db->prepare($query);
      $r = $stmt->execute();

?>



<html>
	<head>
		<title> Dog Kennel | Dashboard </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
 
 
  <!-- WEBPAGE BODY  -->
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

<!-- Header -->
<header id="header">                    
                      
	<div class="content">     
		<div class="inner">                       
			<h1>Welcome back <?php echo $_SESSION['username'] ?></h1>                          
			<p>
      
      <?php
        echo "Session Data: ";
        print_r($_SESSION);  
      ?>

      <br/></p>
		</div>                                    
	</div>
                    
<nav>
	<ul>
		<li><a href="#schedule">Schedule</a></li>
		<li><a href="#view">View</a></li>
		<li><a href="#manage">Manage</a></li>
		<li><a href="#elements">Elements</a></li>
		<li><a href="#account">Account</a></li>
		<li><a href="logout.php">Log Out</a></li>
		<!--<li><a href="#elements">Elements</a></li>-->
	</ul>
</nav>
</header>

				<!-- Main -->
					<div id="main">
    
<!-- Login -->
<article id="login">
	<h2 class="major"> Login </h2>     
	<form method="post" action="./loginAction.php">
		<div class="fields">                   
      <!-- Login Name -->
      <div class="field half">
				<label >Name</label>             
				<input type="text" name="loginUsername"/>
			</div>      
      <!-- Login Password -->      
      <div class="field half">
				<label >Password</label>                                                
				<input type="password" name="loginPassword"/>
			</div>    
			<div></div>
		</div>
                                                                       
		<ul class="actions">
			<li><input type="submit" value="Login" class="primary" /></li>
			<li><input type="reset" value="Clear" /></li>
		</ul>
	</form>
  
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- Login End -->





<!-- schedule -->
<article id="schedule">
	<h2 class="major"> Schedule an Appointment </h2>     
	<form method="post" action="scheduleAction.php">
		<div class="fields">                   
      <!-- Dog Name -->
      <div class="field half">
				<label >Dog Name</label>             
				<input type="text" name="dogName"/>
			</div>     
      
      <!-- Spacing -->
      <div class="field half"></div> 
      
      <!-- Dog Breed -->      
      <div class="field half">
				<label >Dog Breed</label>                                                
				<input type="text" name="dogBreed"/>
			</div>    
      
      <!-- Spacing -->
      <div class="field half"></div> 
      
			<!-- Dog Size -->
      <div class="field half">
				<label >Dog Size</label>                                                
				<select name="dogSize" >
													<option value="">-</option>
													<option value="XL">Extra Large</option>
													<option value="L">Large</option>
													<option value="M">Medium</option>
													<option value="S">Small</option>
													<option value="T">Toy</option>
												</select>
			</div>
      <!-- Appointment Date -->
      <div class="field">
      <label>Apppointment Date</label>
      <input type="date" name="date">
      </div>
		</div>
                                                                       
		<ul class="actions">
			<li><input type="submit" value="Schedule" class="primary" /></li>
			<li><input type="reset" value="Clear" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- schedule End -->






<!-- view appointments  -->
<article id="view">
	<h2 class="major">Appointments</h2>     
	<form method="post" action="landingPage.php">
	
  
    <p>
    
    <table border='1'>
    <tr>
      <th>Appointment ID</th>
      <th>Dog Name</th>
      <th>Dog Breed</th>
      <th>Dog Size</th>
      <th>Appointment Date</th>
    </tr>
    <?php
      require('config.php');
      
      $conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
      $db = new PDO($conn_string, $username, $password);
      
      $id = $_SESSION['id'];
      $appointmentTable = $id."appointments";
      $stmt = $db->query("SELECT * FROM $appointmentTable");
      $result = $stmt->fetch();
      
      
      $stmt = $db->query("SELECT * FROM $appointmentTable");
        while($row = $stmt->fetch()){
          echo'<tr>';
          echo'<th>'.$row['id'].'</th>';
          echo'<th>'.$row['dogName'].'</th>';
          echo'<th>'.$row['dogBreed'].'</th>';
          echo'<th>'.$row['dogSize'].'</th>';
          echo'<th>'.$row['date'].'</th>';
          echo'</tr>';
        }
    ?>
    </table>
    
    </p>
                                                                         
		<ul class="actions">
			<li><input type="submit" value="Back to dashboard" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!--  view appointments End -->



<!-- Register Fail -->
<article id="registerFail">
	<h2 class="major"> Registration Failed! </h2>     
	<form method="post" action="#register">
	
  
    <p>Registration failed due to either mismatching passwords or a field was left blank.</p>
                                                                         
		<ul class="actions">
			<li><input type="submit" value="Back to Registration" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- Register Fail End -->






<!-- appointment delete -->
<article id="appointmentDeleted">
	<h2 class="major"> Appointment Deleted!</h2>     
	<form method="post" action="#view">
	
		<ul class="actions">
			<li><input type="submit" value="View Appointments" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- appointment delete End -->







<!-- Manage -->
<article id="manage">
	<h2 class="major"> Manage Appointments</h2>     
	<form method="post" action="manageAction.php">
	
  
    <div class="fields">                   
      <!-- Appointment ID -->
      <div class="field half">
				<label >Appointmnet ID</label>             
				<input type="text" name="appointmentID"/>
			</div>     
      
      <!-- Spacing -->
      <div class="field half"></div> 
      
    </div>
                                                                         
		<ul class="actions">
			<li><input type="submit" value="Delete Appointment" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- Manage End -->


<!-- Manage Fail -->
<article id="manageFail">
	<h2 class="major">Appointment Delete Failed!</h2>     
	<form method="post" action="#manage">
	
    <p> The appointment failed to delete. Enter a valid appointment ID. </p>
    <div class="fields">                 
    </div>
      <!-- Spacing -->
      <div class="field half"></div> 
      
                                                                         
		<ul class="actions">
			<li><input type="submit" value="Back to Appointment Manager" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- Manage Fail End -->





<!-- Account Start -->
<article id="account">
	<h2 class="major"> Account Settings </h2>     
	<form method="post" action="deleteSuccess.php">
                                                                         
		<ul class="actions">
			<li><input type="submit" value="DELETE ACCOUNT" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- Account End -->






<!-- schedule Succeed -->
<article id="scheduleSucceed">
	<h2 class="major"> Registration Succeeded! </h2>     
	<form method="post" action="landingPage.php">
	
  
    <p>Your appointment has been scheduled.</p>
                                                                         
		<ul class="actions">
			<li><input type="submit" value="Back to dashboard" class="primary" /></li>
		</ul>
   
	</form>
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- schedule Succeed End -->




<!-- Article -->
<article id="article">
<!-- Title -->
	<h2 class="major"> Title </h2>     
  
  <!-- EXTERNAL LINKS -->                 
	<ul class="icons">
		<li><a href="https://www.instagram.com/zach10ten/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="https://github.com/zmt6/ProjectIT202.backup" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
	</ul>
</article>
<!-- Article End -->                    
           
                                                                            
              
              
              
              
                                                                           

						<!-- Elements -->
							<article id="elements">
								<h2 class="major">Elements</h2>

								<section>
									<h3 class="major">Text</h3>
									<p>This is <b>bold</b> and this is <strong>strong</strong>. This is <i>italic</i> and this is <em>emphasized</em>.
									This is <sup>superscript</sup> text and this is <sub>subscript</sub> text.
									This is <u>underlined</u> and this is code: <code>for (;;) { ... }</code>. Finally, <a href="#">this is a link</a>.</p>
									<hr />
									<h2>Heading Level 2</h2>
									<h3>Heading Level 3</h3>
									<h4>Heading Level 4</h4>
									<h5>Heading Level 5</h5>
									<h6>Heading Level 6</h6>
									<hr />
									<h4>Blockquote</h4>
									<blockquote>Fringilla nisl. Donec accumsan interdum nisi, quis tincidunt felis sagittis eget tempus euismod. Vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing accumsan faucibus. Vestibulum ante ipsum primis in faucibus lorem ipsum dolor sit amet nullam adipiscing eu felis.</blockquote>
									<h4>Preformatted</h4>
									<pre><code>i = 0;

while (!deck.isInOrder()) {
    print 'Iteration ' + i;
    deck.shuffle();
    i++;
}

print 'It took ' + i + ' iterations to sort the deck.';</code></pre>
								</section>

								<section>
									<h3 class="major">Lists</h3>

									<h4>Unordered</h4>
									<ul>
										<li>Dolor pulvinar etiam.</li>
										<li>Sagittis adipiscing.</li>
										<li>Felis enim feugiat.</li>
									</ul>

									<h4>Alternate</h4>
									<ul class="alt">
										<li>Dolor pulvinar etiam.</li>
										<li>Sagittis adipiscing.</li>
										<li>Felis enim feugiat.</li>
									</ul>

									<h4>Ordered</h4>
									<ol>
										<li>Dolor pulvinar etiam.</li>
										<li>Etiam vel felis viverra.</li>
										<li>Felis enim feugiat.</li>
										<li>Dolor pulvinar etiam.</li>
										<li>Etiam vel felis lorem.</li>
										<li>Felis enim et feugiat.</li>
									</ol>
									<h4>Icons</h4>
									<ul class="icons">
										<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon brands fa-github"><span class="label">Github</span></a></li>
									</ul>

									<h4>Actions</h4>
									<ul class="actions">
										<li><a href="#" class="button primary">Default</a></li>
										<li><a href="#" class="button">Default</a></li>
									</ul>
									<ul class="actions stacked">
										<li><a href="#" class="button primary">Default</a></li>
										<li><a href="#" class="button">Default</a></li>
									</ul>
								</section>

								<section>
									<h3 class="major">Table</h3>
									<h4>Default</h4>
									<div class="table-wrapper">
										<table>
											<thead>
												<tr>
													<th>Name</th>
													<th>Description</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Item One</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Two</td>
													<td>Vis ac commodo adipiscing arcu aliquet.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Three</td>
													<td> Morbi faucibus arcu accumsan lorem.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Four</td>
													<td>Vitae integer tempus condimentum.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Five</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td>100.00</td>
												</tr>
											</tfoot>
										</table>
									</div>

									<h4>Alternate</h4>
									<div class="table-wrapper">
										<table class="alt">
											<thead>
												<tr>
													<th>Name</th>
													<th>Description</th>
													<th>Price</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Item One</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Two</td>
													<td>Vis ac commodo adipiscing arcu aliquet.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Three</td>
													<td> Morbi faucibus arcu accumsan lorem.</td>
													<td>29.99</td>
												</tr>
												<tr>
													<td>Item Four</td>
													<td>Vitae integer tempus condimentum.</td>
													<td>19.99</td>
												</tr>
												<tr>
													<td>Item Five</td>
													<td>Ante turpis integer aliquet porttitor.</td>
													<td>29.99</td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"></td>
													<td>100.00</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</section>

								<section>
									<h3 class="major">Buttons</h3>
									<ul class="actions">
										<li><a href="#" class="button primary">Primary</a></li>
										<li><a href="#" class="button">Default</a></li>
									</ul>
									<ul class="actions">
										<li><a href="#" class="button">Default</a></li>
										<li><a href="#" class="button small">Small</a></li>
									</ul>
									<ul class="actions">
										<li><a href="#" class="button primary icon solid fa-download">Icon</a></li>
										<li><a href="#" class="button icon solid fa-download">Icon</a></li>
									</ul>
									<ul class="actions">
										<li><span class="button primary disabled">Disabled</span></li>
										<li><span class="button disabled">Disabled</span></li>
									</ul>
								</section>

								<section>
									<h3 class="major">Form</h3>
									<form method="post" action="#">
										<div class="fields">
											<div class="field half">
												<label for="demo-name">Name</label>
												<input type="text" name="demo-name" id="demo-name" value="" placeholder="Jane Doe" />
											</div>
											<div class="field half">
												<label for="demo-email">Email</label>
												<input type="email" name="demo-email" id="demo-email" value="" placeholder="jane@untitled.tld" />
											</div>
											<div class="field">
												<label for="demo-category">Category</label>
												<select name="demo-category" id="demo-category">
													<option value="">-</option>
													<option value="1">Manufacturing</option>
													<option value="1">Shipping</option>
													<option value="1">Administration</option>
													<option value="1">Human Resources</option>
												</select>
											</div>
											<div class="field half">
												<input type="radio" id="demo-priority-low" name="demo-priority" checked>
												<label for="demo-priority-low">Low</label>
											</div>
											<div class="field half">
												<input type="radio" id="demo-priority-high" name="demo-priority">
												<label for="demo-priority-high">High</label>
											</div>
											<div class="field half">
												<input type="checkbox" id="demo-copy" name="demo-copy">
												<label for="demo-copy">Email me a copy</label>
											</div>
											<div class="field">
												<input type="checkbox" id="demo-human" name="demo-human" checked>
												<label for="demo-human">Not a robot</label>
											</div>
											<div class="field">
												<label for="demo-message">Message</label>
												<textarea name="demo-message" id="demo-message" placeholder="Enter your message" rows="6"></textarea>
											</div>
										</div>
										<ul class="actions">
											<li><input type="submit" value="Send Message" class="primary" /></li>
											<li><input type="reset" value="Reset" /></li>
										</ul>
									</form>
								</section>

							</article>
       <!-- ELEMENTS END -->

					</div>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; Zach Tenten. Design: HTML5 UP.</p>
					</footer>

			</div>

		<!-- BG -->
			<div id="bg"></div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>

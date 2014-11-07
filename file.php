<?php
include('simple_html_dom.php');
if(isset($_GET['url'])) //Check for get request
	{	
	$html = file_get_html($_GET['url']);  //GET all the data from url
	foreach($html->find('dd span.locality') as $loc)  //Location
	foreach($html->find('span.full-name') as $f)  //Name
	foreach($html->find('p.title') as $title)  //Title
	foreach($html->find('dd.industry') as $ind)  //Industry
	foreach($html->find('table tr[1] td[1] ol[1] li[1]') as $cur)  //Current Organization
	foreach($html->find('table tr[2] td[0] ol[0] li[0]') as $prev)  //Previous Organiization
	foreach($html->find('table tr[0] td[0] ol[0] li[0]') as $edu)  //Education
	    	$arr = array(
		  'name'=>$f->plaintext,
		  'title'=>$title->plaintext,
		  'industry'=>$ind->plaintext,
		  'previous'=>$prev->plaintext,
		  'loc'=>$loc->plaintext,
		  'edu'=>$edu->plaintext,
		  'cur'=>$cur->plaintext
		);    //Creating array in form of key value to encode in json
	
	//Inserting values into mysql	

	$val = array($f->plaintext,$title->plaintext,$ind->plaintext,$prev->plaintext,$cur->plaintext,$loc->plaintext,$edu->plaintext);
	$servername = "localhost";  //server configs
	$username = "root";
	$password = "admin";
	$dbname = "test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);  //creating mysqli connection
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
		//Insert values in mysql
	$sql = "INSERT INTO users (name, title, industry, previous, current, loc, education)
	VALUES ('$val[0]', '$val[1]', '$val[2]', '$val[3]', '$val[4]', '$val[5]', '$val[6]')";

	if ($conn->query($sql) === TRUE) {
	    //echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	echo json_encode($arr);  //returning json value to frontend ajax request
	}
?>

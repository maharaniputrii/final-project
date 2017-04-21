<?php
include ("top.php");

 
// SECTION: 1 Initialize variables

// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){  // later you can uncomment the if statement
print '<p>Post Array: </p><pre>';
print_r($_POST);
print '</pre>';
//}



//SECTION: 1b Security



$thisURL = $domain . $phpSelf;




// SECTION: 1c form variables

$firstName = "";

$lastName = "";

$gender="Female";

$country = "Camels Hump";
$countryERROR = false;

$recycle = false;
$compost = false;
$walknBike = false;
$bottleWater = false;
$reusableBags = false;
$none = false;

$email="cenoki@uvm.edu";



// SECTION: 1d form erros flags

$firstNameERROR = false;

$lastNameERROR = false;

$genderERROR = false;

$activityERROR = false;
$totalChecked = 0;

$emailERROR = false;



// SECTION: 1e misc variables


$errorMsg = array();


$dataRecord = array ();


$mailed = false;



// SECTION: 2 Process for when the form is submitted

if (isset($_POST["btnSubmit"])){



// SECTION: 2a Security

if (!securityCheck($thisURL)) {
    $msg = "<p>Sorry you cannot access this page. ";
    $msg.= "Security breach detected and reported.</p>";
    die($msg);
}



// SECTION: 2b Sanitize data


$firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, ÜTF-8);
$dataRecord[] = $firstName;

$lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, UTF-8);
$dataRecord[] = $lastName;

$gender = htmlentities($_POST["radGender"], ENT_QUOTES, UTF-8);
$dataRecord[] = $gender;

$country = htmlentities($_POST["1stCountry"], ENT_QUOTES, ÜTF-8);
$dataRecord[] = $country;

if (isset($_POST["chkRecycle"])) {
    $recycle = true;
    $totalChecked++;
} else {
    $recycle = false;
}
$dataRecord[] = $recycle;
if (isset($_POST["chkCompost"])) {
    $compost = true;
    $totalChecked++;
} else {
    $compost = false;
}
$dataRecord[] = $compost;
if (isset($_POST["chkWalknBike"])) {
    $walknBike = true;
    $totalChecked++;
} else {
    $walknBike = false;
}
$dataRecord[] = $walknBike;
if (isset($_POST["chkBottleWater"])) {
    $bottleWater = true;
    $totalChecked++;
} else {
    $bottleWater = false;
}
$dataRecord[] = $bottleWater;
if (isset($_POST["chkReusableBags"])) {
    $reusableBags = true;
    $totalChecked++;
} else {
    $reusableBags = false;
}
$dataRecord[] = $reusableBags;
if (isset($_POST["chkNone"])) {
    $none = true;
    $totalChecked++;
} else {
    $none = false;
}
$dataRecord[] = $none;
        
$email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
$dataRecord[] = $email;




// SECTION: 2c Validation

if ($firstName == "") {
    $errorMsg[] = "Please enter your first name";
    $firstNameERROR = true;
} elseif (!verifyAlphaNum($firstName)) {
    $errorMsg[] = "Your first name appears to have extra characters.";
    $firstNameERROR = true;
}

if ($lastName == "") {
    $errorMsg[] = "Please enter your last name";
    $lastNameERROR = true;
} elseif (!verifyAlphaNum($lastName)) {
    $errorMsg[] = "Your last name appears to have extra characters.";
    $lastNameERROR = true;
}

if ($gender != "Female" AND $gender !="Male" AND $gender !="NotAnswer"){
    $errorMsg[] = "Please choose a gender";
    $genderERROR = true;
}

if ($country == "1"){
    $errorMsg[] = "Please choose one option";
    $educationERROR = true;
}

if ($totalChecked < 1){
    $errorMsg[] = "Please choose at least one option";
    $activityERROR = true;
}

if ($email == "") {
    $errorMsg[] = "Please enter your email address";
    $emailERROR = true;
} elseif (!verifyEmail($email)) {
    $errorMsg[] = "Your email address appears to be incorrect.";
    $emailERROR = true;
}




// SECTION: 2d Process Form



if (!$errorMsg){
    if ($debug)
        print "<p>Form is valid</p>";




// SECTION: 2e Save data



    $fileExt = ".csv";
    $myFileName = "data/registration";
    $filename = $myFileName . $fileExt;

    if ($debug){
        print "\n\n<p>filename is " . $filename;
    }


    $file = fopen($filename, 'a');


    fputcsv($file, $dataRecord);;


fclose($file);




// SECTION: 2f Create message




$message = '<h2 class="form-message">Your information:</h2>';

foreach ($_POST as $htmlName => $value) {
    $message .="<p>";
    
    
    
    $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
    
    foreach ($camelCase as $oneWord) {
        $message .= $oneWord . " ";
    }
    
    $message .= " = " . htmlentities($value, ENT_QUOTES, ÜTF-8) . "</P>";
}





// SECTION: 2g mail to user


$to = $email;
$cc = "";
$bcc = "";

$from = "Climate Change <customer.service@climatechange.com>";


$todaysDate = strftime("%x");
$subject = "Subscription: ". $todaysDate;

$mailed = sendMail ($to, $cc, $bcc, $from, $subject, $message);

}

}




// SECTION: 3 Display form

?>

<article id="main">
 
 <?php
 
 
 // SECTION: 3a
 
 
 
 if (isset($_POST["btnSubmit"])AND empty($errorMsg)) {
     print "<h2>Thank you for subscribing!</h2>";
     
      print "<p>For your records a copy of this data has ";
      
      if (!$mailed) {
          print "not ";
      }
      print "been sent to:</p>";
      print "<p>" . $email . "</p>";
      
      print $message;
 }else {
 
	print '<h2>Subscribe to get more information!</h2>';
	print '<p class="form-heading">If you liked this website subscribe to receive more information and news about climate change.</p>';
	
	
	
// SECTION: 3b Error messages
	
	
	
	if ($errorMsg) {
            print '<div id="errors">' . "\n";
            print"<h2>Your form has the following mistakes that need fixing.</h2>\n";
            print "<ol>\n";
            
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            
            print "</ol>\n";
            print "</div>\n";
        }
	
            
	
// SECTION: 3c html form	
	
	
	
	
	
	
	
	
	
	
	
	
?>
	
    <form action="<?php print $phpSelf; ?>"
	id="frmRegister"
	method="post">
	
        <fieldset class="personal">
            <legend>Personal Information</legend>
            <p>
                <label class="required text-field" for="txtFirstName">First Name</label>
                <input autofocus
                       <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                       id="txtFirstName"
                       maxlength="45"
                       name="txtFirstName"
                       onfocus="this.select()"
                       placeholder="Enter your first name"
                       tabindex="100"
                       type="text"
                       value="<?php print $firstName; ?>"
                >
            </p>
            <p>
                <label class="required text-field" for="txtLastName">Last Name</label>
                <input <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                       id="txtLastName"
                       maxlength="45"
                       name="txtLastName"
                       onfocus="this.select()"
                       placeholder="Enter your last name"
                       tabindex="110"
                       type="text"
                       value="<?php print $lastName; ?>"
                >
            </p>
            <fieldset class="radio <?php if ($genderERROR) print ' mistake'; ?>">
            <legend>Gender:</legend>
            <p>
            <label class="radio-field">
            <input type="radio" 
                   id="radGenderFemale" 
                   name="radGender" 
                   value="Female" 
                   tabindex="115"
                   <?php if ($gender == "Female") echo ' checked="checked" '; ?>>
            Female</label>
            </p>
            <p>    
            <label class="radio-field">
            <input type="radio" 
                   id="radGenderMale" 
                   name="radGender" 
                   value="Male" 
                   tabindex="116"
                   <?php if ($gender == "Male") echo ' checked="checked" '; ?>>
            Male</label>
            </p>
            <p>    
            <label class="radio-field">
            <input type="radio" 
                   id="radGenderNotAnswer" 
                   name="radGender" 
                   value="NotAnswer" 
                   tabindex="117"
                   <?php if ($gender == "NotAnswer") echo ' checked="checked" '; ?>>
            Prefer not to answer</label>
            </p>
            </fieldset>

            <fieldset class="listbox <?php if ($countryERROR) print 'mistake'; ?>">
            <legend>Country:</legend>
            <select id="1stcountry"
                    name="1stcountry"
                    tabindex="118">
                <option <?php if($education == "No Diploma") print "selected"; ?>
                    value="No Diploma">No Diploma</option>
                
            </select>
            </fieldset>
        </fieldset>
        
        <fieldset class="checkbox <?php if ($activityERROR) print 'mistake'; ?>">
            <legend>Check the practices you do that are environmentally friendly</legend>
            <p>
                <label class="check-field">
                    <input <?php if ($recycle) print "checked";?>
                        id="chkRecycle"
                        name="chkRecycle"
                        tabindex="120"
                        type="checkbox"
                        value="Recycle">Recycle</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($compost) print "checked";?>
                        id="chkCompost"
                        name="chkCompost"
                        tabindex="121"
                        type="checkbox"
                        value="Compost">Compost</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($walknBike) print "checked";?>
                        id="chkWalknBike"
                        name="chkWalknBike"
                        tabindex="122"
                        type="checkbox"
                        value="WalknBike">Walk and/or bike to places</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($bottleWater) print "checked";?>
                        id="chkBottleWater"
                        name="chkBottleWater"
                        tabindex="123"
                        type="checkbox"
                        value="BottleWater">Use reusable bottles for water</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($reusableBags) print "checked";?>
                        id="chkReusableBags"
                        name="chkReusableBags"
                        tabindex="124"
                        type="checkbox"
                        value="ReusableBags">Use reusable bags instead of plastic ones</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($none) print "checked";?>
                        id="chkNone"
                        name="chkNone"
                        tabindex="125"
                        type="checkbox"
                        value="None">None of the above</label>
            </p>
        </fieldset>
                
        
        <fieldset class="contact">
            <legend>Contact Information</legend>			
            <p>
                <label class="required" for="txtEmail">Email</label>
                    <input
			<?php if ($emailERROR) print 'class="mistake"'; ?>				
			id="txtEmail"
			maxlength="45"
                        name="txtEmail"
			onfocus="this.select()"
			placeholder="Enter a valid email address"
			tabindex="200"
			type="text"
			value="<?php print $email; ?>"
                    >
            </p>
	</fieldset>
			
	<fieldset class="buttons">
            <legend></legend>
            <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Register">
	</fieldset>
    </form>
	
<?php
 }
?>		
	
</article>

<?php include 'footer.php'; ?>

</body>
</html>

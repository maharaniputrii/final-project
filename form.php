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

$country="Argentina";
$countries="";

$brazil = false;
$france = false;
$indonesia = false;
$southkorea = false;
$spain = false;
$sweden = false;
$uk= false;

$email="";

$comment= "";
// SECTION: 1d form erros flags
$firstNameERROR = false;

$lastNameERROR = false;

$genderERROR = false;

$countryERROR = false;
$countriesERROR = false;

$visitedERROR = false;
$totalChecked = 0;

$emailERROR = false;

$commentERROR = false;
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
	
$countries = htmlentities($_POST["txtCountries"], ENT_QUOTES, ÜTF-8);
$dataRecord[] = $countries;

if (isset($_POST["chkBrazil"])) {
    $brazil = true;
    $totalChecked++;
} else {
    $brazil = false;
}
$dataRecord[] = $brazil;

if (isset($_POST["chkFrance"])) {
    $france = true;
    $totalChecked++;
} else {
    $france = false;
}
$dataRecord[] = $france;

if (isset($_POST["chkIndonesia"])) {
    $indonesia = true;
    $totalChecked++;
} else {
    $indonesia = false;
}
$dataRecord[] = $indonesia;

if (isset($_POST["chkSouthKorea"])) {
    $southkorea = true;
    $totalChecked++;
} else {
    $southkorea = false;
}
$dataRecord[] = $southkorea;

if (isset($_POST["chkSpain"])) {
    $spain = true;
    $totalChecked++;
} else {
    $spain = false;
}
$dataRecord[] = $spain;

if (isset($_POST["chkSweden"])) {
    $sweden = true;
    $totalChecked++;
} else {
    $sweden = false;
}
$dataRecord[] = $sweden;

if (isset($_POST["chkUnitedKingdom"])) {
    $uk = true;
    $totalChecked++;
} else {
    $uk = false;
}
$dataRecord[] = $uk;
        
$email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
$dataRecord[] = $email;

$comment = htmlentities($_POST["txtComment"], ENT_QUOTES, ÜTF-8);
$dataRecord[] = $comment;

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

if ($country == "Argentina"){
        $errorMsg[] = "Please choose your country";
        $countryERROR = true;
    }
       
if ($countries == "") {
    $errorMsg[] = "Please type your country";
    $countriesERROR = true;
}

if ($email == "") {
    $errorMsg[] = "Please enter your email address";
    $emailERROR = true;
} elseif (!verifyEmail($email)) {
    $errorMsg[] = "Your email address appears to be incorrect.";
    $emailERROR = true;
}

if ($comment == "") {
    $errorMsg[] = "Please enter your comment";
    $commentERROR = true;
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
$from = "Diversity in UVM <customer.service@diversityinuvm.com>";
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
 
	print '<h2>Share things about your country!</h2>';
	print '<p class="form-heading">If you are an international student and want your country presented in this website, fill out this form and we will send you more information!</p>';
	
	
	
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
                <option <?php if($country == "Argentina") print "selected"; ?>
                    value="Argentina">Argentina</option>
                <option <?php if($country == "Belgium") print "selected"; ?>
                    value="Belgium">Belgium</option>
                <option <?php if($country == "Brazil") print "selected"; ?>
                    value="Brazil">Brazil</option>
                <option <?php if($country == "Cambodia") print "selected"; ?>
                    value="Cambodia">Cambodia</option>
                <option <?php if($country == "China") print "selected"; ?>
                    value="China">China</option>
                <option <?php if($country == "Costa Rica") print "selected"; ?>
                    value="Costa Rica">Costa Rica</option>
                <option <?php if($country == "Cuba") print "selected"; ?>
                    value="Cuba">Cuba</option>
                <option <?php if($country == "France") print "selected"; ?>
                    value="France">France</option>
                <option <?php if($country == "Hong Kong") print "selected"; ?>
                    value="Hong Kong">Hong Kong</option>
                <option <?php if($country == "Iceland") print "selected"; ?>
                    value="Iceland">Iceland</option>
                <option <?php if($country == "India") print "selected"; ?>
                    value="India">India</option>
                <option <?php if($country == "Indonesia") print "selected"; ?>
                    value="Indonesia">Indonesia</option>
                <option <?php if($country == "Iran") print "selected"; ?>
                    value="Iran">Iran</option>
                <option <?php if($country == "Ireland") print "selected"; ?>
                    value="Ireland">Ireland</option>
                <option <?php if($country == "Japan") print "selected"; ?>
                    value="Japan">Japan</option>
                <option <?php if($country == "South Korea") print "selected"; ?>
                    value="South Korea">South Korea</option>
                <option <?php if($country == "Mexico") print "selected"; ?>
                    value="Mexico">Mexico</option>
                <option <?php if($country == "United Kingdom") print "selected"; ?>
                    value="UK">United Kingdom</option>
                <option <?php if($country == "United States") print "selected"; ?>
                    value="US">The United States</option>
            </select>			
            <p>
                <label class="required" for="txtCountries">If your country is not listed, please type it below:</label>
                    <input
			<?php if ($countriesERROR) print 'class="mistake"'; ?>				
			id="txtCountries"
			maxlength="45"
                        name="txtCountries"
			onfocus="this.select()"
			placeholder="Enter a valid country name"
			tabindex="200"
			type="text"
			value="<?php print $countries; ?>"
                    >
            </p>
        </fieldset>
        
        <fieldset class="checkbox <?php if ($visitedERRORERROR) print 'mistake'; ?>">
            <legend>Please check the countries you have visited that we covered in this website.</legend>
            <p>
                <label class="check-field">
                    <input <?php if ($brazil) print "checked";?>
                        id="chkBrazil"
                        name="chkBrazil"
                        tabindex="120"
                        type="checkbox"
                        value="Brazil">Brazil</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($france) print "checked";?>
                        id="chkFrance"
                        name="chkFrance"
                        tabindex="121"
                        type="checkbox"
                        value="France">France</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($indonesia) print "checked";?>
                        id="chkIndonesia"
                        name="chkIndonesia"
                        tabindex="122"
                        type="checkbox"
                        value="Indonesia">Indonesia</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($southkorea) print "checked";?>
                        id="chkSouthKorea"
                        name="chkSouthKorea"
                        tabindex="123"
                        type="checkbox"
                        value="SouthKorea">South Korea</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($spain) print "checked";?>
                        id="chkSpain"
                        name="chkSpain"
                        tabindex="124"
                        type="checkbox"
                        value="Spain">Spain</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($sweden) print "checked";?>
                        id="chkSweden"
                        name="chkSweden"
                        tabindex="125"
                        type="checkbox"
                        value="Sweden">Sweden</label>
            </p>
            <p>
                <label class="check-field">
                    <input <?php if ($uk) print "checked";?>
                        id="chkUnitedKingdom"
                        name="chkUnitedKingdom"
                        tabindex="125"
                        type="checkbox"
                        value="UnitedKingdom">United Kingdom</label>
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
	        <fieldset class="comment">
            <legend>If you have any question or comment about the website please enter it bellow.</legend>
            <p>
                <label class="required text-field" for="txtFirstName">Comment</label>
                <input autofocus
                       <?php if ($commentERROR) print 'class="mistake"'; ?>
                       id="txtComment"
                       maxlength="45"
                       name="txtComment"
                       onfocus="this.select()"
                       placeholder="Enter your comment"
                       tabindex="200"
                       type="text"
                       value="<?php print $comment; ?>"
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

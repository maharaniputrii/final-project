<?php
include ("top.php");
 
// SECTION: 1 Initialize variables
// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){  // later you can uncomment the if statement

////print '<p>Post Array: </p><pre>';
//print_r($_POST);
////print '</pre>';
//}
//SECTION: 1b Security
$thisURL = $domain . $phpSelf;
// SECTION: 1c form variables
$firstName = "";
$lastName = "";
$gender="Female";
$country="Argentina";
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
$from = "International Students<customer.service@internationalstu.com>";
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
     print "<h2>Thank you for filling out the from! And your interest in contributing to this website!</h2>";
     
      print "<p>For your records a copy of this data has ";
      
      if (!$mailed) {
          print "not ";
      }
      print "been sent to:</p>";
      print "<p>" . $email . "</p>";
      
      print $message;
 }else {
 
	print '<h2>Share things about your country!</h2>';
	print '<p class="form-heading">If you are an international student and want to be represented in this website with information about your home country, please fill out the form to receive more information about how to make this happen! We would love more contributions!</p>';
	
	
	
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
	id="frmSubmit"
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
                <option <?php if($country == "Afghanistan") print "selected"; ?>
                    value="Afghanistan">Afghanistan</option>
                <option <?php if($country == "Albania") print "selected"; ?>
                    value="Albania">Albania</option>
                <option <?php if($country == "Algeria") print "selected"; ?>
                    value="Algeria">Algeria</option>
                <option <?php if($country == "Argentina") print "selected"; ?>
                    value="Argentina">Argentina</option>
                <option <?php if($country == "Australia") print "selected"; ?>
                    value="Australia">Australia</option>
                <option <?php if($country == "Austria") print "selected"; ?>
                    value="Austria">Austria</option>
                <option <?php if($country == "Bahamas") print "selected"; ?>
                    value="Bahamas">Bahamas, The</option>
                <option <?php if($country == "Belgium") print "selected"; ?>
                    value="Belgium">Belgium</option>
                <option <?php if($country == "Brazil") print "selected"; ?>
                    value="Brazil">Brazil</option>
                <option <?php if($country == "Cambodia") print "selected"; ?>
                    value="Cambodia">Cambodia</option>
                <option <?php if($country == "Canada") print "selected"; ?>
                    value="Canada">Canada</option>
                <option <?php if($country == "Africa") print "selected"; ?>
                    value="Africa">Central African Republic</option>
                <option <?php if($country == "China") print "selected"; ?>
                    value="China">China</option>
                <option <?php if($country == "Costa Rica") print "selected"; ?>
                    value="Costa Rica">Costa Rica</option>
                <option <?php if($country == "Cuba") print "selected"; ?>
                    value="Cuba">Cuba</option>
                <option <?php if($country == "Denmark") print "selected"; ?>
                    value="Denmark">Denmark</option>
                <option <?php if($country == "Dominica") print "selected"; ?>
                    value="Dominica">Dominica</option>
                <option <?php if($country == "Cuba") print "selected"; ?>
                    value="Cuba">Cuba</option>
                <option <?php if($country == "Dominican Republic") print "selected"; ?>
                    value="Dominican Republic">Dominican Republic</option>
                <option <?php if($country == "Egypt") print "selected"; ?>
                    value="Egypt">Egypt</option>
                <option <?php if($country == "Estonia") print "selected"; ?>
                    value="Estonia">Estonia</option>
                <option <?php if($country == "Ethiopia") print "selected"; ?>
                    value="Ethiopia">Ethiopia</option>
                <option <?php if($country == "Fiji") print "selected"; ?>
                    value="Fiji">Fiji</option>
                <option <?php if($country == "France") print "selected"; ?>
                    value="France">France</option>
                <option <?php if($country == "Germany") print "selected"; ?>
                    value="Germany">Germany</option>
                <option <?php if($country == "Greece") print "selected"; ?>
                    value="Greece">Greece</option>
                <option <?php if($country == "Guinea") print "selected"; ?>
                    value="Guinea">Guinea</option>
                <option <?php if($country == "Haiti") print "selected"; ?>
                    value="Haiti">Haiti</option>
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
                <option <?php if($country == "Iraq") print "selected"; ?>
                    value="Iraq">Iraq</option>
                <option <?php if($country == "Ireland") print "selected"; ?>
                    value="Ireland">Ireland</option>
                <option <?php if($country == "Israel") print "selected"; ?>
                    value="Israel">Israel</option>
                <option <?php if($country == "Italy") print "selected"; ?>
                    value="Italy">Italy</option>
                <option <?php if($country == "Jamaica") print "selected"; ?>
                    value="Jamaica">Jamaica</option>
                <option <?php if($country == "Japan") print "selected"; ?>
                    value="Japan">Japan</option>
                <option <?php if($country == "Kazakhstan") print "selected"; ?>
                    value="Kazakhstan">Kazakhstan</option>
                <option <?php if($country == "Kenya") print "selected"; ?>
                    value="Kenya">Kenya</option>
                <option <?php if($country == "North Korea") print "selected"; ?>
                    value="North Korea">Korea, North</option>
                <option <?php if($country == "South Korea") print "selected"; ?>
                    value="South Korea">Korea, South</option>
                <option <?php if($country == "Kuwait") print "selected"; ?>
                    value="Kuwait">Kuwait</option>
                <option <?php if($country == "Laos") print "selected"; ?>
                    value="Laos">Laos</option>
                <option <?php if($country == "Lebanon") print "selected"; ?>
                    value="Lebanon">Lebanon</option>
                <option <?php if($country == "Liberia") print "selected"; ?>
                    value="Liberia">Liberia</option>
                <option <?php if($country == "Macau") print "selected"; ?>
                    value="Macau">Macau</option>
                <option <?php if($country == "Madagascar") print "selected"; ?>
                    value="Madagascar">Madagascar</option>
                <option <?php if($country == "Malaysia") print "selected"; ?>
                    value="Malaysia">Malaysia</option>
                <option <?php if($country == "Maldives") print "selected"; ?>
                    value="Maldives">Maldives</option>
                <option <?php if($country == "Mexico") print "selected"; ?>
                    value="Mexico">Mexico</option>
                <option <?php if($country == "Mongolia") print "selected"; ?>
                    value="Mongolia">Mongolia</option>
                <option <?php if($country == "Morocco") print "selected"; ?>
                    value="Morocco">Morocco</option>
                <option <?php if($country == "Nepal") print "selected"; ?>
                    value="Nepal">Nepal</option>
                <option <?php if($country == "Netherlands") print "selected"; ?>
                    value="Netherlands">Netherlands</option>
                <option <?php if($country == "New Zealand") print "selected"; ?>
                    value="New Zealand">New Zealand</option>
                <option <?php if($country == "Nigeria") print "selected"; ?>
                    value="Nigeria">Nigeria</option>
                <option <?php if($country == "Norway") print "selected"; ?>
                    value="Norway">Norway</option>
                <option <?php if($country == "Pakistan") print "selected"; ?>
                    value="Pakistan">Pakistan</option>
                <option <?php if($country == "Papua New Guinea") print "selected"; ?>
                    value="Papua New Guinea">Papua New Guinea</option>
                <option <?php if($country == "Paraguay") print "selected"; ?>
                    value="Paraguay">Paraguay</option>
                <option <?php if($country == "Peru") print "selected"; ?>
                    value="Peru">Peru</option>
                <option <?php if($country == "Philippines") print "selected"; ?>
                    value="Philippines">Philippines</option>
                <option <?php if($country == "Poland") print "selected"; ?>
                    value="Poland">Poland</option>
                <option <?php if($country == "Portugal") print "selected"; ?>
                    value="Portugal">Portugal</option>
                <option <?php if($country == "Qatar") print "selected"; ?>
                    value="Qatar">Qatar</option>
                <option <?php if($country == "Romania") print "selected"; ?>
                    value="Romania">Romania</option>
                <option <?php if($country == "Russia") print "selected"; ?>
                    value="Russia">Russia</option>
                <option <?php if($country == "Saudi Arabia") print "selected"; ?>
                    value="Saudi Arabia">Saudi Arabia</option>
                <option <?php if($country == "Slovenia") print "selected"; ?>
                    value="Slovenia">Slovenia</option>
                <option <?php if($country == "Singapore") print "selected"; ?>
                    value="Singapore">Singapore</option>
                <option <?php if($country == "Spain") print "selected"; ?>
                    value="Spain">Spain</option>
                <option <?php if($country == "Sweden") print "selected"; ?>
                    value="Sweden">Sweden</option>
                <option <?php if($country == "Switzerland") print "selected"; ?>
                    value="Switzerland">Switzerland</option>
                <option <?php if($country == "Taiwan") print "selected"; ?>
                    value="Taiwan">Taiwan</option>
                <option <?php if($country == "Thaliand") print "selected"; ?>
                    value="Thailand">Thailand</option>
                <option <?php if($country == "Turkey") print "selected"; ?>
                    value="Turkey">Turkey</option>
                <option <?php if($country == "Uganda") print "selected"; ?>
                    value="Uganda">Uganda</option>
                <option <?php if($country == "Ukraine") print "selected"; ?>
                    value="Ukraine">Ukraine</option>
                <option <?php if($country == "United Arab Emirates") print "selected"; ?>
                    value="United Arab Emirates">United Arab Emirates</option>
                <option <?php if($country == "United Kingdom") print "selected"; ?>
                    value="UK">United Kingdom</option>
                <option <?php if($country == "United States") print "selected"; ?>
                    value="US">The United States</option>
                <option <?php if($country == "Uruguay") print "selected"; ?>
                    value="Uruguay">Uruguay</option>
                <option <?php if($country == "Venezuela") print "selected"; ?>
                    value="Venezuela">Venezuela</option>
                <option <?php if($country == "Vietnam") print "selected"; ?>
                    value="Vietnam">Vietnam</option>
                <option <?php if($country == "Yemen") print "selected"; ?>
                    value="Yemen">Yemen</option>
                
            </select>		
        </fieldset>
        </fieldset>
        
        <fieldset class="checkbox <?php if ($visitedERRORERROR) print 'mistake'; ?>">
            <legend>Which countries we covered in this website have you visited? (leave blanc if none)</legend>
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
                <label class="required" for="txtEmail">Email:</label>
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
                <label class="text-field" for="txtFirstName">Comment:</label>
                 <input
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
            <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Submit">
	</fieldset>
    </form>
	
<?php
 }
?>		
	
</article>

<?php include 'footer.php'; ?>

</body>
</html>
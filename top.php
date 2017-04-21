<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Diversity in University of Vermont</title>

        <meta charset="utf-8">
        <meta name="author" content="group">
        <meta name="description" content="read this: http://moz.com/learn/seo/meta-description ">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../custom.css" type="text/css" media="screen">
      
        <?php
        $debug = false;



        if (isset($_GET["debug"])) {
            $debug = true;
        }






        $domain = "//";

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server; 

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print"<p>Domain: " . $domain;
            print'<p>php Self: ' . $phpSelf;
            print'<p>Path Parts<pre>';
            print_r($path_parts);
            print'</pre></p>';
        }








        print "\n" . '<!-- include libraries -->' . "\n";

        require_once('lib/security.php');




        if ($path_parts['filename'] == "form"){
            print"\n<!-- include form libraries -->\n";
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
        
        print "\n" . '<!-- finished including libraries -->' . "\n";
        ?>

    </head>


    <?php
    print '<body id="' . $path_parts['filename'] . '">';

    include 'header.php';
    include 'nav.php';
    
    if ($debug) {
        print'<p> DEBUG MODE IS ON</p';
    }
    ?>

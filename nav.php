<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ul>
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">Home</a>';
        print '</li>';

        print '<li class="';
        if ($path_parts['filename'] == "brazil") {
            print ' activePage ';
        }
        print '">';
        print '<a href="brazil.php">Brazil</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "indonesia") {
            print ' activePage ';
        }
        print '">';
        print '<a href="indonesia.php">Indonesia</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "uk") {
            print ' activePage ';
        }
        print '">';
        print '<a href="uk.php">United Kingdom</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "spain") {
            print ' activePage ';
        }
        print '">';
        print '<a href="spain.php">Spain</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "form") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">Form</a>';
        print '</li>';
        ?>
    </ul>
</nav>

<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ul>
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print ' activePage ';
        }
        print '">';
        print '<a href="index.php">About us</a>';
        print '</li>';
        
        
    print '<div class="dropdown">';
        print '<button class="dropbtn">Countries</button>';
        print '<ul class="dropdown-content">';
        
        print '<li class="';
        if ($path_parts['filename'] == "brazil") {
            print ' activePage ';
        }
        print '">';
        print '<a href="brazil.php">Brazil</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "france") {
            print ' activePage ';
        }
        print '">';
        print '<a href="france.php">France</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "indonesia") {
            print ' activePage ';
        }
        print '">';
        print '<a href="indonesia.php">Indonesia</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "southkorea") {
            print ' activePage ';
        }
        print '">';
        print '<a href="southkorea.php">South Korea</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "spain") {
            print ' activePage ';
        }
        print '">';
        print '<a href="spain.php">Spain</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "sweden") {
            print ' activePage ';
        }
        print '">';
        print '<a href="sweden.php">Sweden</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "uk") {
            print ' activePage ';
        }
        print '">';
        print '<a href="uk.php">United Kingdom</a>';
        print '</li>';
        
        print '</ul>';
    print '</div>';
        
        
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

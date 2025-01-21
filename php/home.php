<?php
    $connect = mysqli_connect("localhost", "root", "", "luminio") or
        die("Please, check your server connection.");
    $query = "SELECT rating, name, description, image, price FROM products";
    $results = mysqli_query($connect, $query) or die(mysqli_error($connect));
    
    echo "<table border='0'>";
    $x = 1; // Initialize counter
    echo "<tr>";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        if ($x <= 3) {
            $x++;
            extract($row);
            echo "<td style='padding-right:15px;'>";
            echo "<a href='itemdetails.php?itemcode=$item_code'>";
            echo "<img src='$imagename' style='max-width:220px;max-height:240px;width:auto;height:auto;' /><br />";
            echo $item_name . "<br />";
            echo "</a>";
            echo "$" . $price . "<br />";
            echo "</td>";
        } else {
            $x = 1; // Reset counter
            echo "</tr><tr>";
        }
    }
    echo "</tr>"; // Close the last row if incomplete
    echo "</table>";
    ?>
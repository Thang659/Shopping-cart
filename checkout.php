<?php
// The shopping cart page itself
session_start();
 // Include the products library
require 'book.php';
// If we were asked to clear the cart, do so immediately.
if   (@$_POST['submit'] == 'Clear Cart') {
    unset($_SESSION['cart']);
}
// Otherwise if we have been presented with an update, handle it:
elseif (isset($_POST['update'])) {
    // Loop over all the updates
    foreach ((array)$_POST['update'] as $id => $val) {
        // Only update if the value is numeric or blank - Otherwise ignore.
        $val = trim($val);
        if (preg_match('/^[0-9]*$/', $val)) {
            // If the value is 0 or blank, remove it:
            if ($val == 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                // Otherwise, just reset to the new number
                $_SESSION['cart'][$id] = $val;
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Shopping Cart</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>
table {  border-collapse: collapse;  }
.num {  text-align: right;  }
td, th, div { border: 1px solid black; padding: 4px;}
</style>
</head>
<body>
<p>The following is in your shopping cart:</p>
<form action="<?= $_SERVER [ 'PHP_SELF' ]  ?>" method="post">
<table>
 <tr><th scope="col">Order</th><th scope="col">Book Title</th>
 <th scope="col">Due date</th>
<?php
// Loop through all of the current cart:
$counter = 0;
$total = 0;
if (@is_array($_SESSION['cart'])) {
      foreach ((array)$_SESSION['cart'] as $id => $c) {
 // Echo out a table row with this data:
        $counter++;
        echo "<tr><td>{$books[$id]['book_id']}</td><td>{$books[$id]['title'] }</td><td>{$books[$id]['status']}</td></tr>\n";
			echo "<tr><td>{$counter}</td><td>{$books[$id]['title'] }</td><td>{$books[$id]['status'] }</td></tr>";
 // Update our total
        $total += $products[$id]['price'] * $c;
    }
}
?>

<tr class="num"><td colspan="4">
<input type="button" value="Keep browsing"
 onclick="javascript:window.location.href='library.php'" />
<input type="submit" name="submit" value="Update Quantities" />
<input type="submit" name="submit" value="Clear Cart"
 onclick="return confirm('Are you sure you wish to empty your cart?')" />

</td></tr>
</table>
</form>
</body>
</html>

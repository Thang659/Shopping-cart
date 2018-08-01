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
<h1> Welcome to purchase page </h1>
<h2> Enter your credit card infomation </h2>
<?php
// An array of our required elements, and their real names:
$required = array('card' => 'card number', 'ccv' => 'CCV','date' => 'expiry date');
if (count($_POST)) {
    $errors = '';
    // Loop over all required fields, and ensure they exist:
    foreach ($required as $field => $desc) {
        // If it is not even set, or is blank after trimming:
        if (!isset($_POST[$field]) || (trim($_POST[$field]) === '')) {
            $errors .= "<br />{$desc} is a required field!\n";
        }
    }
    if ($errors) {
        echo "<p style=\"color: red\">The following errors were found:
{$errors}</p>\n";
    } 
}

?>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="f1">
<h3>We only accept Visa or Mastercard:</h3>
<p>Card Number:
<input name="card" type="text" value="<?= @$_POST['card'] ?>" /></p>
<p>CCV:
<input name="ccv" type="text" value="<?= @$_POST['ccv'] ?>" /></p>
<p>Expiry date:
<input name="date" type="text" value="<?= @$_POST['date'] ?>" /></p>

<p>Card type:
  <input type="radio" name="v" value="<?= @$_POST['type'] ?>"> Visa
  <input type="radio" name="m" value="<?= @$_POST['type'] ?>"> Mastercard<br></p>
<p><input type="submit" value="Pay"/></p>
</form>


<?php
function standardize_credit($num) {
    return preg_replace('/[^0-9]/', '', $num);
}
// a character specifying the type of CC:
// m = Mastercard, v = Visa, d = Discover, a = American Express
function validate_credit($num, $type) {
    $len = strlen($num);
    $d2 = substr($num,0,2);
 // If Visa must start with a 4, and be 13 or 16 digits long:
    if ( (($type == 'v') && (($num{0} != 4) || !(($len == 13) || ($len == 16)))) ||
    // If Mastercard, start with 51-56, and be 16 digits long:
         (($type == 'm') && (($d2 < 51) || ($d2 > 56) || ($len != 16))) ) {
        // Invalid card:
        return false;
    }
 // If we are still here, then time to manipulate and do the Mod 10 algorithm.  First break the number into an array of characters:
    $digits = str_split($num);
 // Now reverse it:
    $digits = array_reverse($digits);
 // Double every other digit:
    foreach(range(1, count($digits) - 1, 2) as $x) {
        $digits[$x] *= 2;
 // If this is now over 10, go ahead and add its digits, easier since the first digit will always be 1
        if ($digits[$x] > 9) {
            $digits[$x] = ($digits[$x] - 10) + 1;
        }
    }
 // Now, add all this values together to get the checksum
    $checksum = array_sum($digits);
 // If this was divisible by 10, then true, else it's invalid
    return (($checksum % 10) == 0) ? true : false;
}
 // Check various credit card numbers:
if(isset($_POST['card']) || isset($_POST['type'])){
	$nums = array(
		$_POST['card'] => 'v',
	);
	foreach ((array)$nums as $num => $type) {
		$st = standardize_credit($num);
		$valid = validate_credit($st, $type);
		$output = $valid ? 'Valid' : 'Invalid';
		echo "<p>{$st} - {$type} = {$output}</p>\n";
		if ($valid =='Invalid') {
			echo "please re-enter \n";
	}
}
}
?>
</body>
</html>
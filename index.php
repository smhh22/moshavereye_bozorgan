<?php
$FILE = fopen("people.json", "r");
$ToJSON = fread($FILE, filesize("people.json"));
$arr = json_decode($ToJSON);

$MSGFILE = fopen("messages.txt", "r");
$lineCNT = 0;
while (!feof($MSGFILE)) {
	fgets($MSGFILE);
	$lineCNT++;
}
fclose($MSGFILE);

$MSGFILE = fopen("messages.txt", "r");
$MSGarr = array();
for ($i = 0; $i < $lineCNT; $i++) {
	array_unshift($MSGarr, fgets($MSGFILE));
}
fclose($MSGFILE);

$question = $_POST["question"];

$hash = (int)crc32($question);


$msg = $MSGarr[$hash % $lineCNT];
$en_name = $_POST["person"];
#echo $arr[];
$fa_name = ":(";
$arr2 = array();

foreach ($arr as $en => $fa) {
	array_unshift($arr2, $en);
}


$A = array_rand($arr2, 1);

if (!$_POST) {
	$en_name = $arr2[$A];
	$msg = "سوال خود را بپرس!";
}

foreach ($arr as $en => $fa) {
	if ($en == $en_name) {
		$fa_name = $fa;
	}
}

$len = strlen($question);

if ($_POST && ($len <= 3 || (ord($question[$strlen - 1]) != 63 && ord($question[$strlen - 1]) != 159) || ord($question[0]) != 216 || ord($question[1]) != 162 || ord($question[2]) != 219)) {
	$msg = "سوال درستی پرسیده نشده";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
    <span id="label" <?php if(!$_POST) echo "hidden" ?>>پرسش:</span>
	<span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
	<p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
	<?php
#		echo "<p> " . 1 * (ord($question[2])). "</p>"
	?>
    <div id="new-q">
        <form method="post" action="index.php">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
	    <select name="person">
		<?php
                /*
                 * Loop over people data and
                 * enter data inside `option` tag.
                 * E.g., <option value="hafez">حافظ</option>
		 */
		foreach($arr as $VAL => $NAME) {
			if ($VAL == $en_name) {
				echo "<option value=" . $VAL . " selected>" . $NAME . "</option>";
			}
			else {
				echo "<option value=" . $VAL . ">" . $NAME . "</option>";
			}
		}
		fclose($FILE);

                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>

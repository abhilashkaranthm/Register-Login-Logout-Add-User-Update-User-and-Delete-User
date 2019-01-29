<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$query ="SELECT * FROM employer WHERE username like '" . $_POST["keyword"] . "%' ORDER BY username LIMIT 0,6";
$result = $db_handle->runQuery($query);
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectUsername('<?php echo $country["username"]; ?>');"><?php echo $country["username"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>
<?php

	include("includes/connect.php");
	include("includes/functions.php");	

if(isset($_POST['comuna'])){
$ces = getCes($_POST['comuna']);
?>
<select id="cesX" name="cesX" class="form-control required">
<option value="">Seleccionar</option>
<?php
$xcune =1;
foreach($ces as $k=>$val){
	?>
	<option value="<?php echo $k; ?>"><?php echo strtoupper($val); ?></option>
	<?php
}
?>
</select>
<?php
}
?>
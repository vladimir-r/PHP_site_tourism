<?php 
if (!isset($_SESSION['radmin']))
{
echo "<h3/><span style='color:red;'>For Administrators Only! </span><h3/>";
exit();
}
?>

<div class="row">
<div class="col-sm-6 col-md-6 col-lg-6 left">
<!-- section A: for form Countries -->
<?php
connect();
$sel='select * from countries';
$res=mysqli_query($link,$sel);
echo '<form action="index.php?page=4" method="post" class="input-group" id="formcountry">';
echo '<table class="table table-striped">';
while($row=mysqli_fetch_array($res,MYSQL_NUM)){
echo '<tr>';
echo '<td>'.$row[0].'</td>';
echo '<td>'.$row[1].'</td>';
echo '<td><input type="checkbox" name="cb'.$row[0].'"></td>';
echo '</tr>';
}
echo '</table>';
mysqli_free_result($res);
echo '<input type="text" name="country" placeholder="Country">';
echo '<input type="submit" name="addcountry" value="Add" class="btn btn-sm btn-info">';
echo '<input type="submit" name="delcountry" value="Delete" class="btn btn-sm btn-warning">';
echo '</form>';

if(isset($_POST['addcountry'])){
$country=trim(htmlspecialchars($_POST['country']));
if($country=="") exit();
$ins='insert into countries(country) values("'.$country.'")';
mysqli_query($link,$ins);
echo "<script>";
echo "window.location=document.URL;";
echo "</script>";
}
if(isset($_POST['delcountry'])){
foreach ($_POST as $k => $v) {
if (substr($k,0,2)=="cb"){
$idc=substr($k,2);
$del='delete from countries where id='.$idc;

mysqli_query($link,$del);

}
}
echo "<script>";

echo "window.location=document.URL;";

echo "</script>";
}

?>


</div>
<div class="col-sm-6 col-md-6 col-lg-6 right">
<!-- section B: for form Cities -->

<?php
echo '<form action="index.php?page=4" method="post" class="input-group" id="formcity">';
$sel='SELECT ci.id, ci.city, co.country from countries co, cities ci WHERE ci.countryid=co.id';
$res=mysqli_query($link, $sel);
echo '<table class="table table-striped">';
while ($row=mysqli_fetch_array($res, MYSQL_NUM))
{

echo '<tr>';
echo '<td>'.$row[0].'</td>';
echo '<td>'.$row[1].'</td>';
echo '<td>'.$row[2].'</td>';
echo '<td><input type="checkbox" name="ci'.$row[0].'"></td>';
echo '</tr>';
}
echo '</table>';
mysqli_free_result($res);
$res=mysqli_query($link,'select * from countries');

echo '<select name="countryname" class="form-control">';

while ($row=mysqli_fetch_array($res,MYSQL_NUM))
{
echo '<option value="'.$row[0].'">'.$row[1].'</option>';
}
echo '</select>';
echo '<input type="text" name="city" placeholder="City">';
echo '<input type="submit" name="addcity" value="Add" class="btn btn-sm btn-info">';
echo '<input type="submit" name="delcity" value="Delete" class="btn btn-sm btn-warning">';
echo '</form>';


if(isset($_POST['addcity'])){
$city=trim(htmlspecialchars($_POST['city']));
if ($city=="") exit();
$countryid=$_POST['countryname'];
$ins='insert into cities (city,countryid) values ("'.$city.'",'.$countryid.')';

mysqli_query($link,$ins);
$err=mysqli_errno($link);
if ($err){
echo 'Error code:'.$err.'<br>';
exit();

}

echo "<script>";
echo "window.location=document.URL;";
echo "</script>";
}

if(isset($_POST['delcity'])){
foreach ($_POST as $k => $v) {
if (substr($k,0,2)=="ci"){
$idc=substr($k,2);
$del='delete from cities where id='.$idc;

mysqli_query($link,$del);

}
}

echo "<script>";
echo "window.location=document.URL;";
echo "</script>";

}

?>




</div>
</div>
<hr>
<div class="row">
<div class=" col-sm-6 col-md-6 col-lg-6 left ">
<!-- section C: for form Hotels -->


<?php
echo '<form action="index.php?page=4" method="post" class="input-group" id="formhotel">';
$sel='SELECT ci.id, ci.city,
ho.id, ho.hotel, ho.cityid, ho.countryid,
ho.stars, ho.info,
co.id, co.country
from cities ci, hotels ho, countries co
WHERE ho.cityid=ci.id and ho.countryid=co.id';
$res=mysqli_query($link,$sel);
$err=mysqli_errno($link);
echo '<table class="table" width="100%">';
while ($row=mysqli_fetch_array($res,MYSQL_NUM))
{

echo '<tr>';
echo '<td>'.$row[2].'</td>';
echo '<td>'.$row[1]."-".$row[9].'</td>';
echo '<td>'.$row[3].'</td>';
echo '<td>'.$row[6].'</td>';
echo '<td><input type="checkbox" name="hb'.$row[2].'"></td>';
echo '</tr>';
}
echo '</table>';
mysqli_free_result($res);
$sel='SELECT ci.id, ci.city, co.country, co.id
from countries co, cities ci
WHERE ci.countryid=co.id';
$res=mysqli_query($link,$sel);
$csel=array();
echo '<select name="hcity" class="">';
while ($row=mysqli_fetch_array($res,MYSQL_NUM))
{

echo '<option value="'.$row[0].'">'.$row[1]." : ".$row[2].'</option>';

$csel[$row[0]]=$row[3];
}
echo '</select>';
echo '<input type="text" name="hotel" placeholder="Hotel">';
echo '<input type="text" name="cost" placeholder="Cost"><br>';
echo '&nbsp;&nbsp;Stars: <input type="number" name="stars" min="1" max="5">';
echo '<br><textarea name="info" placeholder="Description">';
echo '</textarea><br>';
echo '<input type="submit" name="addhotel" value="добавить" class="btn btn-sm btn-info">';
echo '<input type="submit" name="delhotel" value="удалить" class="btn btn-sm btn-warning">';
echo '</form>';
mysqli_free_result($res);



if(isset($_POST['addhotel'])){

$hotel=trim(htmlspecialchars($_POST['hotel']));
$cost=intval(trim(htmlspecialchars($_POST['cost'])));
$stars=intval($_POST['stars']);
$info=trim(htmlspecialchars($_POST['info']));
if ($hotel==""||$cost==""||$stars=="")

exit();

$cityid=$_POST['hcity'];
$countryid=$csel[$cityid];
$ins='insert into hotels (hotel,cityid,countryid,stars,cost,info) values("'.$hotel.'",'.$cityid; $ins.=",".$countryid.','.$stars.','.$cost.',"'.$info; $ins.='")';
mysqli_query($link,$ins);
echo "<script>";
echo "window.location=document.URL;";
echo "</script>";
}

if(isset($_POST['delhotel'])){
foreach ($_POST as $k => $v) {
if (substr($k,0,2)=="hb"){
$idc=substr($k,2);
$del='delete from hotels where id='.$idc;

mysqli_query($link,$del);
if ($err){
echo 'Error code:'.$err.'<br>';
exit();
}
}
}

echo "<script>";
echo "window.location=document.URL;";
echo "</script>";
}

?>




</div>
<div class=" col-sm-6 col-md-6 col-lg-6 right ">
<!-- section D: for form Images -->

<?php
echo '<form action="index.php?page=4" method="post" enctype="multipart/form-data" class="input-group">';
echo '<select name="hotelid">';
$sel='select ho.id, co.country,ci.city,ho.hotel
from countries co,cities ci, hotels ho
where co.id=ho.countryid and ci.id=ho.cityid
order by co.country';
$res=mysqli_query($link,$sel);
while($row=mysqli_fetch_array($res,MYSQL_NUM)){
echo '<option value="'.$row[0].'">';
echo $row[1].'&nbsp;&nbsp;'.$row[2].'&nbsp;&nbsp;'.$row[3].'</option>';
}

mysqli_free_result($res);
echo '<input type="file" name="file[]" multiple accept="image/*">';
echo '<input type="submit" name="addimage" value="Add" class="btn btn-sm btn-info">';
echo '</select>';
echo '</form>';
if(isset($_REQUEST['addimage'])){
foreach($_FILES['file']['name'] as $k => $v)

{

if($_FILES['file']['error'][$k] !=0){
echo '<script>alert("Upload
file error:'.$v.'")</script>';

continue;

}

if(move_uploaded_file($_FILES['file']['tmp_name'][$k],'images/'.$v)){

$ins='insert into

images(hotelid,imagepath)
values('.$_REQUEST['hotelid'].',"images/'.$v.'")';
mysqli_query($link,$ins);

}
}
}
echo '</div>';
?>





</div>
</div>

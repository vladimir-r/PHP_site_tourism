<?php
connect();
echo '<form action="index.php?page=6" method="post" enctype="multipart/form-data" class="input group">';
echo '<select name="userid">';
$sel='select * from users where roleid=2 order by login';
$res=mysqli_query($link,$sel);
while($row=mysqli_fetch_array($res,MYSQL_NUM)){
echo '<option value="'.$row[0].'">'.$row[1].'</option>';
}

mysqli_free_result($res);
echo '</select>';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="500000">';
echo '<input type="file" name="file" accept="image/*" required>';
echo '<input type="submit" name="addadmin" value="Add" class="btn btn-sm btn-info">';
echo '</form>';
if(isset($_POST['addadmin']))
{
$userid=$_POST['userid'];
$fn=$_FILES['file']['tmp_name'];
$file=fopen($fn,'rb');
$img=fread($file, filesize($fn));
fclose($file);
$img=addslashes($img);
$ins='update users set roleid=1, avatar="'.$img.'"  where id ='.$userid;
mysqli_query($link,$ins);
}


$sel='select * from users where roleid=1 order by login';
$res=mysqli_query($link,$sel);
echo '<table class="table table-striped">';
while($row=mysqli_fetch_array($res,MYSQL_NUM)){
echo '<tr>';
echo '<td>'.$row[0].'</td>';
echo '<td>'.$row[1].'</td>';
echo '<td>'.$row[3].'</td>';
$img=base64_encode($row[6]);
echo '<td><img height="100px" src="data:image/jpeg; base64,'.$img.'"/></td>';
}
mysqli_free_result($res);
echo '</table>';
?>

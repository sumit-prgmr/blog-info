<?php include('header.php');
require_once('./php-image-magician/php_image_magician.php');
 ?>

<!-- Start blog banner section -->
  <section id="blog-banner">
    <img src="assets/images/blog-banner.jpg" alt="img">
    <div class="blog-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="blog-banner-area">
              <h2>Add Post</h2>
              <ol class="breadcrumb">
                <li><a href="blog-archive.php">Home</a></li>                
                <li class="active">add posts</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End blog banner section -->
<center>
<div class="login-form" style="text-align:center">
<p><?php if(!empty($_SESSION['user'])){ echo "welcome    ".$_SESSION['user'];}?></p>
<h3> Add posts</h3>
<form enctype="multipart/form-data" method="post">
 <label> Title  : </label><input type="text"  name="title" required="true"></br></br>
 <label>Description:</label> <input type="text" name="desc"required="true"></br></br>
 <label>category :</label><input type="text" name="cat"required="true"></br></br>
 <input class="files" name="user_files[]" type="file" ></br></br>
  		<input type="submit" name="add" value="add post">
  </form>
  </div>
</center>
<?php 
error_reporting(E_ALL & ~E_NOTICE);
@ini_set('post_max_size', '64M');
@ini_set('upload_max_filesize', '64M');
if(isset($_POST['add']))
{
    try 
    {
    	$pdoConnect = new PDO("mysql:host=localhost;dbname=blog","root","");
    	$pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$title=$_POST['title'];
		$desc=$_POST['desc'];
		$author=$_SESSION['user'];
		$cat=$_POST['cat'];
		$date = date("d-M-Y");
		$folderName = "uploads/";
    	$sql = "INSERT INTO posts (p_id,u_id,title,body,author,date,img) VALUES (NULL, NULL, :title, :comment, :cat, '$date', :author,:img)";
		$stmt = $DB->prepare($sql);

    	for ($i = 0; $i < count($_FILES["user_files"]["name"]); $i++) 
    	{
			if ($_FILES["user_files"]["name"][$i] <> "") 
			{
				$image_mime = strtolower(image_type_to_mime_type(exif_imagetype($_FILES["user_files"]["tmp_name"][$i])));
      			if (in_array($image_mime, $valid_image_check)) 
      			{

          			$ext = explode("/", strtolower($image_mime));
          			$ext = strtolower(end($ext));
          			$filename = rand(10000, 990000) . '_' . time() . '.' . $ext;
          			$filepath = $folderName . $filename;

          			if (!move_uploaded_file($_FILES["user_files"]["tmp_name"][$i], $filepath)) 
          			{
            			$emsg .= "Failed to upload <strong>" . $_FILES["user_files"]["name"][$i] . "</strong>. <br>";
            			$counter++;
          			} 
          			else 
          			{
            			$smsg .=  'uploaded successfully';

            			$magicianObj = new imageLib($filepath);
            			$magicianObj->resizeImage(100, 100);
            			$magicianObj->saveImage($folderName . 'thumb/' . $filename, 100);
            			try 
            			{
              				$stmt->bindValue(":title", $title);
              				$stmt->bindValue(":comment", $desc);  
              				$stmt->bindValue(":cat", $cat); 
              				$stmt->bindValue(":author", $author);
              				$stmt->bindValue(":img", $filename);
              				$stmt->execute();
              				$result = $stmt->rowCount();
              				if ($result > 0) 
              				{
              					echo "file done";
               
              				}
              				else 
              				{
                				echo "failed";
              				}
						} 
						catch (PDOException $e) 
    					{
         					echo $sql . "<br>" . $e->getMessage();
   						}
   					}
   				}	
}}}
catch (PDOException $e) 
    					{
         					echo $sql . "<br>" . $e->getMessage();
   						}
}

 ?>
<?php include('footer.php') ?>
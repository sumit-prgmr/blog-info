<?php  include('header.php'); ?>
<!-- Start blog banner section -->
  <section id="blog-banner">
    <img src="assets/images/blog-banner.jpg" alt="img">
    <div class="blog-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="blog-banner-area">
              <h2>Sign up as a new user</h2>
              <ol class="breadcrumb">
                <li><a href="blog-archive.php">Home</a></li>                
                <li><a href="blog-archive.php">Blog Archive</a></li>
                <li class="active">Sign up</li>
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
<h3> Sign up</h3>
<form method="post">
 <label> Name :</label> <input type="text" name="user" ></br></br>
 <label>Email :</label> <input type="email" name="email" ></br></br>
 <label>Password :</label> <input type="text" name="password" ></br></br>
  <input type="submit" name="sign_up" value="sign up" >&nbsp;
  <button><a href="login.php">already a member</button>
  </form>
  </div>
</center>
<?php 
function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else{
      header('Location: '. $url);
      die();
    }    
}
if(isset($_POST['sign_up']))
{	
	if (!empty($_POST['user'])&&!empty($_POST['email'])&&!empty($_POST['password'])) 
	{
    	try 
    	{
 			$pdo = new PDO('mysql:host=localhost;dbname=posts', 'root', '');
 			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$name=($_POST['user']);
			$email=($_POST['email']);
			$password=($_POST['password']);
			$sql = "INSERT INTO `blog`.`users` (`id`, `name`, `email`, `pasword`) 
    		VALUES (NULL, '$name', '$email', '$password')";
			$pdo->exec($sql);
			$a=true;
		} 
    	catch (PDOException $e) 
    	{
        	echo $sql . "<br>" . $e->getMessage();
    	}
    	if ($a==true) 
    	{
    		$_SESSION['id']=$_POST['user'];
    		if (isset($_SESSION['id'])) 
    		{
    			redirect('blog-archive.php');
    		}
    		
    	}
	}
}	
 ?>
<?php include('footer.php'); ?>
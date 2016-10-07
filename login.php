<?php include('header.php'); ?>
<!-- Start blog banner section -->
  <section id="blog-banner">
    <img src="assets/images/blog-banner.jpg" alt="img">
    <div class="blog-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="blog-banner-area">
              <h2>Blog Archive</h2>
              <ol class="breadcrumb">
                <li><a href="blog-archive.php">Home</a></li>                
                <li><a href="blog-archive.php">Blog Archive</a></li>
                <li class="active">Login</li>
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
<p><?php if(isset($_GET['err'])) echo 'User/Password not correct'; ?></p>
<h3> login</h3>
<form method="post">
  <label>Username : </label>&nbsp;&nbsp;<input type="text" name="user" required="true"></br></br>
  <label>Password : </label>&nbsp;&nbsp;<input type="text" name="password" required="true"></br></br>
  <input type="submit" name="sign_in" value="sign in" >&nbsp;&nbsp;&nbsp;
  <button><a href="signup.php">signup</a></button>
  </form>
  </div>
</center>
<?php

function redirect($url)
{
    if (headers_sent())
    {
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else
    {
      header('Location: '. $url);
      die();
    }
}  
$a = false;
if(isset($_POST['sign_in']))
{ 
  try 
      {
        $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user = $_POST['user'];
        $password = $_POST['password'];
        $result = $pdo->prepare("SELECT name,pasword FROM users WHERE name= :user AND pasword= :pass");
        $result->bindParam(':user', $user);
        $result->bindParam(':pass', $password);
        $result->execute();
        $rows = $result->fetch(PDO::FETCH_NUM);
        if($rows > 0) 
        {
          $a=true; 
        } 
      }
  catch (PDOException $e) 
  {
    echo $result . "<br>" . $e->getMessage();
  }
  if ($a==true) 
      {
        $_SESSION['user']=$_POST['user'];
        if (isset($_SESSION['user'])) 
        {
          redirect('blog-archive.php');
        }
        
      } else {
        redirect('login.php?err=true');
      }
}
?>
<?php include('footer.php'); ?>
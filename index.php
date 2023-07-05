<?php
   require_once("admin/inc/config.php");

   $fetchingElections = mysqli_query($db, "SELECT * FROM election");
   while($data = mysqli_fetch_assoc($fetchingElections))
   {
     $starting_date= $data['starting_date'];
     $ending_date= $data['ending_date'];
     $curr_date= date('Y-m-d');
     $election_id= $data['id'];
     $status= $data['status'];

     if($status == "Active")
     {
        $date1=date_create($curr_date);
        $date2=date_create($ending_date);
        $diff=date_diff($date1,$date2);

        //echo $diff->format("%R%a");
        
        if((int)$diff->format("%R%a") < 0)
        {
           mysqli_query($db, "UPDATE election SET status = 'Expired' WHERE id = '". $election_id ."'");
        }
      

     }
     else if($status == "Inactive")
     {
        $date1=date_create($curr_date);
        $date2=date_create($starting_date);
        $diff=date_diff($date1,$date2);

         echo $diff->format("%R%a");

        if((int)$diff->format("%R%a") <= 0)
        {
            mysqli_query($db, "UPDATE election SET status = 'Active' WHERE id = '". $election_id ."'");
        
        }




     }



 

   }

?>
<!DOCTYPE html>
<html>
    
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/login.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<!--Coded with love by Mutiullah Samim-->
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="img/logo.png" class="brand_logo" alt="logo">
                    </div>
				</div>
                <?php
                    if(isset($_GET['sign-up'])){
                        ?>
                        <div class="d-flex justify-content-center form_container">
					<form method="POST">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="username" class="form-control input_user"  placeholder="username" required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="contact" class="form-control input_pass"  placeholder="contact" required/>
						</div>
                        <div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" placeholder="password" required/>
						</div>
                        <div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="confirm_password" class="form-control input_pass"  placeholder="confirm password" required/>
						</div>
						
						<div class="d-flex justify-content-center mt-3 login_container">
				 	    <button type="submit" name="sign_up_btn" class="btn login_btn">Sign up</button>
				       </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links text-white">
						Already created an account? <a href="index.php" class="ml-2 text-white">Sign In</a>
					</div>
					
				</div>
                <?php
                    }
                    else{
                ?>
                        <div class="d-flex justify-content-center form_container">
                        <form method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="contact" class="form-control input_user"  placeholder="contact no" required />
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control input_pass"  placeholder="password" required />
                            </div>
                           
            
                       <div class="d-flex justify-content-center mt-3 login_container">
                         <button type="submit" name="login_btn" class="btn login_btn">Login</button>
                       </div>
                        </form>
                    </div>
                    <div class="mt-4">
					<div class="d-flex justify-content-center links text-white">
						Don't have an account? <a href="?sign-up=1" class="ml-2 text-white">Sign Up</a>
					</div>
					<div class="d-flex justify-content-center links text-white">
						<a href="#" class="text-white" >Forgot your password?</a>
					</div>
				</div>
                <?php
                        
                    }
                ?>
                <?php
                  if(isset($_GET['registered']))
                    {
                        ?>
                          <span class="bg-white text-success text-center my-3"> Your account has been created successfully! </span>
                        <?php
                    }else if(isset($_GET['invalid'])){
                        ?>
                        <span class="bg-white text-danger text-center my-3"> Oops passwords mismatched!  </span>
                        <?php
                    }
                else if(isset($_GET['not-registerd'])){
                        ?>
                        <span class="bg-white text-warning text-center my-3"> Sorry,You are not registered! </span>
                        <?php
                    }
                    else if(isset($_GET['invalid_access'])){
                        ?>
                        <span class="bg-white text-danger text-center my-3"> Invalid Password! </span>
                        <?php
                    }
                ?>
				
			</div>
		</div>
	</div>
    <script src="js/jscript/bootstrap.min.js"></script>
    <script src="js/jquery"></script>
</body>
</html>
 <?php
    require_once("admin/inc/config.php");

    if(isset($_POST['sign_up_btn']))
    {
       $username=$_POST['username'];
       $contact_no=$_POST['contact'];
       $password=$_POST['password'];
       $confirm_password=$_POST['confirm_password'];
       $user_role="voter";


       if($password==$confirm_password){
        $query="INSERT INTO users(username,contact_no,password,user_role) VALUES('".$username."','".$contact_no."','".$password."','".$user_role."')";
        mysqli_query($db,$query) or die(mysqli_error($db));
        ?>
        <script> window.location.assign("http://localhost/PROJECT/Online%20voting%20system/index.php?sign-up=1&registered=1"); </script>
        <?php

        }else{
 ?>
       <script> window.location.assign("http://localhost/PROJECT/Online%20voting%20system/index.php?sign-up=1&invalid=1"); </script>

 <?php
        }
    
     }else if(isset($_POST['login_btn']))
      {
        $contact_no=$_POST['contact'];
        $password=$_POST['password'];

        $query="SELECT * FROM users WHERE contact_no = '".$contact_no."'";
        $fetch_data = mysqli_query($db,$query) or die(mysqli_error($db));

        

        if(mysqli_num_rows($fetch_data)>0)
        {
            $data = mysqli_fetch_assoc($fetch_data);
            if($contact_no==$data['contact_no'] AND $password==$data['password'])
            {
                session_start();

                $_SESSION['user_role']=$data['user_role'];
                $_SESSION['username']=$data['username'];
                $_SESSION['user_id']=$data['id'];

                if($data['user_role'] == 'Admin')
                {
                    $_SESSION['key']='AdminKey';
              ?>
               <script> window.location.assign("http://localhost/PROJECT/Online%20voting%20system/Admin/index.php?homepage=1")</script>
              <?php

                }
                else
                {
                    $_SESSION['key']='VotersKey';
              ?>
             <script> window.location.assign("http://localhost/PROJECT/Online%20voting%20system/voters/index.php")</script>
            
              <?php

                }


            }
            else
            {
  ?>
                <script> window.location.assign("http://localhost/PROJECT/Online%20voting%20system/index.php?invalid_access=1"); </script>
  <?php

            }
        }
        else{
  ?>
          <script> window.location.assign("http://localhost/PROJECT/Online%20voting%20system/index.php?sign-up=1&not-registerd=1"); </script>

         
  <?php
        }

      }
  ?>
 

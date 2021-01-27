<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>iDiscuss</title>
  </head>

<!--------------------- BODY tag starts   ------------------- -->
  <body>
  
  <?php include 'partials/db_connect.php';
        include 'partials/header.php';
        


 //-------------------Fecthing category--------------------------//       

        $id = $_REQUEST['id'];

        $query = "select * from categories where category_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt -> execute([$id]);

        while ($row = $stmt->fetch()) {
          $catname = $row['category_name'];
          $catdesc = $row['category_description'];

         }

?>

<!----------------------------- Inserting question into database ------------------------------->
  <?php

    $showalert = false;

    if ($_SERVER['REQUEST_METHOD']=="POST") {

       $thread_title = $_REQUEST['problem_title'];
       $thread_title = str_replace ( "<" ,"&lt;" ,$thread_title);
       $thread_title = str_replace ( ">" ,"&gt;" ,$thread_title);

       $thread_desc = $_REQUEST['problem_description'];
       $thread_desc = str_replace ( "<" ,"&lt;" ,$thread_desc);
       $thread_desc = str_replace ( "<" ,"&lt;" ,$thread_desc);

       $thread_catid = $id;
       $sno = $_REQUEST['sno'];

        $q = "insert into thread(thread_title,thread_desc,thread_cat_id,thrad_user_id,date) value(:th_title,:th_desc,:th_cat_id,:sno,current_timestamp())";

      $stmt = $pdo->prepare($q);
      $stmt->bindValue('th_title',$thread_title);
      $stmt->bindValue('th_desc',$thread_desc);
      $stmt->bindValue('th_cat_id',$thread_catid);
      $stmt->bindValue('sno',$sno);
      $stmt->execute();
      $showalert = true;
      if ($showalert) {
      echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your question has been submitted, please wait for community to respond.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>';
    }

    }
    


    ?>

  <!--------------------- Welcome to Forums category container   ----------------------->

     <div class="container mb-4 my-4">
            <div class="jumbotron">
                    <h1 class="display-6">Welcome to <?php echo $catname?> Forums</h1>
                    <p class="lead"><?php echo $catdesc ?></p>
                    <hr class="my-4">
                    <p>No Spam / Advertising / Self-promote in the forums.
                    Do not post copyright-infringing material.
                    Do not post “offensive” posts, links or images.
                    Do not cross post questions.
                    Do not PM users asking for help.
                    Remain respectful of other members at all times.</p>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </div>
            
    </div>



    


    <!---------- Forum questions starts here ------------->


<?php
  
  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo'  <div class="container mb-3">
        <h3 class="mb-2">Ask a Qusetions</h3>
      <form action="'. $_SERVER['REQUEST_URI'].'" method="post">
          <div class="form-group mt-3">
            <label for="exampleInputTitle">Problem Title</label>
            <input type="text" class="form-control" id="problem_title" aria-describedby="emailHelp" name="problem_title" required>
            <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
          </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Description</label>
              <textarea class="form-control" id="problem_description" rows="3" name="problem_description" required></textarea>
            </div>
          <button type="submit" class="btn btn-success">Submit</button>
      </form>

    </div>';
   } 

  else{
      echo '<div class="container">
              <h3 class="mb-2">Ask a Qusetions</h3>
              <p class="lead"> You need to login to ask a question </p>
            </div>';
  }  

?>

<!--------------------------- Browsse questions container starts here -------------------- -->

    <div class="container my-5">
      <h3 class="mt-0">Browse Qusetions</h3>
      <?php 
          $query = "select * from thread where thread_cat_id = ?";
          $stmt = $pdo->prepare($query);
          $stmt -> execute([$id]);

          $noresult = true;
          
          while ($row = $stmt->fetch()) {
              
              $thread_title = $row['thread_title'];
              $thread_desc = $row['thread_desc'];
              $thread_id = $row['thread_id'];
              $thread_date = $row['date'];
              $thread_user_id = $row['thrad_user_id'];
               $noresult = false;

              $q = "select * from users where sno=?";
              $stmt2= $pdo->prepare($q);
              $stmt2->execute([$thread_user_id]);
              $row2 =$stmt2->fetch();
              $username = $row2['user_name'];

               echo ' <div class="media my-4">
                 <img src="images/default_user.png" width="30" class="mr-3" alt="...">
                  <div class="media-body">
                    <p class="font-weight-bold py-0" >Asked by: '.$username.' at '.$thread_date.'</p>
                    <p class="mt-0"><a href="thread.php?threadid='.$thread_id.'">'.$thread_title.'</a></p>
                    <p>'.$thread_desc.'</p>
                  </div>
                </div>';


          }

         
              
            if ($noresult) {
              
              echo'<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h5 class="">No questions asked yet.</h5>
                  <p class="lead">Be the first to dicuss your concern.</p>
                </div>
              </div>';
          }
          
    ?> 
    
     
  </div>
  

  <?php include 'partials/footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
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
  <body>
  
  <?php include 'partials/db_connect.php';
        include 'partials/header.php';
        ?>

<?php
    
   
     // ------------------------Signup Check-------------------------------//

    if (isset($_REQUEST['signup'])) {
       $signup_result = $_REQUEST['signup'];
       $showalert = $_REQUEST['alert'];
       $showerror = $_REQUEST['error'];



       if ($showerror) {
         echo'<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Error! </strong>'.$showalert.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>';
       }
       elseif(!$showerror){
          echo'<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                <strong>Success! </strong>'.$showalert.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>';
       }
    }

 ?>

<!-- -----------------------LOGIN Check-------------------- ---------->

 <?php

      if (isset($_REQUEST['showalert'])) {
        $login_result = $_REQUEST['login_result'];
        $showalert = $_REQUEST['showalert'];
        
         if ($login_result) {
         echo'<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                <strong>Sucess! </strong>'.$showalert.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>';
        }

       else{
          echo'<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>Error! </strong>'.$showalert.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>';
       }
      
      }

 ?>

     <!----------- CAROUSEL ------------>

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://source.unsplash.com/1600x500/?coding,code" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://source.unsplash.com/1600x500/?apple,coding" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://source.unsplash.com/1600x500/?javascript,programming" class="d-block w-100" alt="...">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>

    <!----------- loop for fetching categories   ---------->

    


    <div class="container mb-4">
      <h3 class="text-center my-3">iDiscuss Categories</h3>
          <div class="row my-3">

              <?php  
                    $query = "select * from categories";
                    $stmt = $pdo->prepare($query);
                    $stmt -> execute();

                    while ($row = $stmt->fetch()) {
                      // echo $row['category_id'];
                      // echo $row['category_name'];

                      $category = $row['category_name'];
                      $description = $row['category_description'];
                      $catId = $row['category_id'];
                      echo ' <div class="col-md-4">
                              <div class="card mb-3" style="width: 18rem;">  
                                  <img src="https://source.unsplash.com/1600x900/?'.$category.'coding,programming" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <h5 class="card-title"><a href="threadlist.php?id='.$catId.'">'.$category.'</a></h5>
                                    <p class="card-text">'.substr($description, 0, 95).'...</p>
                                    <a href="threadlist.php?id='.$catId.'" class="btn btn-primary">View Threads</a>
                                  </div>
                              </div>
                            </div>';

                    }


               ?>


           
          </div>
    </div>



  <?php include 'partials/footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
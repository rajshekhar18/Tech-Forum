<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>iDiscuss</title>
    <style type="text/css">
      #maincontainer{ min-height: 100vh; }
    </style>
  </head>
  <body>
  
  <?php include 'partials/db_connect.php';
        include 'partials/header.php';   
  ?>

  <!-- -------------------SEARCH container starts here------------------------- -->


<div class="container my-3" id="maincontainer" style="margin-bottom: 10px;">
    <h2>Search results for <em>"<?php echo $_REQUEST['search']; ?>"</em></h2>
    <?php
    
        $search = $_REQUEST['search'];
        $query = "SELECT * FROM `thread` WHERE MATCH(thread_title,thread_desc) against('$search' )";
        $stmt = $pdo->prepare($query);
        $stmt -> execute();
        $noresult = true;
       
        while ($row = $stmt->fetch()) {
              
              $noresult = false;
              $thread_title = $row['thread_title'];
              $thread_desc = $row['thread_desc'];
              $thread_id = $row['thread_id'];

             echo' <div class="results my-3">
                  <h3><a href="thread.php?threadid='.$thread_id.'" class= "text-dark">'.$thread_title.'</a></h3>
                  <p>'.$thread_desc.'</p>
              </div>';

            }

        if ($noresult) {
            
            echo' <div class="jumbotron jumbotron-fluid">
                      <div class="container">
                        <h5 class="">No results found.</h5>
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
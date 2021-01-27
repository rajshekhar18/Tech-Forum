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

  // -----------------------Thread table fetched here---------------------------->

        $id = $_REQUEST['threadid'];

        $query = "select * from thread where thread_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt -> execute([$id]);
       
        $noresult = true;

        while ($row = $stmt->fetch()) {
              
              $noresult = false;
              $thread_title = $row['thread_title'];
              $thread_desc = $row['thread_desc'];
              $thread_user_id = $row['thrad_user_id'];

              $q = "select * from users where sno = ?";
              $stmt3 = $pdo->prepare($q);
              $stmt3->execute([$thread_user_id]);
              $row3 = $stmt3->fetch();
              $postedBy = $row3['user_name'];

          echo '<div class="container mb-4 my-4">
                  <div class="jumbotron">
                    <h1 class="display-6">'.$thread_title.'</h1>
                    <p class="lead">'.$thread_desc.'</p>
                    <hr class="my-4">
                    
                    <p>Posted by: <b>'.$postedBy.'</b></p>
                  </div>  
            
                </div>';


        }
        
      ?>
  <!------------------------ Comment Form starts here ------------------------------>
<?php
     if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo'<div class="container mb-3">
          <h3 class="mb-2">Post a comment</h3>
        <form action="'. $_SERVER['REQUEST_URI'].'" method="post">
            
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" rows="3" name="comment" required></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
              </div>
            <button type="submit" class="btn btn-success">Post comeent</button>
        </form>

        </div>';
      }
      else{
         echo '<div class="container">
              <h3 class="mb-2">Post a comment</h3>
              <p class="lead"> You need to login to post a comment. </p>
            </div>';
      }
?>
 <!----------- Discussion container starts here -------------->
         <div class="container">
              <h3 class="mt-0">Discussions</h3>

              <?php
              $noresult = true;
              $id = $_REQUEST['threadid'];

//----------------- Comment insertion and fetching----------------------- //       
             
          if ($_SERVER['REQUEST_METHOD'] == "POST") {

              $comment_text = $_REQUEST['comment'];
              $comment_text = str_replace ( "<" ,"&lt;" ,$comment_text);
              $comment_text = str_replace ( ">" ,"&gt;" ,$comment_text);
              $sno = $_REQUEST['sno'];
              $insert = "insert into comments(comment_text,thread_id,comment_by,comment_time) value(:com_text,:thid,:commentby,current_timestamp())";
              $stmt1 = $pdo->prepare($insert);
              $stmt1->bindValue('com_text',$comment_text);
              $stmt1->bindValue('thid',$id);
              $stmt1->bindValue('commentby',$sno);
              $stmt1-> execute();

              $query = "select * from comments where thread_id = ?";
              $stmt = $pdo->prepare($query);
              $stmt -> execute([$id]);
             
                  
              while ($row = $stmt->fetch()) {
                    
                    $noresult = false;
                    $comment = $row['comment_text'];
                    $comment_by = $row['comment_by'];
                    $comment_time = $row['comment_time'];

                    $q = "select * from users where sno=?";
                    $stmt2= $pdo->prepare($q);
                    $stmt2->execute([$comment_by]);
                    $row2 =$stmt2->fetch();
                    $username = $row2['user_name'];                                            
                 
                 echo ' <div class="media my-4">
                       <img src="images/default_user.png" width="30" class="mr-3" alt="...">
                        <div class="media-body">
                          <p class="font-weight-bold">'.$username.' at '.$comment_time.'</p>
                          <p>'.$comment.'</p>
                        </div>
                      </div>';
                  }



             }     

          if ($noresult) {
            
            echo'<div class="jumbotron jumbotron-fluid">
                      <div class="container">
                        <h5 class="">No comments yet.</h5>
                        <p class="lead">Be the first to comment.</p>
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
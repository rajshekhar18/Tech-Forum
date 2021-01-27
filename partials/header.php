<?php session_start(); 

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/forum">i-Discuss</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/forum">Home <span class="sr-only">(current)</span></a>
      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Top Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

     $sql = "select category_id,category_name from categories";
     $stmt = $pdo->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch()) {    
  
     echo'
          <a class="dropdown-item" href="threadlist.php?id='.$row['category_id'].'">';echo ''.$row['category_name'].'</a>
         
         ';
    } 
        
        echo'</div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>

 
        <div class="row mx-2">';

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
          
          echo '<form class="form-inline my-2 my-lg-0 mx-2" action="search.php">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0"  type="submit">Search</button>
               <p class="text-light mx-2 my-0">Welcome '.$_SESSION['username'].'</p>
               <a href="partials/logout.php" class="btn btn-success">Logout</a>
              </form>';
             
        }
 
       else{ 
      
           echo '<form class="form-inline my-2 my-lg-0" action="search.php">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0"  type="submit">Search</button>
              </form>
              <div class="mx-1">
              <button class="btn btn-success" data-toggle="modal" data-target="#login_modal">Login</button>
              <button class="btn btn-success" data-toggle="modal" data-target="#signupmodal">Signup</button>
              </div>';
            
        }
  

   echo '</div>
  </div>
</nav>';
?>  
 <?php include 'partials/login_modal.php';
       include 'partials/signupmodal.php';
         ?>
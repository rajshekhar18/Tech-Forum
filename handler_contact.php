<?php
    include 'db_connect.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email = $_REQUEST['email'];
        $name = $_REQUEST['name'];
        $message = $_REQUEST['message'];

        $query = "insert into contact(Email,Name,Message,Date) value(:email,:name,:message,current_timestamp())";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue('email',$email);
        $stmt->bindValue('name',$name);
        $stmt->bindValue('message',$message); 

        $stmt->execute();
        //echo'Hello';
    
        header("Location:contact.php?result=success");
    }


?>
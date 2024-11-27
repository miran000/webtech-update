<?php

if (!empty($_POST['fullName']) && 
    !empty($_POST['id']) && 
    !empty($_POST['email']) && 
    !empty($_POST['books']) && 
    !empty($_POST['token']) && 
    !empty($_POST['borrowDate']) && 
    !empty($_POST['returnDate'])) {

        if(isset($_POST['fullName']) &&
        isset($_POST['id']) &&
        isset($_POST['email']) && 
        isset($_POST['books']) && 
        isset($_POST['token']) && 
        isset($_POST['borrowDate']) && 
        isset($_POST['returnDate']))
        {
            //Student Name
            if(preg_match("/^[a-zA-Z. ]*$/", $_POST['fullName'])){
            $StudentName = ucwords($_POST['fullName']);
            }
            else{
                echo "Error. Name only contains A-Z and dots"; exit;
            }  
            

            //Student ID
            if (preg_match("/^\d{2}-\d{5}-\d{1}$/", $_POST['id'])) {
            $StudentId = $_POST['id'];
            } else {
                echo "Error. ID must be in the **-*****-* format.";
                exit;
            }


            //Student Email
            if(preg_match("/^\d{2}-\d{5}-\d{1}@student\.aiub\.edu$/", $_POST['email'])){
            $StudentEmail = $_POST['email'];
            } 
            else{
                echo "Error. Must put aiub student email";
                exit;
            }


            //Token
            if(preg_match("/^[0-9]*$/", $_POST['token'])){
                $Token = $_POST['token'];
            }
            else{
                echo "Error. Token must contain numbers only.";
                exit;
            }

            //Book Name
            $BookName = $_POST['books'];
            $cookie_name = preg_replace("/[^a-zA-Z0-9]/", "", trim($BookName));;
            $cookie_value = $StudentName;


            //Number of days borrowed
            $presentDate = new DateTime();
            $borrowDateObj = new DateTime($_POST['borrowDate']);
            $returnDateObj = new DateTime($_POST['returnDate']);

            if ($borrowDateObj < $presentDate->setTime(0,0,0) || $returnDateObj < $presentDate || $borrowDateObj == $returnDateObj) {
                echo "Date Error! Borrow date and return date must be in the future.";
                exit;
            }


            $BorrowDate = $_POST['borrowDate'];
            $ReturnDate = $_POST['returnDate'];
        
            $date1 = date_create($BorrowDate);
            $date2 = date_create($ReturnDate);
            
            $interval = date_diff($date1, $date2);

            if($interval->days > 10){
                echo "Date Error! Books can be borrowed for only 10 days.";
                exit;

            }
            else {

                if(isset($_COOKIE[$cookie_name])){

                    echo "Error. Book already borrowed by someone.";
                    exit;

                }
                else{

                    //Set Cookies

                    setcookie($cookie_name, $cookie_value, time() + (86400*10), "/");

                    
                    //Print if everything is ok.
                    echo "Borrow Successfull.";

                    echo "<div style='width: 400px; margin: 0 auto; padding:50px; border:1px solid #333; font-family: Arial, sans-serif;'>";
                    echo "<h2 style='text-align: center; font-size: 0.9em; color:#666;'> Thank you for borrowing the book</h2>";
                    echo "<hr style ='border: 1px solid #333;'><br>";
                    echo "<p>Full Name:  $StudentName</p>";
                    echo "<p>Student ID:  $StudentId</p>";
                    echo "<p>Student Email:  $StudentEmail</p>";
                    echo "<p>Book Name:  $BookName</p>";
                    echo "<p>Token No.:  $Token</p>";
                    echo "<p>Borrow Date:  $BorrowDate</p>";
                    echo "<p>Return Date:  $ReturnDate</p>";
                    echo "</div>";

                    $qrContent = "Student Name: $StudentName\nBook Name: $BookName\nBorrow Date: $BorrowDate\nReturn Date: $ReturnDate";
                   
                  

                    echo "</div>";
                        

                }        

            }


        }
        else{
            echo "Input Error.";
        }


    }
    else{
        echo "Empty Fields.";
    }


?>
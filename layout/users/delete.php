<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Delete Item</title>
  <link rel="shortcut icon" href="/YARAY_HOTEL/images/YARAY2-removebg-preview.png" type="image/x-icon">
  <style>
    /* Style for the confirmation box */
    body{
        background-color: rgba(0, 0, 0, 0.5);
        background-image: url(/YARAY_HOTEL/images/home_page.jpg);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height:100svh
    }
    .confirmation-box {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      z-index: 9999;
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.5;
      text-align: center;
      color: #333;
      border-radius: 6px;
      max-width: 400px;
      min-width: 300px;
    }
    
    /* Style for the buttons */
    .btn {
      display: inline-block;
      padding: 8px 12px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s ease-in-out;
    }
    .btn a{
        text-decoration: none;
        color: #000000;
    }
    .btn:hover {
      background-color: #3e8e41;
    }
    
    /* Style for the heading */
    .heading {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }
  </style>
  <script>
        function goBack() {
          window.history.back();
        }
  </script>
</head>
<body>
  <!-- <button onclick="showConfirmationBox()">Delete Item</button> -->
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hotel";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $code_delete = @$_POST['code_again'];
        $sql_check = "SELECT uqcode FROM reserved_rooms WHERE uqcode = $code_delete";
        $result_check_is_there = $conn->query($sql_check);
        if ($result_check_is_there->num_rows > 0) {
          $sql_cancelled = "SELECT * FROM reservation WHERE uqcode = '$code_delete'";
          $result_cancel = $conn->query($sql_cancelled);
          $result_cancel_row = $result_cancel->fetch_assoc();
          $check_in = @$result_cancel_row['check_in'];
          if ($check_in > date('Y-m-d')) {
            $id = @$result_cancel_row['id'];
            $name = @$result_cancel_row['client_name'];
            $email = @$result_cancel_row['client_email'];
            $check_out = @$result_cancel_row['check_out'];
            $room_type = @$result_cancel_row['room_type'];
            $phone = @$result_cancel_row['room_type'];
            $room_type = @$result_cancel_row['room_type'];
            $room_id = @$result_cancel_row['room_id'];
            $num_adults = @$result_cancel_row['num_of_adults'];
            $num_children = @$result_cancel_row['num_of_children'];
            $uqcode = @$result_cancel_row['uqcode'];
            $sql_insert = "INSERT INTO cancelled_reservations (id,client_name, client_email, room_type, phone_number, check_in, check_out, num_of_adults, num_of_children, room_id ,uqcode)
            VALUES ('$id','$name','$email','$room_type','$phone','$check_in','$check_out','$num_adults','$num_children','$room_id','$uqcode')";
            $result_insertion = $conn->query($sql_insert);
            if ($sql_insert) {
              $sql_delete = "DELETE FROM reservation WHERE uqcode = '$code_delete'";
              $sql_delete2 = "DELETE FROM reserved_rooms WHERE uqcode = '$code_delete'";
              $result1 = $conn->query($sql_delete);
              $result2 = $conn->query($sql_delete2);
              if ($result1 && $result2) {
                
                  echo '<div id="confirmation-box" class="confirmation-box">
                  <h2 class="heading">Reservation has been deleted</h2>
                  <button class="btn"><a href="index.html">OK</a></button>
                  </div>';
                  
              }else{
                  echo "manakhdmch";
              }
            }
          }else {
            echo '<div id="confirmation-box" class="confirmation-box">
            <h2 class="heading">You can not delete the reservation</h2>
            <button class="btn" onclick="goBack()">Go back</button>
           </div>';
          }

        }else {
          echo '<div id="confirmation-box" class="confirmation-box">
          <h2 class="heading">Code is incorrect, <br/> Try again</h2>
          <button class="btn" onclick="goBack()">Go back</button>
         </div>';
      
        }


    ?>


</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/YARAY_HOTEL/images/YARAY2-removebg-preview.png" type="image/x-icon">

    <title>YARAY</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            overflow: hidden;
            background-image: url(/YARAY_HOTEL/images/home_page.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .personal_infos{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            height: 100svh;
        }
        .lines{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 1rem;
            
        }
        .lines hr{
            border: solid black 1.5px;
            width: 30%;
            margin-top: 10px;
        }
        .lines h1{
            text-align: center;
        }
        
        .infos{
            background-color: rgba(240, 240, 240,.6);
            backdrop-filter: blur(5px);
            display: flex;
            color: white;
            flex-direction: column;
            gap: 1.8rem;
            padding: 1rem;
            border-radius: 5px;
            border: solid black 1px;
            
        }
        .infos p{
            color: black;
        }
        .infos hr{
            border: solid black 1px;
            width: 100%;
            margin-bottom: -25px;
        }
        .buttons{
            display: flex;
            justify-content: space-between;
        }
        .buttons a{
            color: black;
            text-decoration: none;
            margin-top: 13px;
        }
        .buttons button{
            padding: 5px;
            background-color: rgba(0,0,0,.7);
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: all .2s;
        }
        .buttons button:hover{
            transform: scale(1.07);
        }

        /*pop up window*/
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
          }
          
          .modal-content {
            background-color: #fefefe;
            margin: 20% auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 50%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.3);
          }
          
          .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
          }
          
          .close:hover,
          .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
          }
          
          h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 28px;
          }
          
          .modal input[type="number"] {
            width: 80%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
          }
          
          button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
          }
          @media screen and (max-width:640px){
            .modal-content{
              width: 70%;
            }
            .lines{
                margin-top: -2rem;
            }
          }
    </style>
        <script>
        function openCodeInput() {
            document.getElementById("code-input-modal").style.display = "block";
            
        }
          
          function closeCodeInput() {
            document.getElementById("code-input-modal").style.display = "none";
        }
          
    </script>
</head>
<body>
    <div id="code-input-modal" class="modal">
        <form class="modal-content" action="/YARAY_HOTEL/layout/users/delete.php" method="post">
        <span class="close" onclick="closeCodeInput()">&times;</span>
        <h2>Please Enter Code again</h2>
        <input type="number" name="code_again" placeholder="Enter code">
        <button name="submit" type="submit">Submit</button>
        </form>
    </div>
    <div class="personal_infos">
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
            $search = @$_POST['search'];
            // Perform query
            $sql = "SELECT * FROM reservation WHERE uqcode = '$search'";
            $result = $conn->query($sql);
            $result_row_infos = $result->fetch_assoc();
        ?>

        <div class="lines">
            <hr><h1>Admin Dashboard</h1><hr>
        </div>
        <div class="infos">
            <?php

                if ($result->num_rows > 0) {
                    echo "<p>ID RESERVATION : ". $result_row_infos['id'] ."</p>";
                    echo "<p>NAME : ". $result_row_infos['client_name'] ."</p>";
                    echo "<p>EMAIL : ". $result_row_infos['client_email'] ."</p>";
                    echo "<p>PHONE NUMBER : ". $result_row_infos['phone_number'] ."</p>";
                    echo "<p>CIN : ". $result_row_infos['cin'] ."</p>";
                    echo "<p>ROOM TYPE : ". $result_row_infos['room_type'] ."</p>";
                    echo "<p>CHECK-IN DATE : ". $result_row_infos['check_in'] ."</p>";
                    echo "<p>CHECK-OUT DATE : ". $result_row_infos['check_out'] ."</p>";
                    echo "<p>ADULTS : ". $result_row_infos['num_of_adults'] ."</p>";
                    echo "<p>CHILDREN : ". $result_row_infos['num_of_children'] ."</p>";
                    echo "<p>AFFECTED ROOM: ". $result_row_infos['room_id'] ."</p>";
                } else {
                    echo 'laa makaynch';

                }

                $conn->close();
            ?>
            <hr>
            <div class="buttons">
                <a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">back home</a>
                <button onclick="openCodeInput() ">delete reservation</button>
            </div>
            

            
        </div>

    </div>


</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/YARAY_HOTEL/images/YARAY-removebg-preview.png" type="image/x-icon">
    <title>YARAY</title>
    <style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial;
}

body{
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background-image: url(/YARAY_HOTEL/images/pool.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.room_availability{
    height: fit-content;
    max-width: 800px;
    margin: 30px;
    background-color: rgba(255, 255, 255 ,0.7);
    color: black;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    border-radius: 5px;
    padding: 1rem;
    text-align: center;
    box-shadow: 5px 5px 5px rgba(0, 0, 0, .4);
}

.room_availability h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.room_availability p{
    font-size: 1.2rem;
}

.room_availability > a{
    margin-top: 1rem;
    text-decoration: none;
    font-size: 1.2rem;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease-in-out;
}

.room_availability > a:hover {
    background-color: #0062cc;
}


    </style>
</head>
<body>
    <div class="room_availability">
        <h2>availability</h2>
        <p>
            <?php
                if (isset($_POST['check'])) {
                    
                    $servername = "localhost"; 
                    $username = "root";
                    $password = "";
                    $dbname = "hotel";


                    $conn = new mysqli($servername, $username, $password, $dbname);


                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // get the form data
                    $checkIn = $_POST['check_in'];
                    $checkOut = $_POST['check_out'];
                    $adults = $_POST['adults'];
                    $children = $_POST['children'];
                    $roomType = $_POST['room_type'];

                    if ($checkIn < $checkOut && $checkIn >= date('Y-m-d')) {
                        // checking the data and comparing
                        $sql = " SELECT id_room FROM rooms
                        WHERE room_type = '$roomType'
                        AND max_adults >= '$adults'
                        AND max_children >= '$children'
                        AND id_room NOT IN (
                            SELECT id_room FROM reserved_rooms
                            WHERE ((room_reserved_date_in <= '$checkIn' AND room_reserved_date_in >= '$checkOut') 
                            OR (room_reserved_date_out >= '$checkIn' AND room_reserved_date_out <= '$checkOut' )
                            OR (room_reserved_date_out >= '$checkIn' AND room_reserved_date_out >= '$checkOut' ))
                        )";
                        $result = $conn->query($sql);

                        if ($result) {
                            // get rows number 
                            $numRows = $result->num_rows;
                            // echo $numRows;
                            // echo "<br>";
                            if ($numRows > 0) {
                                echo "Rooms are available. Please proceed with booking.";

                                
                            } else {
                                echo "Sorry, no rooms are available for the specified infos you entered.";

                            }

                            $result->free();
                        } 
                        else{
                            echo "query didnt execute";
                        }
                    }else{
                        echo "The date you entered is invalid";
                    }
                    // Close the database connection
                    $conn->close();
                    }
            ?>
        </p>
        <a href="index.html">back to home</a>
        
    
    </div>
    <script>
        // setTimeout(function(){
        //     window.location.href = "index.html";
        //   }, 2500);
    </script>
</body>
</html>
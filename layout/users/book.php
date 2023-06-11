<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e1688b77c2.js" crossorigin="anonymous"></script>

    <title>YARAY</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }
        body{
            height: 100svh;
            width: 100%;
            display: flex;
            justify-content: center;
            padding-top: 10%;
            background-image: url(/YARAY_HOTEL/images/pool.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 15px;

        }
        .booking-validation{
            height: fit-content;
            width: auto;
            margin-top: 10%;
            background-color: rgba(255, 255, 255 , .7);
            text-align: center;
            color: black;
            display: flex;
            box-shadow: 0px 5px 5px rgba(0, 0,0 , .4);
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            border-radius: 5px;
            padding: 15px;
        }
        .booking-validation p{
            font-size: 1.5rem;
        }
        .booking-validation p i:nth-child(1){
            font-size: 1.7rem;
            color: greenyellow;
        }
        .booking-validation > div > a{
            font-size: 1.7rem;
            color: black;
            cursor: pointer;
        }
        .booking-validation p i:nth-child(2){
            font-size: 1.7rem;
           
        }
        @media screen and (max-width:330px){
            .booking-validation{
                padding: 8px;
            }
            
        }

    </style>

</head>
<body>
    <div class="booking-validation">
        <p><?php
        use PHPMailer\PHPMailer\PHPMailer;
        require_once '/xampp/htdocs/YARAY_HOTEL/PHPMailer/src/Exception.php';
        require_once '/xampp/htdocs/YARAY_HOTEL/PHPMailer/src/SMTP.php';
        require_once '/xampp/htdocs/YARAY_HOTEL/PHPMailer/src/PHPMailer.php';
        // Retrieve reservation details from the form



        $client_name = $_POST['client_name'];
        $client_email = $_POST['client_email'];
        $room_type = $_POST['room_type'];
        $phone_number = $_POST['phone_number'];
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];
        $num_of_adults = $_POST['num_of_adults'];
        $num_of_children = $_POST['num_of_children'];
        $cin = $_POST['CIN'];

        $servername = "localhost"; // Replace with your database server name
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "hotel"; // Replace with your database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($check_in < $check_out && $check_in >= date('Y-m-d')) {
            
                // Check if there is an available room for the specified date and room type
                $sql_check_room = "SELECT id_room FROM rooms
                WHERE room_type = '$room_type'
                AND max_adults >= '$num_of_adults'
                AND max_children >= '$num_of_children'
                AND id_room NOT IN (
                    SELECT id_room FROM reserved_rooms
                    WHERE ((room_reserved_date_in <= '$check_in' AND room_reserved_date_in >= '$check_out') 
                    OR (room_reserved_date_out >= '$check_in' AND room_reserved_date_out <= '$check_out' )
                    OR (room_reserved_date_out >= '$check_in' AND room_reserved_date_out >= '$check_out' ))
                )
                LIMIT 1";

                $result_check_room = $conn->query($sql_check_room);
                $row_check_room = $result_check_room->fetch_assoc();
                echo $row_check_room['id_room'];
                echo "<br>";
                if ($result_check_room->num_rows >= 1) {
                    // There are enough available rooms, proceed with reservation
                    $room_id = $row_check_room['id_room'];
                    $code = rand(100000000 , 999999999);//the unique code
                    $sql_codes = "SELECT uqcode FROM reservation ";
                    $sql_codes_results = $conn->query($sql_codes);
                    $existing_codes = array();
                    while ($row_check_codes = $sql_codes_results->fetch_assoc()) {
                        $existing_codes[] = $row_check_codes['uqcode'];
                    }
                    while (in_array($code, $existing_codes)) {
                        
                        $code = rand(100000000, 999999999);
                    }
                    // Insert reservation details into reservation table
                    $sql = "INSERT INTO reservation (client_name, client_email, room_type, phone_number, check_in, check_out, num_of_adults, num_of_children, room_id ,uqcode,cin)
                            VALUES ('$client_name', '$client_email', '$room_type', $phone_number, '$check_in', '$check_out', $num_of_adults, $num_of_children, $room_id ,$code,'$cin')";
                    $result = $conn->query($sql);

                    if ($result) {
                        // Update the room reservation dates in the rooms table
                        $sql2 = "INSERT INTO reserved_rooms (id_room,room_reserved_date_in,room_reserved_date_out ,uqcode) VALUES ('$room_id','$check_in','$check_out','$code')";
                        $result2 = $conn->query($sql2);

                        if ($result2) {
                            echo 'Room reserved successfully! <i class="fa-solid fa-circle-check"></i> ';
            
                            // Create a new PHPMailer instance
                            $mail = new PHPMailer(true);

                            // SMTP configuration
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'YARAYHOTEL@gmail.com';
                            $mail->Password = 'cbmovduffcpvwalr';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            // Sender and recipient settings
                            $mail->setFrom('YARAYHOTEL@gmail.com');
                            $mail->addAddress($_POST['client_email']);

                            // Email content
                            $mail->isHTML(true);
                            $mail->Subject = 'Hotel Reservation Confirmation';
                            $mail->Body = 'Dear ' . $_POST['client_name'] . ',<br><br>Thank you for your reservation. Your unique code is ' . $code . '.<br><br>Enjoy with us,<br>The YARAY Team';
                            
                            // Send email
                            if ($mail->send()) {
                                echo 'Confirmation email sent';
                                header('location:success.html?');

                            } else {
                                $mail->ErrorInfo;
                                echo 'Error sending email';
                            }


                        } else {
                            echo "Failed to insert into reserved_rooms .";
                        }
                    } else {
                        echo "Failed to insert reservation details.";
                    }
                } else {
                    echo 'Sorry, No available rooms for the specified info you entered! <i style="color:red;" class="fa-solid fa-circle-exclamation"></i>';
                    header('location:failure.html?');
                }
        }else{
            echo "You entered an invalid date !!";
        }
        $conn->close();
    ?>
    </p>
    <div id="link_home"><a href="index.html"><i class="fa-solid fa-house"></i></a></div>
    
    </div>
    <script>
        // setTimeout(function(){
        //     window.location.href = "index.html";
        //   }, 2500);
    </script>
</body>
</html>
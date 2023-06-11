<?php
    $encoded_encoded_id = $_GET['id'];

    // decode the encoded id value using base64 decoding
    $encoded_id = base64_decode($encoded_encoded_id);
    $id = base64_decode($encoded_id);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotel";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM admins WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $infos = $result->fetch_assoc();
        $name = $infos['admin_name'];
    } else {
        echo "sir awa sir ";
    }

    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - YARAY</title>
    <link rel="shortcut icon" href="/YARAY_HOTEL/images/YARAY2-removebg-preview.png" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;0,900;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Playfair Display;
            font-size: 16px;
            overflow-x: hidden;
            object-fit: cover;
            background-color: rgb(240, 240, 240);
        }

        .sidebar {
            position: fixed;
            z-index: 10;
            top: 0;
            left: 0;
            height: 100%;
            width: 200px;
            background-color: #333;
            color: #fff;
        }

        .sidebar .logo {
            font-size: 24px;
            font-weight: bold;
            padding: 20px;
            text-align: center;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav li {
            padding: 10px;
        }

        .sidebar nav li a {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        .sidebar nav li a:hover {
            background-color: #444;
        }

        .main-content {
            margin-left: 200px;
            padding: 20px;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .search-wrapper{
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .search-wrapper form.search-form {
            display: inline-block;
            margin: 0 20px;
            position: relative;
        }

        .search-wrapper form.search-form input[type="number"] {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
            width: 200px;
        }

        .search-wrapper form.search-form button[type="submit"] {
            position: absolute;
            right: 0;
            top: 0;
            background-color: #333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .search-wrapper form.search-form button[type="submit"]:hover {
            background-color: #444;
        }

        .date_picker {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
        }

        .date_wrraper {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: center;
            width: 25%;
        }

        .date_picker input {
            height: 2rem;
            width: 100%;
            outline: none;
        }

        .OK {
            margin-top: 10px;
            display: flex;
            justify-content: center;

        }

        .OK input {
            width: 20%;
            height: 2rem;
            border-radius: 7px;
            font-size: 1.05rem;
            font-weight: bold;
            background-color: rgba(65, 65, 65, .4);
        }

        .date_wrraper select {
            height: 2.2rem;
            width: 100%;
            outline: none;

            cursor: pointer;

        }

        .date_wrraper select option {
            background-color: rgba(0, 0, 0, 0.389);
            color: #000;
        }

        header h1 {
            flex: 1;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info p {
            margin: 0;
            padding-right: 20px;
        }

        .user-info img {
            border-radius: 50%;
            height: 80px;
            cursor: pointer;
        }

        .status-box {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            
        }

        .status-item {
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 5px 5px rgba(0, 0, 0, .2);
            width: 30%;
        }

        .booking-status {
            margin-top: 50px;
        }

        .customer-list {
            margin-top: 50px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        thead {
            background-color: #eee;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }
        
        #menu-icon {
            display: none;
            color: #333;
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
            margin-right: 10px;
        }

        .sidebar-close {
            position: relative;
        }

        #sidebar-icon {
            font-size: 20px;
            color: #fff;
            display: none;
            position: absolute;
            top: 35%;
            right: 5%;
        }

        /*pop up input*/
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
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
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
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

        .modal h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 28px;
        }


        .modal button a {
            text-decoration: none;
            color: #fff;
        }

        .modal button {
            background-color: #4CAF50;
            margin-left: 10px;
            color: white;
            padding: 12px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        @media screen and (max-width:640px) {
            .modal-content {
                width: 70%;
            }
        }

        /*second pop up window */
        .popup {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .infos_container {
            background-color: #333;
            padding: 10px;
            border: none;
            border-radius: 1.5rem;
            color: #fff;
        }

        .popup-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            position: relative;
            top: 50%;
            background-color: #eee;
            border-radius: 1.5rem;
            transform: translateY(-50%);
        }

        .popup-content img {
            width: 200px;
            border-radius: 50%;
        }

        .popup-content h1 {
            color: black;
            font-size: 18px;
            margin-top: 20px;
        }

        .close {
            color: black;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }

        @media screen and (max-width:740px) {
            body {
                font-size: 13px;
            }

            .sidebar,
            .popup-content {
                font-size: 15px;
            }
        }

        @media screen and (max-width:574px) {
            body {
                font-size: 11px;
            }

            .sidebar {
                display: none;
            }


            #menu-icon,
            #sidebar-icon {
                display: block;
            }

            .main-content {
                margin-left: 0px;
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

        function openPopup() {
            document.getElementById("popup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
    <script src="https://kit.fontawesome.com/e1688b77c2.js" crossorigin="anonymous"></script>

</head>

<body>
    <div id="code-input-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCodeInput()">&times;</span>
            <h2>You sure you want to log out?</h2>
            <button type="submit"><a href="authentication.php">Yes</a></button>
            <button type="submit" onclick="closeCodeInput()">No</button>
        </div>
    </div>
    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <?php
            if ($id == 1) {
                echo '<img src="/YARAY_HOTEL/images/admins_pics/Yassine-el-hamdaoui-removebg.png" alt="Admin Avatar">';
                echo '<h1>EL Hamdaoui Yassine</h1>';
                echo '<div class="infos_container">
                <p>Role: Front Desk Manager</p>
                <p>Badge ID: 12345</p>
                <p>Years of Experience: 5</p>
                <p>Education: Bachelor of Business Administration</p>
                <p>Languages: Arabic, English, French</p>
                <p>Hobbies: Travel, Photography</p>
            </div>';
            } elseif ($id == 2) {
                echo '<img src="/YARAY_HOTEL/images/admins_pics/rahma_elatrach.png" alt="Admin Avatar">';
                echo '<h1>Rahma El atrach</h1>';
                echo '<div class="infos_container">
                    <p>Role: Head Chef</p>
                    <p>Badge ID: 54321</p>
                    <p>Years of Experience: 10</p>
                    <p>Education: Culinary Arts Diploma</p>
                    <p>Cuisine Specialties: Italian, French, Japanese</p>
                    <p>Hobbies: Cooking, Fishing</p>
            </div>
            ';
            } elseif ($id == 3) {
                echo '<img src="/YARAY_HOTEL/images/admins_pics/ayoub_pic-removebg-preview.png" alt="Admin Avatar">';
                echo '<h1>Ayoub El yaakoubi</h1>';
                echo '<div class="infos_container">
                <p>Role: Housekeeping Manager</p>
                <p>Badge ID: 98765</p>
                <p>Years of Experience: 7</p>
                <p>Education: Bachelor of Hotel Management</p>
                <p>Languages: Arabic, English, Spanish</p>
                <p>Hobbies: Reading, Yoga</p>
            </div>
            ';
            }
            ?>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-close">
            <div class="logo">YARAY</div>
            <i class="fa-solid fa-x" id="sidebar-icon"></i>
        </div>

        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Rooms</a></li>
                <li><a href="#">Bookings</a></li>
                <li><a href="#">Customers</a></li>
                <li><a href="#">Reports</a></li>
                <li><a onclick="openCodeInput()">Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <!-- Add a div to hold the modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="name"></h2>
                <p id="post"></p>
            </div>

        </div>

        <header>
            <i class="fa-solid fa-bars" id="menu-icon"></i>
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                <p>Welcome, <?php echo $name; ?></p>
                <?php
                if ($id == 1) {
                    echo '<img onclick="openPopup()" src="/YARAY_HOTEL/images/admins_pics/Yassine-el-hamdaoui-removebg.png" alt="Admin Avatar">';
                } elseif ($id == 2) {
                    echo '<img onclick="openPopup()" src="/YARAY_HOTEL/images/admins_pics/rahma_elatrach.png" alt="Admin Avatar">';
                } elseif ($id == 3) {
                    echo '<img onclick="openPopup()" src="/YARAY_HOTEL/images/admins_pics/ayoub_pic-removebg-preview.png" alt="Admin Avatar">';
                }
                ?>

            </div>
        </header>
        <div class="search-wrapper"> 
                <form action="personal_infos.php" method="post" class="search-form">
                    <input type="number" name="search" placeholder="Search...">
                    <button type="submit"><i class="fa-solid fa-search"></i></button>
                </form>
            </div>
        <form action="<?php echo 'admins.php?id=' . $encoded_encoded_id; ?>" method="post">
            <div class="date_picker">
                <div class="date_wrraper">
                    <label for="">in_date :</label>
                    <input type="date" class="date" name="in_date" >
                </div>
                <div class="date_wrraper">
                    <label for="">out_date :</label>
                    <input type="date" class="date" name="out_date" >
                </div>
                <div class="date_wrraper">
                    <label for="">type_room :</label>
                    <select id="room-type" name="room_type" required>
                        <option value="single">Single Room</option>
                        <option value="double">Double Room</option>
                    </select>
                </div>
            </div>
            <div class="OK">
                <input type="submit" name="ok" value="OK">
            </div>
            <section>
                <h2>Room Status</h2>
                <div class="status-box">
                    <div class="status-item">
                        <h3>Total Rooms</h3>
                        <p>30</p>
                    </div>
                    <div class="status-item">
                        <h3>Available Rooms</h3>
                        <p>
                            <?php
                            $in_date = @$_POST['in_date'];
                            $out_date = @$_POST['out_date'];
                            $type_room = @$_POST['room_type'];
                            $sql_available_rooms = "SELECT id_room FROM rooms
                                                        WHERE room_type = '$type_room'
                                                         AND id_room NOT IN (
                                                            SELECT id_room FROM reserved_rooms
                                                            WHERE ((room_reserved_date_in <= '$in_date' AND room_reserved_date_in >= '$out_date') 
                                                            OR (room_reserved_date_out >= '$in_date' AND room_reserved_date_out <= '$out_date' )
                                                            OR (room_reserved_date_out >= '$in_date' AND room_reserved_date_out >= '$out_date' ))
                                                        );";
                            $result_available_rooms = $conn->query($sql_available_rooms);
                            if ($result_available_rooms) {
                                echo $result_available_rooms->num_rows;
                            } else {
                                echo "error a3mi";
                            }

                            ?>
                        </p>
                    </div>
                    <div class="status-item">
                        <h3>Occupied Rooms</h3>
                        <p>
                            <?php
                            if ($type_room === 'single') {
                                $occupied_rooms = 12 - $result_available_rooms->num_rows;
                                echo $occupied_rooms;
                            } else {
                                $occupied_rooms = 18 - $result_available_rooms->num_rows;
                                echo $occupied_rooms;
                            }

                            ?>
                        </p>
                    </div>
                </div>
            </section>
            <section class="booking-status">
                <h2>Booking Status</h2>
                <div class="status-box">
                    <div class="status-item">
                        <h3>Total Bookings</h3>
                        <p>
                            <?php

                            $sql_total_bookings = "SELECT id_room FROM reserved_rooms WHERE '$in_date' <= room_reserved_date_in and '$out_date' >= room_reserved_date_in";
                            $result_total = $conn->query($sql_total_bookings);

                            if ($result_total) {
                                echo $result_total->num_rows;
                            } else {
                                echo "siiir";
                            }
                            ?>
                        </p>
                    </div>
                    <div class="status-item">
                        <h3>Upcoming Bookings</h3>
                        <p>20</p>
                    </div>
                    <div class="status-item">
                        <h3>Cancelled Bookings</h3>
                        <p>
                            <?php
                            $sql_cancelled = "SELECT * FROM cancelled_reservations where 
                                                (check_in>='$in_date' AND check_in <= '$out_date')
                                                AND (check_out>='$in_date' AND check_out <= '$out_date')";
                            $result_cancelled = $conn->query($sql_cancelled);
                            if ($result_cancelled) {
                                echo $result_cancelled->num_rows;
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </section>
            <section class="customer-list">
                <h2>Customer List</h2>
                <table>
                    <thead>
                        <tr>
                            <th style="background-color: #fff;">Customer ID</th>
                            <th style="background-color: #fff;">Name</th>
                            <th style="background-color: #fff;">Email</th>
                            <th style="background-color: #fff;">Phone</th>
                            <th style="background-color: #fff;">CIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_list = "SELECT * FROM reservation WHERE 
                                            (check_in >= '$in_date' AND check_in<= '$out_date' )
                                            AND (check_out >= '$in_date' AND check_out<= '$out_date' )";
                        $result_list = $conn->query($sql_list);
                        while ($row = $result_list->fetch_assoc()) {
                            $id_list = $row['id'];
                            $name_list = $row['client_name'];
                            $email_list = $row['client_email'];
                            $phone_list = $row['phone_number'];
                            $cin = $row['cin'];

                            echo "
                                    <tr>
                                        <td>$id_list</td>
                                        <td>$name_list</td>
                                        <td>$email_list</td>
                                        <td>$phone_list</td>
                                        <td>$cin</td>
                                    </tr>
                                ";
                        }

                        ?>
                    </tbody>
                </table>
            </section>
        </form>
        <footer>
        </footer>
    </div>
    </div>
    <script>
        let navMenu = document.getElementById('menu-icon');
        let sidebar = document.getElementById('sidebar');
        let sidebar_icon = document.getElementById('sidebar-icon');
        navMenu.addEventListener('click', () => {
            if (sidebar.style.display = 'none') {

                sidebar.style.display = 'block';
            }
        });
        sidebar_icon.addEventListener('click', () => {
            if (sidebar.style.display = 'block') {
                sidebar.style.display = 'none';
            }
        })
        //     const searchForm = document.querySelector('.search-form');
        //     searchForm.addEventListener('submit', () => {
        //         event.preventDefault();
        //         const searchTerm = searchForm.querySelector('input[name="search"]').value;
        //         const currentUrl = window.location.href;
        //         const newUrl = currentUrl + '?search=' + searchTerm;
        //         window.location.href = newUrl;
        // });
    </script>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>

<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/YARAY_HOTEL/images/YARAY2-removebg-preview.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;0,900;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            overflow: hidden;
        }
        ::-webkit-scrollbar{
            width: 2px;
        }
        /* Center the login form on the page */
        .admins_login {
            background-image: url(/YARAY_HOTEL/images/admins_pics/retrosupply-jLwVAUtLOAQ-unsplash.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            
        }

        /* Style the form */
        form {
          display: flex;
          flex-direction: column; 
          width: 80%;
          max-width: 400px;
          padding: 20px;
          margin: 10px;
          background-color: rgba(236, 236, 236, 0.4);
          backdrop-filter: blur(8px);
          border-radius: 10px;
          box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        }

        /* Style the form title */
        form h1 {
          font-size: 2rem;
          margin: 0 0 20px 0;
          text-align: center;
        }

        /* Style the form fields and labels */
        form label {
          
          font-size: 1.2rem;
          margin: 30px 0;
          
        }
        form input::placeholder{
            font-size: 15px;
        }
        form input[type="text"],
        form input[type="password"] {
            background-color: transparent;
            outline: none;
            width: 95%;
            padding: 10px;
            font-size: 1.1rem;
            border: black solid 1px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .button{
            display: flex;
            justify-content: center;
            margin: 20px 0px;
        }
        /* Style the submit button */
        form input[type="submit"] {
          width: 50%;
          margin-top: 20px;
          padding: 10px;
          font-size: 1.2rem;
          color: #fff;
          background-color: #0077cc;
          border: none;
          border-radius: 5px;
          box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
          cursor: pointer;
        }

        /* Style the error message */
        form .alert {

          
          font-size: 1.2rem;
          color: #fff;
          background-color: rgba(255, 0, 0, 0.6);
          border-radius: 5px;
          box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
          width: 100%;
          text-align: center;
        }


    </style>

  </head>
  
  <body>

    <div class="admins_login">
        <!-- <h1>Admins section</h1> -->
        <form action="authentication.php" method="post" id="form-admins">
          <h1>Login</h1>
          <div class="alert">
          <?php
        if (isset($_POST['login'])) {
            $servername = "localhost"; 
            $username = "root";
            $password = "";
            $dbname = "hotel";

            $message_error = '';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $admin_name = $_POST['admin_name'];
            $admin_password = $_POST['admin_password'];

            $sql = "SELECT * FROM admins WHERE admin_name = '$admin_name' AND admin_password = '$admin_password'";
            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    $result_row = $result->fetch_assoc();
                    $id = $result_row['id'];  
                    $encoded_id = base64_encode($id);
                    $encoded_encoded_id = base64_encode($encoded_id);
                    // redirect to admins.php with the encoded id as a parameter
                    echo "<script> window.open('admins.php?id=$encoded_encoded_id', '_blank'); </script>";           
                } else {
                    $message_error = "Invalid username or password.";
                    echo $message_error;
                }
            }
        }
        ?>
          </div>
          <label for="username">Username:</label>
          <input type="text" id="username" name="admin_name" placeholder="enter username" required>
          <label for="password">Password:</label>
          <input type="password" id="password" name="admin_password" placeholder="enter password" required>
        
          <div class="button">
            <input type="submit" name="login" value="Login">
          </div>
        </form>
    </div>
    
  </body>
</html>

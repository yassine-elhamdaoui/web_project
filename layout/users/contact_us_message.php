
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require_once '/xampp/htdocs/YARAY_HOTEL/PHPMailer/src/Exception.php';
    require_once '/xampp/htdocs/YARAY_HOTEL/PHPMailer/src/SMTP.php';
    require_once '/xampp/htdocs/YARAY_HOTEL/PHPMailer/src/PHPMailer.php';
    $name = $_POST['username'];
    $email = $_POST['email'];
    $number = $_POST['user_number'];
    $subject = $_POST['user_subject'];
    $message = $_POST['message'];
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
    $mail->setFrom($email);
    $mail->addAddress('YARAYHOTEL@gmail.com');
    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = 'client email : ' . $email .'<br>client name : ' . $name . ',<br><br>subject : '. $subject . '.<br><br>message:<br>'.$message.'<br>';
    
    // Send email
    if ($mail->send()) {
        echo 'message email sent';
        header('location:message_success.html?');
    } else {
        echo 'Error sending email';
    }
?>
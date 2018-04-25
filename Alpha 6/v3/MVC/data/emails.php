    <?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require (COMPOSER_ROOT.'/vendor/autoload.php');
class emails
{

    public static function sendEmail($name,$u,$e,$pass,$type){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mx1.hostinger.com;mx1.hostinger.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = data::$emailSettings['email'];      // SMTP username
            $mail->Password = data::$emailSettings['password'];   // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(data::$emailSettings['email'], 'Autoresponder');
            $mail->addAddress($e, $u);     // Add a recipient
            $mail->addReplyTo(data::$emailSettings['email'], 'Information');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            if ($type === "confirm") {
                $mail->Subject = 'Arctic-Lands Account Activation';
                $mail->Body = emails::confirmEmail($name,$u, $e, $pass);
                $mail->AltBody = "Hello " . $name . ",\r\n\r\n
                       Click the link below to activate your account when ready:\r\n\r\n
                       \r\n\r\n
                       ".data::$emailSettings['authenticatAddress']."u=" . $u . "&e=" . $e . "&p=" . $pass . "\r\n\r\n\r\n\r\n
                       Login after successful activation using your:
                       \r\n\r\n* Username: " . $name."
                       \r\n\r\n Maxmansung";
            } else if ($type === "recover"){
                $mail->Subject = 'Arctic-Lands Account Recovery';
                $mail->Body = emails::recoveryEmail($name,$u, $pass);
                $mail->AltBody = "Hello " . $name . ",\r\n\r\n
                       You have requested to recover your password, please use the following link to do this:\r\n\r\n
                       \r\n\r\n
                       ".data::$emailSettings['recoveryAddress']."u=" . $u . "&p=" . $pass . "\r\n\r\n\r\n\r\n
                       Thank you for helping out with the testing of this game
                       \r\n\r\n Maxmansung";

            } else {
                return "FAIL";
            }
            $mail->send();
            return "SUCCESS";
        } catch (Exception $e) {
            return "FAIL";
        }
    }

    static $recovery = "";

    public static function confirmEmail($name,$u,$e,$pass){
        $body = '<div style="padding:24px; font-size:12px;">
                       Hello '.$name.',<br />
                       <br />Click the link below to activate your account when ready:<br />
                       <br />
                       <a href="'.data::$emailSettings['authenticatAddress'].'u='.$u.'&e='.$e.'&p='.$pass.'">
                           Click here to activate your account now
                       </a>
                       <br />
                       <br />
                       Login after successful activation using your username: <b>'.$name.'</b>';
        return emails::$mailHeader.$body.emails::$mailFooter;
    }

    public static function recoveryEmail($name,$u,$pass){
        $body = '<div style="padding:24px; font-size:12px;">
                       Hello ' . $name . ',<br />
                       <br />You have requested to recover your password, please use the following link to do this:<br />
                       <br />
                       <div align="center"><a href="'.data::$emailSettings['recoveryAddress'].'u=' . $u . '&p=' . $pass . '">
                           Click here to be directed to a page to change your password
                       </a>
                       </div>
                       <br />
                       <br />
                       Thank you for helping out with the testing of this game
                       <br />
                       <br />
                       Sincerely
                       <br />
                       Maxmansung
                   </div>';
        return emails::$mailHeader.$body.emails::$mailFooter;
    }

    static $mailHeader = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Arctic Lands</title></head>
                   <body style="margin:0; font-family:Times New Roman, sans-serif; font-size:12px background:rgb(0,150,200)">
                   <img src="http://www.arctic-lands.com/images/banner5.png">';

    static $mailFooter = '</body></html>';

}
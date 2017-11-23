<?php
class emails
{

    static $recovery = "";

    public static function confirmEmail($u,$e,$pass){
        $body = '<div style="padding:24px; font-size:12px;">
                       Hello '.$u.',<br />
                       <br />Click the link below to activate your account when ready:<br />
                       <br />
                       <a href="https://www.arctic-lands.com/login/activation.php?&u='.$u.'&e='.$e.'&p='.$pass.'">
                           Click here to activate your account now
                       </a>
                       <br />
                       <br />
                       Login after successful activation using your:
                       <br />* Username: <b>'.$u.'</b>';
        return emails::$mailHeader.$body.emails::$mailFooter;
    }

    public static function recoveryEmail($u,$pass){
        $body = '<div style="padding:24px; font-size:12px;">
                       Hello ' . $u . ',<br />
                       <br />You have requested to recover your password, please use the following link to do this:<br />
                       <br />
                       <div align="center"><a href="https://www.arctic-lands.com/login/recovery.php?&u=' . $u . '&p=' . $pass . '">
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
                   </div>
                   </body>
                   </html>';
        return emails::$mailHeader.$body.emails::$mailFooter;
    }

    static $mailHeader = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Arctic Lands</title></head>
                   <body style="margin:0; font-family:Times New Roman, sans-serif; font-size:12px background:rgb(0,150,200)">
                   <img src="https://www.arctic-lands.com/images/banner5.png">';

    static $mailFooter = '</body></html>';

}
<?php
/* Плагин Callback 2.0 by samdev */
/* Больше плагинов под Opencart 2 на http://greysoft.ru/tag/opencart-2-0 */


/* Здесь менять почту получателя */
$to = "mail@gmail.com";


/* Дальше ничего не меняем */
$subject = "Обратный звонок";
include "../../language/russian/common/callback.php";
$extra = array(
        "form_subject"      => true,
        "form_cc"           => true,
        "ip"                => false,
        "user_agent"        => false
);

$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
        $output = "<div style='display:none'>
        <div class='contact-top'></div>
        <div class='contact-content'>
                <h1 class='contact-title'>".$sendthis."</h1>
                <div class='contact-loading' style='display:none'></div>
                <div class='contact-message' style='display:none'></div>
                <form action='#' style='display:none'>
                  
                        <input type='text' id='contact-name' placeholder='Представьтесь' class='q2' name='name' tabindex='1001' required />
                       
                        <input type='text' id='contact-phone' placeholder='Ваш телефон' class='q2' name='phone' tabindex='1002' required />";
             
        $output .= "
                       <br/>
                        <input type='submit' class='contact-send buttonbl' style='
    font-size: smaller;
    padding: 4px 10px 4px 10px;
' value=".$sendw." tabindex='1006' />
                        <input type='hidden' name='token' value='" . smcf_token($to) . "'/>
                </form>
        </div>
</div>";

        echo $output;
}
else if ($action == "send") {
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
        $subject = isset($_POST["subject"]) ? $_POST["subject"] : $subject;
		$message = "";
        $cc = isset($_POST["cc"]) ? $_POST["cc"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";

        if ($token === smcf_token($to)) {
                smcf_send($name, $phone, $subject, $message,  $cc);
                echo $ok;
        }
        else {
                echo $erno;
        }
}

function smcf_token($s) {
        return md5("smcf-" . $s . date("WY"));
}

function smcf_filter($value) {
        $pattern = array("/\n/","/\r/","/content-type:/i","/to:/i", "/from:/i", "/cc:/i");
        $value = preg_replace($pattern, "", $value);
        return $value;
}

function smcf_send($name, $phone, $subject, $message, $cc) {
        global $to;
        $name = smcf_filter($name);
        $subject = smcf_filter($subject);
        $phone = smcf_filter($phone);
        $message = "\nНомер телефона: ".$phone;
        $cc = 0; 
        $body = "Имя: $name\n";
		$body .= "$message";
        $body = wordwrap($body, 70);

        $headers = "From: Перезвоните\n";
        if ($cc == 1) {
                $headers .= "Cc: $phone\n";
        }
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/plain; charset=utf-8\n";
        $headers .= "Content-Transfer-Encoding: quoted-printable\n";

        @mail($to, $subject, $body, $headers) or
                die('$die');
}
        return true;
exit;

?>
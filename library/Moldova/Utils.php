<?php
/**
 * Created by Cojocaru Vadim.
 * User: vadim
 * Email: cojocaru.vadim@gmail.com
 * Website: www.cojocaruvadim.com
 * Date: 3/15/11
 * Time: 10:17 PM
 */
 
class Moldova_Utils {

    public static $MAIL;

    public static $companies_status = array(
            array('status' => 0, 'name' => 'New'),
            array('status' => 1, 'name' => 'Published')
    );

    public static function customPrint($array){
        echo "/*";
        print_r($array);
        echo "*/";
    }


    public static function checkAdmin($url){
        $return = false;
        $session = new Zend_Session_Namespace('admins');
        $acl = new Moldova_Auth_Acl();
        if(!$acl->isAllowed($session->role, Moldova_Auth_Resources::ADMIN_AREA)){
            $session->requestURL = $url;
            $session->role = Moldova_Auth_Roles::GUEST;

        }else{
            $return = true;
        }
        return $return;
    }

    public static function checkAccount($url){
        $return = false;
        $session = new Zend_Session_Namespace('accounts');
        $acl = new Moldova_Auth_Acl();
        if(!$acl->isAllowed($session->role, Moldova_Auth_Resources::USER_AREA)){
            $session->requestURL = $url;
            $session->role = Moldova_Auth_Roles::GUEST;

        }else{
            $return = true;
        }
        return $return;
    }

    public static function cleanUrl($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, '', $str);
        }

        $str = self::Transliterate($str);

        //aăaâaîașaț     a\u0103a\u00e2a\u00eea\u015fa\u0163
        //$str = preg_replace(array("/ă/","/â/", "/î/", "/ș/", "/ț/", "/Ă/","/Â/", "/Î/", "/Ș/", "/Ț/"), array("a", "a", "i", "s", "t", "a", "a", "i", "s", "t"), $str);
        $clean = preg_replace(array("/\x{0103}/u", "/\x{00e2}/u", "/\x{00ee}/u", "/\x{0219}/u", "/\x{021b}/u", "/Ă/","/Â/", "/Î/", "/Ș/", "/Ț/", "/\x{015f}/u", "/\x{0163}/u"), array("a", "a", "i", "s", "t", "a", "a", "i", "s", "t", "s", "t"), $str);


        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public static function Transliterate($str, $encIn='utf-8', $encOut='utf-8'){

        $cyr=array(
            "Щ",  "Ш", "Ч", "Ц","Ю", "Я", "Ж", "А","Б","В","Г","Д","Е","Ё","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х", "Ь","Ы","Ъ","Э","Є","Ї",
            "щ",  "ш", "ч", "ц","ю", "я", "ж", "а","б","в","г","д","е","ё","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х", "ь","ы","ъ","э","є","ї");

        $lat=array(
            "Shh","Sh","Ch","C","Ju","Ja","Zh","A","B","V","G","D","Je","Jo","Z","I","J","K","L","M","N","O","P","R","S","T","U","F","Kh","I","Y","I","E","Je","Ji",
            "shh","sh","ch","c","ju","ja","zh","a","b","v","g","d","je","jo","z","i","j","k","l","m","n","o","p","r","s","t","u","f","kh","i","y","i","e","je","ji"
        );

        $str = iconv($encIn, "utf-8", $str);
        for($i=0; $i<count($cyr); $i++){
            $c_cyr = $cyr[$i];
            $c_lat = $lat[$i];
            $str = str_replace($c_cyr, $c_lat, $str);
        }
        $str = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]e/", "\${1}e", $str);
        $str = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]/", "\${1}'", $str);
        $str = preg_replace("/([eyuioaEYUIOA]+)[Kk]h/", "\${1}h", $str);
        $str = preg_replace("/^kh/", "h", $str);
        $str = preg_replace("/^Kh/", "H", $str);

        return iconv("utf-8", $encOut, $str);
    }

    public static function encryptpass($password) {
        if(!empty($password)) {
            $key = 	'oYenhuobE577FzAixKPe9qQkptHbFx'.
                    'uoC0PcdPfNuQGnELzvI3FGVWl27k3v'.
                    'mqoymbRV09QWwdmq6c7AWysFP43LtM'.
                    'x8MDriq73T2PVJBGiyxQUxe4viLiHQ'.
                    'In4buglQcq3024DCw9sVFO0mFVe6Jq'.
                    'cPUuCjzYWyfgaSe97H6DBLIvAY9qbN'.
                    'xozZtZ0Id9Coy7daJDfx4w8BsyfFNr';

            $hash1 = sha1(md5($key));
            $hash2 = sha1(md5($password));
            $password = md5(sha1($hash1 . $hash2));

            return $password;
        }
    }

    public static function initiateMail($mainEmailContent){

        date_default_timezone_set('Europe/Bucharest');
        $htmlEmailContent = self::htmlMail($mainEmailContent);

        if (!self::$MAIL) {

            Zend_Mail::setDefaultFrom('cojocaru.vadim@gmail.com', "Cojocaru Vadim");
            Zend_Mail::setDefaultReplyTo('cojocaru.vadim@gmail.com', "Cojocaru Vadim");
            self::$MAIL = new Zend_Mail('utf-8');
            self::$MAIL->setBodyHtml($htmlEmailContent);

            //Zend_Mail::clearDefaultFrom();
            //Zend_Mail::clearDefaultReplyTo();

        }else{
            self::$MAIL->setBodyHtml($htmlEmailContent);
        }
    }

    public static function getSMTP(){
        $config = array('auth' => 'login',
            'username' => 'admin@dorin.cojocaruvadim.com',
            'password' => 'WtPKl3INF6es');
        $transport = new Zend_Mail_Transport_Smtp('mail.cojocaruvadim.com', $config);

        return $transport;
    }
    private static function htmlMail($mainEmailContent){
        $result = <<<TEXT
<div>
{$mainEmailContent}
</div>
TEXT;
        return $result;
    }
}

<?php
    session_start();
?>
<form method="post" action="">
    <label for="assis_login">Assis login</label>
    <br/>
    <input type="text" name="assis_login" id="assis_login">
    <br/>
    <label for="assis_password">Assis password</label>
    <br/>
    <input type="password" name="assis_password" id="assis_password">
    <br/>
    <input type="submit" name="login" value="SignIn">
</form>
<?php
if ((!empty($_GET['ErrorMsg'])) && (isset($_GET['ErrorMsg']))) {
    echo $_GET['ErrorMsg'];
}
if ($_POST['login']) {
        $assisObj['method'] = 'GetInfo';
        $assisObj['login'] = $_POST['assis_login'];
        $assisObj['password'] = $_POST['assis_password'];
        
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($assisObj),
                'header'=>  "Content-Type: application/json\r\n" ."Accept: application/json\r\n")
        );
        $context     = stream_context_create($options);
        $result      = file_get_contents("https://assis.ru/ws/json", false, $context);   
        $response    = json_decode($result);

        if ($response->resultCode == "OK") {

            $_SESSION["assis_login"] = $assisObj['login'];
            $_SESSION["assis_password"] = $assisObj["password"];
            $_SESSION['assis_sign_in'] = 'OK';
            $redirect = '/index.php?module=Realty';

            header('Location: '.$redirect);
        } else {
            $ErrorMsg = 'Неправильный логин или пароль!';
            $redirect = '/index.php?module=Realty&action=LoginAssis&ErrorMsg='
                    .$ErrorMsg."{$response->resultCode}";
            header('Location: '.$redirect);
        }

}
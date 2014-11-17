
check_auth();

function check_auth()
{
    $.getJSON('index.php?entryPoint=check_auth');
    setTimeout(check_auth, 30000);
}

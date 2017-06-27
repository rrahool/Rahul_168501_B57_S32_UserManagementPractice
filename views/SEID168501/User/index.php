<?php
if(!isset($_SESSION) )session_start();
include_once('../../../vendor/autoload.php');
use App\User\User;
use App\User\Auth;
use App\Message\Message;
use App\Utility\Utility;

$obj= new User();
$obj->setData($_SESSION);
$singleUser = $obj->view();

$auth= new Auth();
$status = $auth->setData($_SESSION)->logged_in();

if(!$status) {
    Utility::redirect('Profile/signup.php');
    return;
}
?>


<!DOCTYPE html>
<html>
<head>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" href="../../../resources/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../resources/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../../resources/assets/css/form-elements.css">
    <link rel="stylesheet" href="../../../resources/assets/css/style.css">
</head>

<body>

<div class="container">

    <table align="center">
        <tr>
            <td height="100" >

                <div id="message" >

                    <?php if((array_key_exists('message',$_SESSION)&& (!empty($_SESSION['message'])))) {
                        echo "&nbsp;".Message::message();
                    }
                    Message::message(NULL);

                    ?>
                </div>

            </td>
        </tr>
    </table>


    <header class="tab-content" style="background-color: floralwhite">
        <h1>Hello <?php echo "$singleUser->first_name $singleUser->last_name"?>! </h1>
    </header>

    <nav>
        <ul>
            <li> <a href= "Authentication/logout.php" style="color: lemonchiffon"> LOGOUT </a></li>
        </ul>
    </nav>

    <article class="alert-danger">
        <h2>Welcome to the members area... Following content is an example</h2><br>
        <p>London is the capital city of England. It is the most populous city in the  United Kingdom, with a metropolitan
            area of over 13 million inhabitants.</p>
        <p>Standing on the River Thames, London has been a major settlement for two millennia, its history going back to its
            founding by the Romans, who named it Londinium.</p>
    </article>

    <footer class="alert-success">Copyright © test-example.com</footer>

</div>


<!-- Javascript -->
<script src="../../../resources/assets/js/jquery-1.11.1.min.js"></script>
<script src="../../../resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../../../resources/assets/js/jquery.backstretch.min.js"></script>
<script src="../../../resources/assets/js/scripts.js"></script>

<!--[if lt IE 10]>
<script src="../../../resources/assets/js/placeholder.js"></script>
<![endif]-->

</body>

<script>
    $('.alert').slideDown("slow").delay(2000).slideUp("slow");
</script>

</html>

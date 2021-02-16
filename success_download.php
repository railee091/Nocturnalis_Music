<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');

 if (isset($_SESSION['fileDownload'])) {
    $someVar = $_SESSION['fileDownload'];
    }else{
       header('location:http://www.nocturnalis.com/');
    }
?>
<head>
    <title>NocturNalis Music</title>
    <meta name="description" content="An electronic musical odyssey detailing the saga of Shadelsin Dakraedow.
    By Chris Kochesky and Zælous X. The progenitors of the Electro-Dungeon genre.">
    <meta name="author" content="NocturNalis Music">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="images/favicon-32x32.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/owl.carousel.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style2.css">

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,500,600' rel='stylesheet' type='text/css'>
</head>

<body>
    <!-- =========================
     NAVIGATION LINKS     
    ============================== -->
    <div class="navbar navbar-fixed-top custom-navbar" role="navigation">
        <div class="container">

            <!-- navbar header -->
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">NocturNalis Music</a>
            </div>

            <div class="collapse navbar-collapse">

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="http://www.nocturnalis.com/" class="smoothScroll">HOME</a>
                    </li>

                </ul>

            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <!-- =========================
                INTRO SECTION   
            ============================== -->
            <section id="intro" class="parallax-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 successDownload">
                            <h1 class="wow fadeInUp nocturnalis-intro hover" data-wow-delay="1.6s">Your download will start automatically</h1>
                            <h4 class="wow bounceIn hover" data-wow-delay="0.9s">
                                Album files will be compressed in <b>.rar</b> format, to download uncompressed files click
                                <a href="user_downloads">here</a>.<br/><br/>
                                If your download doesn't start automatically click
                                <a href="javascript:DownloadAndRedirect()">here</a>
                            </h4>
                            <!--<a href="#overview" class="btn btn-lg btn-default smoothScroll wow fadeInUp hidden-xs" data-wow-delay="2.3s">LEARN MORE</a>-->
                            <!--<a href="#contact" class="btn btn-lg btn-danger smoothScroll wow fadeInUp" data-wow-delay="2.3s">subscribe</a>-->
                        </div>


                    </div>
                </div>
            </section>
            <!-- =========================
                FOOTER SECTION   
            ============================== -->
            <footer>
                <div class="container">
                    <div class="row">

                        <div class="col-md-12 col-sm-12">
                            <p class="wow fadeInUp" data-wow-delay="0.6s">Copyright &copy; 2021 NocturNalis Music | nocturnalismusic@gmail.com</p>
                            <p class="wow fadeInUp mrobles" data-wow-delay="0.6s">
                                <a href="https://www.facebook.com/SketchandGraphics">Design by M.Robles</a> | <span class="mrobles">mrobles.2516@gmail.com</span>
                            </p>

                            <ul class="social-icon"><!--replace # within "" with url link-->
                                <li><a href="#" class="fa fa-facebook wow fadeInUp" data-wow-delay="1s"></a></li>
                                <li><a href="#" class="fa fa-twitter wow fadeInUp" data-wow-delay="1.3s"></a></li>
                                <li><a href="#" class="fa fa-soundcloud wow fadeInUp" data-wow-delay="1.9s"></a></li>
                                <li><a href="#" class="fa fa-amazon wow fadeInUp" data-wow-delay="1.9s"></a></li>
                            </ul>

                        </div>
                        
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
</body>
<?php
// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

$senderName = $_SESSION['customerName'];
$senderEmail = $_SESSION['customerEmail'];
$customerItemPrice = $_SESSION['customerItemPrice'];
$order_number = $_SESSION['order_number'];
$senderMessage = "a purchase has been made for:<br/><b>Album:</b>".$someVar."<br/><b>Name:</b>".$senderName."<br/>"."<b>Email:</b>".$senderEmail;
//this to send email to purchaser
try {
    // Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    //$mail->isSMTP();
    //$mail->Host = 'smtp.gmail.com';
    //$mail->SMTPAuth = true;
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //$mail->Port = 587;
    
        $mail->isSMTP();
        $mail->Host = 'mail.nocturnalis.com';
        $mail->SMTPAuth = false;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAutoTLS = false; 
        $mail->Port = 25; 

    include('emailkeys/emailpasswords.php');

    // Sender and recipient settings
    $mail->setFrom($websiteEmailAddress, 'Nocturnalis Music');
    $mail->addAddress($senderEmail, "purchase-".$senderName);
    $mail->addReplyTo($websiteEmailAddress, 'Nocturnalis Music'); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Nocturnalis: Thank you for making a purchase ".$senderName."!";
    $mail->Body = "<h2>Thank you for subscribing!</h2>"//'HTML message body. <b>Gmail</b> SMTP email body.';
                    .$senderName.
                    "your purchase details are as follow:  <br/><br/>
                    Item name:  ".$someVar.
                    "<br/>Item Price: ".$customerItemPrice.
                    "<br/>Email used: ".$senderEmail.
                    "<br/>Order No.: ".$order_number.
                    "<br/><i><u>*please save this information as you will need this when you want to re-download your album purchase</u></i><hr/>
                    you can visit <a href='http://www.nocturnalis.com/user_downloads'>here <a>to redownload your purchases
                    <br/>
                    <h3>NocturNalis </h3><br/>
                    <i><p>An auditory excursion into the shadow light</p></i><br/>
                    <p>Copyright © 2021 NocturNalis Music</p>
                    "

    ;
    $mail->AltBody = $senderMessage;//'Plain text message body for non-HTML email client. Gmail SMTP email body.';

    $mail->send();
    //echo "Email message sent.";
} catch (Exception $e) {
    //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}

?>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.parallax.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/wow.min.js"></script>

<script type="text/javascript">
    var javaScriptVar = "<?php echo $someVar; ?>";
    window.onload = function () {
            setTimeout(function () {
                DownloadFile(javaScriptVar+".rar");
            }, 10);
            return true;
        };
        function DownloadFile(fileName) {
            //Set the File URL.
            var url = "albums/" + fileName;

            //Create XMLHTTP Request.
            var req = new XMLHttpRequest();
            req.open("GET", url, true);
            req.responseType = "blob";
            req.onload = function () {
                //Convert the Byte Data to BLOB object.
                var blob = new Blob([req.response], { type: "application/octetstream" });

                //Check the Browser type and download the File.
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, fileName);
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.setAttribute("download", fileName);
                    a.setAttribute("href", link);
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                }
            };
            req.send();
            //redirectPage();//calls function to redirect page to index
        };
        function redirectPage() {
        setTimeout(function(){ 
          window.location.replace("http://www.nocturnalis.com/");
            }, 6000);
        }

function DownloadAndRedirect()
{
   var DownloadURL = "albums/"+javaScriptVar+".rar";
   var RedirectURL = "http://www.nocturnalis.com/";
   var RedirectPauseSeconds = 5;
   location.href = DownloadURL;
   setTimeout("DoTheRedirect('"+RedirectURL+"')",parseInt(RedirectPauseSeconds*1000));
}
function DoTheRedirect(url) { window.location=url; }


</script>
<?php
session_destroy ();
?>
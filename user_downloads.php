<?php

// php search data in mysql database using PDO
// set data in input text
include('database_connection.php');
$email_address = "";
$customer_name = "";
$customer_country = "";
$order_status = "";
$order_id = "";
$order_number = "";
?>

<!DOCTYPE html>

<html>
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
    </head>

    <body>
        <!-- =========================
             PRE LOADER       
        ============================== -->
        <div class="preloader">

            <div class="sk-rotating-plane"></div>

        </div>


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
                            <a href="index" class="smoothScroll">HOME</a>
                        </li>
                    </ul>

                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form action="user_downloads" method="post">
                        <div class="row">
                            <div class="col-sm-4">
                               <input class="form-control" type="text" id="email_address" name="email_address" placeholder="email you used for purchase eg. name@gmail.com">
                            </div>
                            <div class="col-sm-4">
                               <input class="form-control" type="text" id="order_number" name="order_number"  placeholder="order number sent to your email">
                            </div>
                            <div class="col-sm-4">
                                <input class="btn btn-submit"type="submit" name="Find" value="Find Data">
                                <?php
                                    if (isset($_POST['email_address']) && $_POST['email_address'] != '' && isset($_POST['order_number']) && $_POST['order_number'] !=''  ){
                                        echo "results for ",$_POST['email_address'];
                                    }
                                ?>
                            </div>
                        </div>
                    </form>
                        <?php
                        // id to search 910676
                        if (isset($_POST['email_address']) && $_POST['email_address'] != '' && isset($_POST['order_number']) && $_POST['order_number'] !=''  ){
                             $email_address = $_POST['email_address'];
                             $order_number = $_POST['order_number'];


                         // mysql search query
                        $pdoQuery = "SELECT * FROM order_table JOIN order_item ON order_table.order_id = order_item.order_id WHERE email_address = :email_address AND order_number = :order_number";
                        
                        $pdoResult = $connect->prepare($pdoQuery);
                        
                        //set your id to the query id
                        $pdoExec = $pdoResult->execute(array(":email_address"=>$email_address, ":order_number"=>$order_number));
                        
                        if($pdoExec)
                        {
                                // if id exist 
                                //SELECT * FROM `order_table` JOIN  `order_item` ON `order_table`.order_id = `order_item`.order_id WHERE email_address = 'x@hotmail.com'
                                // show data in inputs
                            if($pdoResult->rowCount()>0)
                            {
                                foreach($pdoResult as $row)
                                {
                                    $email_address = $row['email_address'];
                                    $customer_name = $row['customer_name'];
                                    $customer_country = $row['customer_country'];
                                    $order_status = $row['order_status'];
                                    $order_item_name = $row['order_item_name'];
                                    $order_number = $row['order_number'];


                                        if($order_status == 'succeeded' && $pdoResult->rowCount()!=0 && $email_address!=''){
                                            echo"
                                                <div style='color:black;' class='row'><br/>
                                                    <div  class='panel panel-default'>
                                                        <div  class='panel-heading'>
                                                        Order No: ".$order_number."
                                                        </div>
                                                        <div  class='panel-body'>
                                                            <div  class='col-sm-4'>
                                                                <b>Name : </b>".$customer_name."
                                                            </div>

                                                            <div class='col-sm-3'>
                                                                <b>Country : </b>".$customer_country."
                                                            </div>

                                                            <div class='col-sm-5'>
                                                                <b>Album : </b>".$order_item_name."
                                                            </div>
                                                         </div>
                                                     </div>
                                                </div>
                                                ";
                                            $fileNameDirectory = "albums/".$order_item_name."/*.wav";
                                            $fileList = glob($fileNameDirectory);/** reads the file contents in a folder **/
                                            $i =1;
                                            echo "<div class='row'>
                                                    <div  class='panel panel-default'>
                                                        <div  class='panel-heading'>
                                                            Download list
                                                        </div>
                                                        <div  class='panel-body'>
                                                    ";
                                            foreach($fileList as $audioMp3){
                                                if(is_file($audioMp3)){
                                                    $title = substr($audioMp3, 0, strrpos($audioMp3, "."));/** removes file extension **/
                                                    echo "
                                                    <div class='sound-dl col-sm-12' data-title='".basename($title)."' data-album='".$order_item_name."'>
                                                            <i class='fa fa-arrow-circle-down btn btn-warning' aria-hidden='true'></i>
                                                        ",basename($title),"
                                                    </div>
                                                    <br/>";
                                                    unset($_POST['value']);
                                                }   
                                            }
                                        }
                                        if ($email_address == ''){
                                            echo "<b><h4 style='color:white;'>Type in your email to check purchase</h4></b>";
                                        }
                                        if ($pdoResult->rowCount()==0 && $email_address != '') {
                                               echo "<b><h4 style='color:white;'>You have not yet purchased any of our albums</h4></b>";
                                        }
                                            echo "      <hr/>
                                                        <p>
                                                        <a class='btn btn-info fa fa-file-archive-o' id='btn-dl' name='btn-dl' data-album='".$order_item_name."' btn btn-danger my-cart-btn' >
                                                        </a><b>download entire album in rar format</b></p>
                                                    </div>
                                                    </div>
                                                </div>";


                                }
                            }
                            else{
                                $error_1 = '1';
                            }
                        }else{
                           $error_2 ='2';
                        }
                        }else{
                            $email_address = "";
                            $order_number = "";
                        }
                       
                        
                    ?>
                </div>
            </div>
        </div>
    </body>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.parallax.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript">
 $(document).on('click', '#btn-dl', function(){
    javaScriptVar=$(this).data('album');
    DownloadFile(javaScriptVar+".rar");
    
 });

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

</script>
<script type="text/javascript">
 $(document).on('click', '.sound-dl', function(){
    title=$(this).data('title');
    album=$(this).data('album');
    DownloadFile(title+".wav", album);
 });

function DownloadFile(fileName, fileName2) {
    //Set the File URL.
    var url = "albums/" + fileName2+"/"+fileName;

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
</script>
</html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style.css">
    <title></title>
  </head>
  <body>
    <?php
    $newStr="";
    $alphabet="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWAYZ";
//connection block
    $host="localhost";
    $username="";
    $password="";
    $database="test";
    $connect=mysqli_connect($host,$username,$password,$database);
    $selectcmd='select * from sites';
    $found=false;
    $result=mysqli_query($connect,$selectcmd);
    $rc = mysqli_num_rows($result);
    $a=0;
    if(isset($_POST["url"]))
      {
        $urlinput=$_POST["url"];

        //$lettercount=strlen($urlinput);    //variable for shorting url
        $count=10;      //constant for shorting url
        if(strlen($urlinput)>1){
        for($i=0;$i<$count;$i++)
        {
        $randomletter=$alphabet[rand(0,strlen($alphabet)-1)];
        $newStr.=$randomletter;
      }

      while ($a <= $rc) {
        // code...
      $row = mysqli_fetch_array($result,MYSQLI_NUM);
      if($row[2]=="$urlinput")
      {
        //echo "found";
        $newStr=$row[1];
        $found=true;
      }
      $a=$a+1;
      }
    }
    if($found==false)
    {
    $insertcmd="insert into sites (shortUrl,siteName) values('$newStr','$urlinput')";
    $insert=mysqli_query($connect,$insertcmd);
  }

}

    ?>
      <div class="header-div">
        <div class="left-div">
        <a href="index.html"><h1 class="page-title">Short it</h1></a>
        </div>
        <div class="search-div">
          <input type="text" class="searchbox" ><button type="button" class="searchbtn"> </button>
        </div>
      </div>
<div class="body-div">
<form class="inputForm" action="index.php" method="POST">
<table class="inputtable">
  <tr>
    <td class="ent-url">Enter url</td>
    <td><input type="text" class="url" name="url" value="<?php
if(isset($_POST['url']))
{
    echo "$urlinput";
  }
     ?>"></td>
  </tr>
  <tr>
    <td>Shorten urls</td>
    <td><input type="text" class="url" name="shorturl" value="<?php
if(isset($_POST['url']))
{
    echo "$newStr";
}
    ?>"  ></td>
  </tr>
    <tr><td>&nbsp</td>
    <td><button type="submit" name="button" class="shortbtn">Shorten URL</button></td>
  </tr>
</table>
</form>
</div>
<div class="result-div">
  <?php
if($newStr!="" and $newStr!="Please Enter url"){
    echo "Shorten Link is: <a href=$newStr> localhost/$newStr</a>";
  }
  else {
    echo "Shorten Link is: $newStr";
  }
?>
</div>
<div class="footer-div">
  <div class="footer-left">
    <h2>Contacts:</h2>
    <a href="https://www.instagram.com"><img src="images/logo/instalogo.png" class="logo"></a> <br>
    <a href="https://www.facebook.com"><img src="images/logo/fblogo.png" class="logo"></a><br>
    <a href="https://twitter.com"><img src="images/logo/twitlogo.png" class="logo"></a><br>
    Rehan Ansari <br>
  </div>
  <div class="footer-right">
    <h2>Feedback Form</h2>
    <form class="feedbackform" action="index.html" method="post">
      <table class="feedbackform">
        <tr>
          <td>your name:</td>
          <td><input type="text" class="name" value=""></td>
        </tr>
        <tr>
          <td>your email:</td>
          <td><input type="email" class="name" value=""></td>
        </tr>
        <tr>
          <td>feedback:</td>
          <td><textarea name="name" class="name" rows="8" cols="23"></textarea></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<div class="endofpage-div">
  Thats All folks!!!
</div>
<?php
//redirect block
//block to redirect pages
 $path="";
 $path=$_SERVER['REQUEST_URI'];
 $path=ltrim($path,'/');
 //$path="https://www.google.com";
 //echo "redirected from /$path";
 $result=mysqli_query($connect,$selectcmd);

 $rc = mysqli_num_rows($result);      //row counts
 //echo $row[2];
for($i=0;$i<$rc;$i++)
{
$row = mysqli_fetch_array($result,MYSQLI_NUM);
if($path==$row[1])
{
   echo "$row[2]";
   echo "found $row[1]";
   header("Location:$row[2]");
 }
}
mysqli_close($connect);
 //echo "connected";
 ?>
  </body>
</html>

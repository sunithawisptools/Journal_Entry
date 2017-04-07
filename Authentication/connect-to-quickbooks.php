<?php
  ob_start();
  require_once("./config.php");
  //require_once("./CSS Styles/StyleElements.php");
?>

<html>
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <title>My Connect Page</title>
  <script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
  <script>
    // Runnable uses dynamic URLs so we need to detect our current //
    // URL to set the grantUrl value   ########################### //
    /*######*/ var parser = document.createElement('a');/*#########*/
    /*######*/parser.href = document.url;/*########################*/
    // end runnable specific code snipit ##########################//
    intuit.ipp.anywhere.setup({
        menuProxy: '',
        grantUrl: '<?php echo BASE_URL; ?>/Authentication/oauth.php?start=t' 
        // outside runnable you can point directly to the oauth.php page
    });
  </script>
</head>

</head>
<body>

<?php
require_once('../v3-php-sdk-2.2.0-RC/config.php');  // Default V3 PHP SDK (v2.0.1) from IPP
require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
require_once(PATH_SDK_ROOT . 'DataService/DataService.php');
require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');
error_reporting(E_ERROR | E_PARSE);


$tk = $_SESSION['token'];
if(!isset($_SESSION['token'])){
  echo "<h3>You are not currently authenticated!</h3>";
  echo '<div> This sample uses the Pecl Oauth library for OAuth. </div> <br />
		<div> If not done already, please download the Oauth package from
		<a target="_blank" href="http://pecl.php.net/package/oauth"> http://pecl.php.net/package/oauth </a> and follow the instructions given 
		<a target="_blank" href="http://pecl.php.net/package/oauth"> here </a> for installing the Oauth module.
		</div><br />
		<div> Add the OAuth Consumer Key and OAuth Consumer Secret of your application to config.php file </div> </br>
		<div> Click on the button below to connect this app to QuickBooks
		</div>';
  // print connect to QuickBooks button to the page
  echo "<br /> <ipp:connectToIntuit></ipp:connectToIntuit><br />";
} else {
   echo "<h3>You are currently authenticated!</h3>";
   $token = unserialize($_SESSION['token']);
   echo "realm ID: ". $_SESSION['realmId'] . "<br />";
   echo "oauth token: ". $token['oauth_token'] . "<br />";
   echo "oauth secret: ". $token['oauth_token_secret'] . "<br />";
 
   $key_array=array('realmId'=>$_SESSION['realmId'],'oauth_token'=>$token['oauth_token'],'oauth_token_secret'=>$token['oauth_token_secret']);
  $myfile = fopen("oauth_data.json", "w") or die("Unable to open file!");
   fwrite($myfile, json_encode($key_array));
  
   fclose($myfile);
   echo "<br />";
   echo "If not already done, please make sure that you set the above variables in the app.config file, before proceeding further! <br />";
   echo "<br />";
   echo "<button class='myButton' title='Disconnect your app from QBO' onclick='Disconnect($value)'>Disconnect</button>";
   echo '&nbsp;&nbsp;&nbsp;';
   echo "- Invalidates the OAuth access token in the request, thereby disconnecting the user from QuickBooks for this app.";
   echo "<br />";
   echo "<br />";
   echo "<button class='myButton' title='Regenerate the tokens within 30 days prior to token expiration' onclick='Reconnect($value)'>Reconnect</button>";
   echo '&nbsp;&nbsp;&nbsp;';
   echo "- Invalidates the OAuth access token used in the request and generates a new one, thereby extending the life span by 180 days. You can regenerate the tokens within 30 days prior to expiration!";
   echo "<br />";
   echo "<br />";
   echo "<br />";
   echo '<div> <small> <u> Note:</u> Configuring the Oauth tokens manually in app.config file is only for demonstartion purpose in this sample app. In real time production app, save the oath_token, oath_token_secret, and realmId in a persistent storage, associating them with the user who is currently authorizing access. Your app needs these values for subsequent requests to Quickbooks Data Services. Be sure to encrypt the access token and access token secret before saving them in persistent storage.<br />
		 Please refer to this <a target="_blank" href="https://developer.intuit.com/docs/0050_quickbooks_api/0020_authentication_and_authorization/connect_from_within_your_app"> link </a>for implementing oauth in your app. </small></div> <br />'; 
  }
  ob_end_flush();
?>
<script>
function Disconnect(parameter){
window.location.href = "<?php echo BASE_URL; ?>/PHPOAuthSample/Disconnect.php";
}

function Reconnect(parameter){
window.location.href ="<?php echo BASE_URL; ?>/PHPOAuthSample/Reconnect.php";
}
</script>
</body>
</html>

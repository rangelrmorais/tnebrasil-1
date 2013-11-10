<?php
// biblioteca do facebook
require 'sdk/src/facebook.php';
 

// ATENCAO, configurar os parametros abaixo
$APP_ID = "1381300702090563"; // id da app
$SECRET = "97252400cdba1be461340c57d125ef25"; // secret da app
$FANPAGE_ID = "382222121882171"; // id da fanpage
$PERMS = "publish_stream, user_photos, friends_photos";

// objeto do facebook
$facebook = new Facebook(array(
  'appId'  => $APP_ID,
  'secret' => $SECRET,
));
 // permitir upload de fotos
$facebook->setFileUploadSupport(true);

// obtem usuario logado
$user = $facebook->getUser();
 
if ($user) {
        // usuario esta logado
 
        // verifica se o usuario permitiou o aplicativo publicar e marcar fotos em seu perfil
$permissions = $facebook->api("/me/permissions");
if(!array_key_exists('publish_stream', $permissions['data'][0])
   ||  !array_key_exists('user_photos', $permissions['data'][0])
   ||  !array_key_exists('friends_photos', $permissions['data'][0])) {
       header( "Location: " . $facebook->getLoginUrl(array("scope" => "publish_stream, user_photos, friends_photos")) );
       exit;
}
 
        
 
} else {
        // usuário não esta logado. Requisitar login do facebook.
        $loginUrl = $facebook->getLoginUrl();
        header("Location: $loginUrl");
        exit;
}


$facebook_user_id = $facebook->getUser();
if ($facebook_user_id) {
  try {
       
        // verifica se usuario curtiu a fanpage
        $fql = "SELECT uid FROM page_fan WHERE page_id = '$FANPAGE_ID' AND uid = '$facebook_user_id'";
        $isFan = $facebook->api(array(
                  "method" => "fql.query",
                  "query"  => $fql,
        ));
 
       
 
  } catch (FacebookApiException $e) {
        echo $e;
        $user = null;
  }
} else {
        // usuario nao logado, solicitar autenticacao
        $loginUrl = $facebook->getLoginUrl();
        header("Location: " . $loginUrl);
        exit;
}
 


$c1 = '1.jpg';
$c2 = '1.jpg';
$c3 = '1.jpg';
$c4 = '1.jpg';



// monta URL atual
$my_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
 
// obtem CODE da autenticacao OAUTH
$code = $_REQUEST['code'];
if(empty($code)) {
        $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
               . $APP_ID . "&redirect_uri=" . urlencode($my_url)
               . "&scope=$PERMS";
 
        header("Location: $dialog_url");
        exit;
}
 
// com o CODE vamos gerar a URL para obter o access token do usuario
$token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $APP_ID . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $SECRET . "&code=" . $code;
 
$response = file_get_contents($token_url);
$params = null;
parse_str($response, $params);




//GATE ABRE
 if($isFan) {
                //curtiu
				echo "
			
Usuario curtiu fanpage!				
			
				";
        } else {
				//não curtiu
                echo "Você é:";
				
				$array = array($c1, $c2, $c3,$c4);
				{
				$resultado = $array[rand(0, count($array) - 1)] . "\n";
				
				
				
//Create an album
$album_details = array(
        'message'=> 'Veja qual console combina mais com você!',
        'name'=> 'Qual console combina com você?'
);
$create_album = $facebook->api('/me/albums', 'post', $album_details);
  
//Get album ID of the album you've just created
$album_uid = $create_album['id'];
//Upload a photo to album of ID...
$photo_details = array(
    'message'=> 'Photo message'
);

 
  $args = array(
   'message' => 'Random message',
   'image' => '@' . realpath('/qualvideogamevocee/$resultado'),
   'aid' => $album_uid,
   'no_story' => 1,
   'access_token' => $token
  );

  $photo = $facebook->api($album_uid . '/photos', 'post', $args);

  
  
}

        }
		
//GATE FECHA



?>


<div style="width:500px; height:500px; margin:0 auto; top:15%; background:red;"> <?php echo $params['access_token']; ?></div>
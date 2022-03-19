<?php
date_default_timezone_set( 'Europe/Istanbul' );

if ( isset( $_COOKIE[ "city" ] ) ) {
  if ( isset( $_GET[ "city" ] ) ) {
    setcookie( "city", $_GET[ "city" ] );
    $city = $_GET[ "city" ];
  } else {
    $city = $_COOKIE[ "city" ];
  }
} else {
  if ( isset( $_GET[ "city" ] ) ) {
    setcookie( "city", $_GET[ "city" ] );
    $city = $_GET[ "city" ];
  } else {
    $city = "istanbul";
  }
}

$citys = array( "İstanbul", "Ankara", "İzmir", "Bursa", "Antalya", "Adana", "Konya", "Gaziantep", "Şanlıurfa", "Kocaeli", "Mersin", "Diyarbakır", "Hatay", "Manisa", "Kayseri", "Samsun", "Balıkesir", "Kahramanmaraş", "Van", "Aydın", "Denizli", "Sakarya", "Tekirdağ", "Muğla", "Eskişehir", "Mardin", "Malatya", "Trabzon", "Erzurum", "Ordu", "Afyonkarahisar", "Sivas", "Adıyaman", "Zonguldak", "Tokat", "Elazığ", "Kütahya", "Batman", "Ağrı", "Çorum", "Çanakkale", "Osmaniye", "Şırnak", "Giresun", "Isparta", "Yozgat", "Muş", "Edirne", "Aksaray", "Kastamonu", "Düzce", "Uşak", "Kırklareli", "Niğde", "Bitlis", "Rize", "Amasya", "Siirt", "Kars", "Bolu", "Nevşehir", "Hakkari", "Kırıkkale", "Bingöl", "Burdur", "Karaman", "Karabük", "Yalova", "Kırşehir", "Erzincan", "Bilecik", "Sinop", "Iğdır", "Bartın", "Çankırı", "Artvin", "Gümüşhane", "Kilis", "Ardahan", "Tunceli", "Bayburt" );
sort( $citys );

function replace_tr( $text ) {
  $text = trim( $text );
  $search = array( 'Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ' );
  $replace = array( 'c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '-' );
  $new_text = str_replace( $search, $replace, $text );
  return $new_text;
}

function replace_en( $text ) {
  $text = trim( $text );
  $search = array( "Istanbul", "Izmir", "Sanliurfa", "Diyarbakir", "Kahramanmaras", "Aydin", "Tekirdag", "Mugla", "Eskisehir", "Adiyaman", "Elazig", "Kutahya", "Agri", "Corum", "Canakkale", "Sirnak", "Mus", "Duzce", "Usak", "Kirklareli", "Nigde", "Nevsehir", "Kirikkale", "Bingol", "Karabuk", "Kırsehir", "Igdir", "Bartin", "Cankiri", "Gumushane" );
  $replace = array( "İstanbul", "İzmir", "Şanlıurfa", "Diyarbakır", "Kahramanmaraş", "Aydın", "Tekirdağ", "Muğla", "Eskişehir", "Adıyaman", "Elazığ", "Kütahya", "Ağrı", "Çorum", "Çanakkale", "Şırnak", "Muş", "Düzce", "Uçak", "Kırklareli", "Niğde", "Nevşehir", "Kırıkkale", "Bingöl", "Karabük", "Kırşehir", "Iğdır", "Bartın", "Çankırı", "Gümüşhane" );
  $new_text = str_replace( $search, $replace, $text );
  return $new_text;
}

function connect( $city ) {
  global $site;
  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_REFERER, 'https://www.google.com' );
  curl_setopt( $ch, CURLOPT_URL, "https://" . $city . ".diyanet.gov.tr/Sayfalar/home.aspx" );
  curl_setopt( $ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14" );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  $site = curl_exec( $ch );
  curl_close( $ch );
}

connect( $city );

$vid = explode( 'Akşam', $site );
$vid = explode( "{", $vid[ 1 ] );
$vid = explode( ':', $vid[ 0 ] );
$vid = explode( "000}", $vid[ 1 ] );
$vid = $vid[ 0 ];

$svid = explode( 'İmsak', $site );
$svid = explode( "{", $svid[ 1 ] );
$svid = explode( ':', $svid[ 0 ] );
$svid = explode( "000}", $svid[ 1 ] );
$svid = $svid[ 0 ];

$iftar = date( "H:i:s", $vid . "" );
$sahur = date( "H:i:s", $svid . "" );

?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title><?php echo replace_en(ucwords($city)); ?> için iftara kalan süre</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo replace_en(ucwords($city)); ?> için iftara kalan süre">
<meta name="robots" content="index, follow"/>
<link rel="stylesheet" href="assest/css/bootstrap.min.css">
<link rel="stylesheet" href="assest/css/style.css">
<link rel="shortcut icon" href="assest/img/mosque.png">
</head>
<body>
<div class="col-md-12 home text-center">
  <div id="clock"></div>
  <div class="form-group padding">
    <div class="col-md-4 col-md-offset-4">
      <select class="form-control city-select" onchange="location = this.value;" id="sel1">
        <?php
        if ( isset( $city ) ) {
          echo '<option value="' . replace_tr( $city ) . '">Şehir Seçimi: ' . replace_en( ucwords( $city ) ) . '</option>', PHP_EOL;
        } else {
          echo '<option>Şehir Seç</option>';
        }
        foreach ( $citys as $city_list ) {
          echo '<option value="' . replace_tr( $city_list ) . '">' . $city_list . '</option>', PHP_EOL;

        }

        ?>
      </select>
    </div>
  </div>
</div>
<script src="assest/js/jquery.min.js"></script>
<script type="text/javascript">
            var countDownDate = new Date("<?php echo date('Y/m/d').' '.$iftar; ?>").getTime();
            var scountDownDate = new Date("<?php echo date('Y/m/d').' '.$sahur; ?>").getTime();
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var sdistance =  now - scountDownDate;
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                var shours = Math.floor((sdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var sminutes = Math.floor((sdistance % (1000 * 60 * 60)) / (1000 * 60));
                var sseconds = Math.floor((sdistance % (1000 * 60)) / 1000);
                document.getElementById("clock").innerHTML = "<span id='tire'><?php echo replace_en(ucwords($city)); ?></span><br><br><span class='text-1'>İftara Kalan Süre:</span> <span class='remaining'>" + hours + " saat " + minutes + " dakika " + seconds + " saniye </span><br><span class='text-1'>Oruçlu Geçen Süre:</span> <span class='remaining'>" + shours + " saat " + sminutes + " dakika " + sseconds + " saniye </span>";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("clock").innerHTML = "<img src='assest/img/mosque.png'> <br/> İftar açılmıştır. Hayırlı iftarlar!";
                }
            }, 1000);
        </script>
</body>
</html>
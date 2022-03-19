<?php
	/*
		@Author => Batuhan Kerim Türk
		@Version => 1.0
		@WebSite => https://yazilimgelistirici.com
		@WebSite => https://batuhankerimturk.com.tr
		@LegalWarning => Script tamamen açık kaynak kodludur.Kaynak göstermek şartıyla istediğiniz yerde kullanma iznine sahipsiniz.Footerdaki linki kaldırmassanız bize destek olursunuz.Bu desteklerde yeni ve ücretsiz scriptlerin paylaşılmasında rol oynar.
	*/
	error_reporting(0);
	date_default_timezone_set('Europe/Istanbul');
	// Şehir Bilgisi ile ilgili veri saklama işlemleri
	
	if(isset($_COOKIE["city"]))
	{
		if(isset($_GET["city"]))
		{
			setcookie("city", $_GET["city"]);
			$city = $_GET["city"];
		}
		else{
			$city = $_COOKIE["city"];
		}
	}
	else{
		if(isset($_GET["city"]))
		{
			setcookie("city", $_GET["city"]);
			$city = $_GET["city"];
		}
		else{
			$city = "istanbul";
		}
	}
	
	$citys = array("İstanbul", "Ankara", "İzmir", "Bursa", "Antalya", "Adana", "Konya", "Gaziantep", "Şanlıurfa", "Kocaeli", "Mersin", "Diyarbakır", "Hatay", "Manisa", "Kayseri", "Samsun", "Balıkesir", "Kahramanmaraş", "Van", "Aydın", "Denizli", "Sakarya", "Tekirdağ", "Muğla", "Eskişehir", "Mardin", "Malatya", "Trabzon", "Erzurum", "Ordu", "Afyonkarahisar", "Sivas", "Adıyaman", "Zonguldak", "Tokat", "Elazığ", "Kütahya", "Batman", "Ağrı", "Çorum", "Çanakkale", "Osmaniye", "Şırnak", "Giresun", "Isparta", "Yozgat", "Muş", "Edirne", "Aksaray", "Kastamonu", "Düzce", "Uşak", "Kırklareli", "Niğde", "Bitlis", "Rize", "Amasya", "Siirt", "Kars", "Bolu", "Nevşehir", "Hakkari", "Kırıkkale", "Bingöl", "Burdur", "Karaman", "Karabük", "Yalova", "Kırşehir", "Erzincan", "Bilecik", "Sinop", "Iğdır", "Bartın", "Çankırı", "Artvin", "Gümüşhane", "Kilis", "Ardahan", "Tunceli", "Bayburt"); //Tüm şehirlerin nüfus yoğunluğuna göre sıralanmış dizisi

	function replace_tr($text) {
		//Diyanat üzerinden veri alınırken sorun yaşanmaması için türkçe karakterleri değiştirilme işlemi
		$text = trim($text);
		$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
		$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
		$new_text = str_replace($search,$replace,$text);
		return $new_text;
	}  

	function replace_en($text) {
		//geri çekip ekrana yazdırken bazı isimlerde çıkan büyük küçük sıkıntısı düzenlemesi
		$text = trim($text);
		$search = array("Istanbul","Izmir","Sanliurfa","Diyarbakir","Kahramanmaras","Aydin","Tekirdag","Mugla","Eskisehir","Adiyaman","Elazig","Kutahya","Agri","Corum","Canakkale","Sirnak","Mus","Duzce","Usak","Kirklareli","Nigde","Nevsehir","Kirikkale","Bingol","Karabuk","Kırsehir","Igdir","Bartin","Cankiri","Gumushane");
		$replace = array("İstanbul","İzmir","Şanlıurfa","Diyarbakır","Kahramanmaraş","Aydın","Tekirdağ","Muğla","Eskişehir","Adıyaman","Elazığ","Kütahya","Ağrı","Çorum","Çanakkale","Şırnak","Muş","Düzce","Uçak","Kırklareli","Niğde","Nevşehir","Kırıkkale","Bingöl","Karabük","Kırşehir","Iğdır","Bartın","Çankırı","Gümüşhane");
		$new_text = str_replace($search,$replace,$text);
		return $new_text;
	}  

	function connect($city)
	{
		//Diyanet sitesine google aracılığı ile bağlanma 
		global $site;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
		curl_setopt($ch, CURLOPT_URL, "http://".$city.".diyanet.gov.tr/Sayfalar/home.aspx");
		curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$site = curl_exec($ch);
		curl_close($ch);
	}
	
	connect($city); //Bağlanma fonksiyonunu başlatıyoruz

	$aksam = preg_match_all('@<span id="ctl00_ctl35_g_405e0bc6_68ea_4c0c_bf0a_abb68a51c904_ctl00_lbldMaghrib">(.*?)</span>@si',$site,$aksam_vakti); //Diyaneti parçalayarak bize lazım olan akşam ezan vakit değerini çekiyoruz

	$aksam_vakti = trim($aksam_vakti[1][0]); //İftar vaktini temizleyip değer atıyoruz
	
	$simdi = date('H:i:s'); // Şimdiki Saat
	
	$iftar = $aksam_vakti.":00"; // İftar Vakti
	
?>	
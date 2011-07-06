<?

class Foursquare {
	
	private $username;
	private $password;
	
	private $baseUrl = "http://api.foursquare.com/v1/";
	
	public function __construct($username, $password) {
		
		$this->username = $username;
		$this->password = $password;
		
	}
	
	public function nearbyVenueSearch($geolat, $geolong, $limit=10, $query=null) {
		$requestUrl = $this->baseUrl . 'venues.xml?geolat='.$geolat.'&geolong='.$geolong.'&limit='.$limit . (is_null($query) ? "" : "&q=".urlencode($query));
		
		$api = curl_init($requestUrl);
		
		$curl_options = array(
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_USERPWD => $this->username . ':' . $this->password,
			CURLOPT_RETURNTRANSFER => true
		);
		
		curl_setopt_array($api, $curl_options);
		
		$xml = curl_exec($api);
		
		$xml = simplexml_load_string($xml);
		
		return $xml;
		
	}
	
	public function checkIn($venue_id, $geolat, $geolong) {
		
		$requestUrl = $this->baseUrl . 'checkin.xml';
		
		$api = curl_init($requestUrl);
		
		$curl_options = array(
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_USERPWD => $this->username . ':' . $this->password,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array(
				"vid" => $venue_id,
				"geolong" => $geolong,
				"geolat" => $geolat,
				"private" => 0
			)
		);
		
		curl_setopt_array($api, $curl_options);
		
		$xml = curl_exec($api);
		
		$xml = simplexml_load_string($xml);
		
		return $xml;
		
	}
	
}
<?

header("Content-type: text/plain");

require_once 'includes/Foursquare.php';

$params = $_SERVER['argv'];

$args = array();

for($i=1; $i<count($params); $i+=2) {
	$args[str_replace('-', '', $params[$i])] = $params[$i+1];
}

if(!isset($args['username']) || !isset($args['password'])) {
	echo "Must specify a username and password" . "\n";
	exit();
}

$fs = new Foursquare($args['username'], $args['password']);

switch($args['action']) {
	
	case 'checkin': {
		if(!isset($args['vid']) || !isset($args['geolat']) || !isset($args['geolong'])) {
			echo "Must specify a vid, geolat, and geolong" . "\n";
		} else {
			$checkin = $fs->checkIn($args['vid'], $args['geolat'], $args['geolong']);
			print_r($checkin);
		}
	} break;
	
	case 'venuesearch': {
		if(!isset($args['geolat']) || !isset($args['geolong'])) {
			echo "Must specify a geolat and geolong" . "\n";
		} else {
			$venues = $fs->nearbyVenueSearch(
				$args['geolat'], 
				$args['geolong'], 
				(isset($args['limit']) ? $args['limit'] : 10), 
				(isset($args['query']) ? $args['query'] : null)
			);
			print_r($venues);
		}
	} break;
	
	case 'wingscheckin': {
		$venues = $fs->checkIn("1718149", 42.0798724, -86.4240529);
		print_r($venues);
	} break;
	
	case 'wpecheckin': {
		$venues = $fs->checkIn("7411704", 41.695732, -86.305743);
		print_r($venues);
	} break;
	
	case 'jimmyjohns': {
		$venues = $fs->checkIn("3025826", 42.087063, -86.433611);
		print_r($venues);
	} break;
	
	case 'celebrationcinema': {
		$venues = $fs->checkIn("1597055", 42.0798724, -86.4240529);
		print_r($venues);
	} break;
	
}

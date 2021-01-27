<?php
/**
 * _global/config.php
 *
 * Author: pixelcave
 *
 * Global configuration file
 *
 */

// Include required classes
require __DIR__.'../../_classes/Template.php';


define('DB_HOST', 'localhost');
define('DB_NAME', 'u345964el7_gen');
define('DB_USERNAME', 'u345964el7_gen');
define('DB_PASSWORD', 'Dimimitko123');
define('ERROR_MESSAGE', 'Erreur dans la base de donnée');	try {
	$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
} catch( PDOException $Exception ) {
	error_log('ERROR: '.$Exception->getMessage().' - '.$_SERVER['REQUEST_URI'].' at '.date('l jS \of F, Y, h:i:s A')."\n", 3, 'error.log');
	die(ERROR_MESSAGE);
}

function error($string){
	return '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Error:</strong> '.$string.'</div>';
}
function success($string) {
	return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Success:</strong> '.$string.'</div>';
}

if (($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    exit("NOT ALLOWED");
}
define('DIRECT', true);
require __DIR__.'../../_global/functions.php';

    $user = new user;
    $stats = new stats;
    $siteinfo = $odb -> query("SELECT * FROM `settings` LIMIT 1");
		while ($show = $siteinfo -> fetch(PDO::FETCH_ASSOC)) {
	    $sitename = $show['sitename'];
	    $description = $show['description'];
	    $maintaince = $show['maintaince'];
	    $paypal = $show['paypal'];
	    $bitcoin = $show['bitcoin'];
	    $siteurl = $show['url'];
	    $rotation = $show['rotation'];
	    $key = $show['key'];
	    $testboots = $show['testboots'];
	    $secretKey = $show['secretKey'];
	    $coinpayments = $show['coinpayments'];
	    $ipnSecret = $show['ipnSecret'];
	    $google_site = $show['google_site'];
	    $google_secret = $show['google_secret'];
	    $btc_address = $show['btc_address'];
	    $gen_free = $show['gen_free'];
	}

if (isset($_SESSION['username'])) {
	$tickets = $odb->query("SELECT COUNT(*) FROM `tickets` WHERE `username` = '{$_SESSION['username']}' AND `status` = 'Waiting for user response' ORDER BY `id` DESC")->fetchColumn(0);
}



// **************************************************************************************************
// TEMPLATE OBJECT
// **************************************************************************************************
$lien = dirname($_SERVER['SCRIPT_NAME']);
if ($lien == "/admin") {

	$dm                             = new Template('BlackGenerator - Admin', '3.0', '../assets');
}
else {

	$dm                             = new Template('BlackGenerator', '3.0', 'assets');
}
//                              : Name, version and assets folder's name


// **************************************************************************************************
// GLOBAL META & OPEN GRAPH DATA
// **************************************************************************************************

//                              : The data is added in the <head> section of the page
$dm->author                     = 'BlackGen';
$dm->robots                     = 'noindex, nofollow';
$dm->title                      = $sitename;
$dm->description                = $description;

//                              : The url of your site, used in Open Graph Meta Data (eg 'https://example.com')
$dm->og_url_site                = $siteurl;

//                              : The url of your image/logo, used in Open Graph Meta Data (eg 'https://example.com/assets/img/your_logo.png')
$dm->og_url_image               = 'https://black-gen.pw/v.3.1/assets/media/blackgen.png';


// **************************************************************************************************
// GLOBAL GENERIC
// **************************************************************************************************

// ''                           : default color theme
// 'xwork'                      : xWork color theme
// 'xmodern'                    : xModern color theme
// 'xeco'                       : xEco color theme
// 'xsmooth'                    : xSmooth color theme
// 'xinspire'                   : xInspire color theme
$dm->theme                      = '';

// true                         : Enables Page Loader screen
// false                        : Disables Page Loader screen
$dm->page_loader                = true;

// true                         : Remembers active color theme between pages
//                                (when set through color theme helper Template._uiHandleTheme())
// false                        : No cookies
$dm->cookies                    = true;

// You will have to obtain a Google Maps API key to use Google Maps, for more info please have a look at
// https://developers.google.com/maps/documentation/javascript/get-api-key#key
$dm->google_maps_api_key        = '';


// **************************************************************************************************
// GLOBAL INCLUDED VIEWS
// **************************************************************************************************

//                              : Useful for adding different sidebars/headers per page or per section
$dm->inc_side_overlay           = '';
$dm->inc_sidebar                = '';
$dm->inc_header                 = '';
$dm->inc_footer                 = '';


// **************************************************************************************************
// GLOBAL SIDEBAR & SIDE OVERLAY
// **************************************************************************************************

// true                         : Left Sidebar and right Side Overlay
// false                        : Right Sidebar and left Side Overlay
$dm->l_sidebar_left             = true;

// true                         : Mini hoverable Sidebar (screen width > 991px)
// false                        : Normal mode
$dm->l_sidebar_mini             = false;

// true                         : Visible Sidebar (screen width > 991px)
// false                        : Hidden Sidebar (screen width > 991px)
$dm->l_sidebar_visible_desktop  = true;

// true                         : Visible Sidebar (screen width < 992px)
// false                        : Hidden Sidebar (screen width < 992px)
$dm->l_sidebar_visible_mobile   = false;

// true                         : Dark themed Sidebar
// false                        : Light themed Sidebar
$dm->l_sidebar_dark             = false;

// true                         : Hoverable Side Overlay (screen width > 991px)
// false                        : Normal mode
$dm->l_side_overlay_hoverable   = false;

// true                         : Visible Side Overlay
// false                        : Hidden Side Overlay
$dm->l_side_overlay_visible     = false;

// true                         : Enables a visible clickable (closes Side Overlay) Page Overlay when Side Overlay opens
// false                        : Disables Page Overlay when Side Overlay opens
$dm->l_page_overlay             = true;

// true                         : Custom scrolling (screen width > 991px)
// false                        : Native scrolling
$dm->l_side_scroll              = true;


// **************************************************************************************************
// GLOBAL HEADER
// **************************************************************************************************

// true                         : Fixed Header
// false                        : Static Header
$dm->l_header_fixed             = true;

// 'light'                      : Light themed Header
// 'dark'                       : Dark themed Header
// 'light-glass'                : Light themed Header with transparency by default (absolute position,
//                                perfect for light images underneath - solid light background
//                                on scroll if the Header is also set as fixed)
// 'dark-glass'                 : Dark themed Header with transparency by default (absolute position,
//                                perfect for dark images underneath - solid dark background
//                                on scroll if the Header is also set as fixed)
$dm->l_header_style             = 'dark';


// **************************************************************************************************
// GLOBAL FOOTER
// **************************************************************************************************

// true                         : Fixed Footer
// false                        : Static Footer
$dm->l_footer_fixed             = false;


// **************************************************************************************************
// GLOBAL MAIN CONTENT
// **************************************************************************************************

// ''                           : Full width Main Content
// 'boxed'                      : Full width Main Content with a specific maximum width (screen width > 1200px)
// 'narrow'                     : Full width Main Content with a percentage width (screen width > 1200px)
$dm->l_m_content                = '';


// **************************************************************************************************
// GLOBAL MAIN MENU
// **************************************************************************************************

// It will get compared with the url of each menu link to make the link active and set up main menu accordingly
// If you are using query strings to load different pages, you can use the following value: basename($_SERVER['REQUEST_URI'])
$dm->main_nav_active            = basename($_SERVER['PHP_SELF']);

// You can use the following array to create your main menu
$dm->main_nav                   = array();

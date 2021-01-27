<?php
/**
 * backend/config.php
 *
 * Author: pixelcave
 *
 * Backend pages configuration file
 *
 */

// **************************************************************************************************
// INCLUDED VIEWS
// **************************************************************************************************

$dm->inc_side_overlay           = 'inc/backend/views/inc_side_overlay.php';
$dm->inc_sidebar                = 'inc/backend/views/inc_sidebar.php';
$dm->inc_header                 = 'inc/backend/views/inc_header.php';
$dm->inc_footer                 = 'inc/backend/views/inc_footer.php';


// **************************************************************************************************
// MAIN CONTENT
// **************************************************************************************************

$dm->l_m_content                = 'narrow';


// **************************************************************************************************
// MAIN MENU
// **************************************************************************************************
  $dm->main_nav                   = array(
      array(
          'name'  => 'Home',
          'icon'  => 'si si-cursor',
          'url'   => 'home.php'
      ),
      array(
          'name'  => 'News',
          'icon'  => 'far fa-newspaper',
          'url'   => 'news.php'
      ),
      array(
          'name'  => 'Partnership',
          'icon'  => 'far fa-handshake',
          'url'   => 'partner.php'
      ),
      array(
          'name'  => 'Generator',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'Generator',
          'icon'  => 'fa fa-laptop-code',
          'url'   => 'hub.php',
          'view'  => true,
      ),
      array(
          'name'  => 'Shop',
          'icon'  => 'fa fa-store',
          'url'   => 'shop.php'
      ),
      array(
          'name'  => 'Stock',
          'icon'  => 'fa fa-box',
          'url'   => 'stock.php'
      ),
      array(
          'name'  => 'History',
          'icon'  => 'far fa-clock',
          'url'   => 'generate.php'
      ),


      array(
          'name'  => 'Free Generator',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'Generator',
          'icon'  => 'fa fa-laptop-code',
          'url'   => 'hub_free.php',
      ),
      array(
          'name'  => 'Stock',
          'icon'  => 'fa fa-box',
          'url'   => 'stock_free.php',
      ),
      array(
          'name'  => 'History',
          'icon'  => 'far fa-clock',
          'url'   => 'generate_free.php',
      ),
      array(
          'name'  => 'Personal space',
          'type'  => 'heading'
      ),

      array(
          'name'  => 'Notifications',
          'icon'  => 'fa fa-bell',
          'url'   => 'notifications.php'
      ),
      array(
          'name'  => 'Lottery',
          'icon'  => 'fas fa-dice',
          'url'   => 'loterie.php'
      ),
      
      array(
          'name'  => 'Support',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'F.A.Q',
          'icon'  => 'fa fa-question-circle',
          'url'   => 'faq.php'
      ),
      array(
          'name'  => 'Tickets',
          'icon'  => 'fa fa-ticket-alt',
          'url'   => 'support.php'
      ),
      array(
          'name'  => 'Discord',
          'icon'  => 'fab fa-discord',
          'url'   => 'https://discord.gg/77zxCmK', // YOUR DISCORD LINK
          'target' => true,
      ),
      array(
          'name'  => 'Status',
          'icon'  => 'fa fa-server',
          'url'   => 'status.php'
      ),
      array(
          'name'  => 'Admin Panel',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'Panel',
          'icon'  => 'fa fa-server',
          'url'  => 'admin/'
      ),
  );


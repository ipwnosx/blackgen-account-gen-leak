<?php
/**
 * dashboards/modern/config.php
 *
 * Author: pixelcave
 *
 * Modern dashboard configuration file
 *
 */

// **************************************************************************************************
// INCLUDED VIEWS
// **************************************************************************************************

$dm->inc_side_overlay           = '../inc/dashboards/modern/views/inc_side_overlay.php';
$dm->inc_sidebar                = '../inc/dashboards/modern/views/inc_sidebar.php';
$dm->inc_header                 = '../inc/dashboards/modern/views/inc_header.php';
$dm->inc_footer                 = '../inc/dashboards/modern/views/inc_footer.php';


// **************************************************************************************************
// SIDEBAR & SIDE OVERLAY
// **************************************************************************************************


$dm->l_sidebar_dark             = true;


// **************************************************************************************************
// HEADER
// **************************************************************************************************

$dm->l_header_style             = 'light';


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
          'icon'  => 'si si-bar-chart',
          'url'   => 'index.php'
      ),
      array(
          'name'  => 'Settings',
          'icon'  => 'fa fa-cog',
          'url'   => 'settings.php'
      ),
      array(
          'name'  => 'Manage',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'Generator',
          'icon'  => 'far fa-plus-square',
          'sub'   => array(
              array(
                  'name'  => 'Generator settings',
                  'icon'  => 'si si-settings',
                  'url'   => 'hub.php'
              ),
              array(
                  'name'  => 'List of accounts',
                  'icon'  => 'fa fa-list-ul',
                  'url'   => 'list.php'
              ),
              array(
                  'name'  => 'Clear the generator (soon)',
                  'icon'  => 'far fa-trash-alt',
                  'url'   => 'clear.php'
              )
          )
      ),
      array(
          'name'  => 'Free generator',
          'icon'  => 'far fa-plus-square',
          'sub'   => array(
              array(
                  'name'  => 'Generator Settings',
                  'icon'  => 'si si-settings',
                  'url'   => 'hub_free.php'
              ),
              array(
                  'name'  => 'List of accounts',
                  'icon'  => 'fa fa-list-ul',
                  'url'   => 'list_free.php'
              ),
              array(
                  'name'  => 'Clear the generator (soon)',
                  'icon'  => 'far fa-trash-alt',
                  'url'   => 'clear_free.php'
              )
          )
      ),
      array(
          'name'  => 'Notifications',
          'icon'  => 'fa fa-bell',
          'sub'   => array(
              array(
                  'name'  => 'Add',
                  'icon'  => 'far fa-plus-square',
                  'url'   => 'new_notification.php'
              ),
              array(
                  'name'  => 'Notifications List',
                  'icon'  => 'fa fa-list-ul',
                  'url'   => 'notifications.php'
              )
          )
      ),
      array(
          'name'  => 'Codes (soon)',
          'icon'  => 'fas fa-terminal',
          'url'   => 'code.php'
      ),
      array(
          'name'  => 'Users',
          'icon'  => 'si si-user',
          'url'   => 'users.php'
      ),
      array(
          'name'  => 'Payments',
          'icon'  => 'si si-check',
          'url'   => 'payments.php'
      ),
      array(
          'name'  => 'Shop',
          'icon'  => 'fa fa-shopping-basket',
          'url'   => 'plans.php'
      ),
      array(
          'name'  => 'Tickets',
          'icon'  => 'fa fa-ticket-alt',
          'url'   => 'tickets.php'
      ),
      array(
          'name'  => 'Partnership',
          'icon'  => 'far fa-handshake',
          'url'   => 'partner.php'
      ),
      array(
          'name'  => 'Refund account',
          'icon'  => 'fas fa-retweet',
          'url'   => 'log_report.php'
      ),
      array(
          'name'  => 'F.A.Q',
          'icon'  => 'si si-question',
          'url'   => 'faq.php'
      ),
      array(
          'name'  => 'History',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'Actions',
          'icon'  => 'si si-action-undo',
          'url'   => 'userlogs.php'
      ),
      array(
          'name'  => 'generations',
          'icon'  => 'fa fa-history',
          'url'   => 'logs.php'
      ),
      array(
          'name'  => 'Login',
          'icon'  => 'si si-login',
          'url'   => 'logins.php'
      ),
      array(
          'name'  => 'Dashboard',
          'type'  => 'heading'
      ),
      array(
          'name'  => 'Return to the generator',
          'icon'  => 'si si-arrow-left',
          'url'   => '../'
      )
  );

<?php
/**
 * This file implements the login form
 *
 * This file is not meant to be called directly.
 *
 * @copyright (c)2003-2014 by Francois Planque - {@link http://fplanque.com/}.
 *
 * @package evocore
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author asimo: Evo Factory / Attila Simo
 *
 * @version $Id: _login.disp.php 8355 2015-02-27 10:18:59Z yura $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $blog, $action, $disp, $rsc_url, $Settings, $rsc_path, $transmit_hashed_password, $dummy_fields;

if( is_logged_in() )
{ // already logged in
	echo '<p>'.T_('You are already logged in').'</p>';
	return;
}

$login = utf8_strtolower( param( $dummy_fields[ 'login' ], 'string', '' ) );
$action = param( 'action', 'string', '' );
$redirect_to = param( 'redirect_to', 'url', '' );
$source = param( 'source', 'string', 'inskin login form' );
$login_required = ( $action == 'req_login' );

global $admin_url, $ReqHost, $secure_htsrv_url;

if( !isset( $redirect_to ) )
{
	$redirect_to = regenerate_url( 'disp' );
}

// Default params:
$params = array_merge( array(
		'skin_form_before'         => '',
		'skin_form_after'          => '',
		'form_title_login'         => '',
		'form_class_login'         => '',
		'login_page_before'        => '',
		'login_page_after'         => '',
		'login_form_action'        => $action,
		'login_form_name'          => 'login_form',
		'login_form_title'         => '',
		'login_form_layout'        => '',
		'login_form_class'         => 'bComment',
		'login_form_source'        => $source,
		'login_form_inskin'        => true,
		'login_form_inskin_urls'   => true,
		'login_form_required'      => $login_required,
		'login_validate_required'  => NULL,
		'login_form_redirect_to'   => $redirect_to,
		'login_form_login'         => $login,
		'login_action_value'       => '',
		'login_form_reqID'         => '',
		'login_form_sessID'        => '',
		'transmit_hashed_password' => $transmit_hashed_password,
		'display_abort_link'       => true,
		'display_form_messages'    => false,
		'login_form_footer'        => true,
	), $params );

$login_form_params = array(
	'form_before'              => str_replace( '$form_title$', $params['form_title_login'], $params['skin_form_before'] ),
	'form_after'               => $params['skin_form_after'],
	'form_action'              => $params['login_form_action'],
	'form_name'                => $params['login_form_name'],
	'form_title'               => $params['login_form_title'],
	'form_layout'              => $params['login_form_layout'],
	'form_class'               => $params['login_form_class'],
	'source'                   => $params['login_form_source'],
	'inskin'                   => $params['login_form_inskin'],
	'inskin_urls'              => $params['login_form_inskin_urls'],
	'login_required'           => $params['login_form_required'],
	'validate_required'        => $params['login_validate_required'],
	'redirect_to'              => $params['login_form_redirect_to'],
	'login'                    => $params['login_form_login'],
	'action'                   => $params['login_action_value'],
	'reqID'                    => $params['login_form_reqID'],
	'sessID'                   => $params['login_form_sessID'],
	'transmit_hashed_password' => $params['transmit_hashed_password'],
	'display_abort_link'       => $params['display_abort_link'],
);

echo str_replace( '$form_class$', $params['form_class_login'], $params['login_page_before'] );

if( $params['display_form_messages'] )
{ // Display the form messages before form inside wrapper
	messages( array(
			'block_start' => '<div class="action_messages">',
			'block_end'   => '</div>',
		) );
}

display_login_form( $login_form_params );

if( $params['login_form_footer'] )
{ // Display login form footer
	echo '<div class="notes standard_login_link"><a href="'.$secure_htsrv_url.'login.php?source='.rawurlencode( $source ).'&amp;redirect_to='.rawurlencode( $redirect_to ).'">'.T_( 'Use standard login form instead').' &raquo;</a></div>';

	echo '<div class="form_footer_notes">'.sprintf( T_('Your IP address: %s'), $Hit->IP ).'</div>';

	echo '<div class="clear"></div>';
}

echo $params['login_page_after'];
?>
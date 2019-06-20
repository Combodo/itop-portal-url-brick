<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2019 Combodo SARL
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'itop-portal-url-brick/1.0.5',
	array(
		// Identification
		//
		'label' => 'Embedded webpage in iTop portal',
		'category' => 'business',

		// Setup
		//
		'dependencies' => array(
            'itop-portal-base/1.0.0',
            'itop-portal/1.0.0',
		),
		'mandatory' => false,
		'visible' => true,

		// Components
		//
		'datamodel' => array(
			'urlbrick.class.inc.php',
			'urlbrickcontroller.class.inc.php',
			'urlbrickrouter.class.inc.php',
		),
		'webservice' => array(
			
		),
		'data.struct' => array(
			// add your 'structure' definition XML files here,
		),
		'data.sample' => array(
			// add your sample data XML files here,
		),
		
		// Documentation
		//
		'doc.manual_setup' => '', // hyperlink to manual setup documentation, if any
		'doc.more_information' => '', // hyperlink to more information, if any 

		// Default settings
		//
		'settings' => array(
			// Module specific settings go here, if any
		),
	)
);


?>

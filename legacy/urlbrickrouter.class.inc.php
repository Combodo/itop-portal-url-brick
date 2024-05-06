<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2024 Combodo SAS
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

namespace Combodo\iTop\Portal\Router;

/**
 * Class UrlBrickRouter
 *
 * @package Combodo\iTop\Portal\Router
 * @deprecated since 1.1.0, will be removed in next functional version (1.x.0)
 */
class UrlBrickRouter extends AbstractRouter
{
	static $aRoutes = array(
		array('pattern' => '/url/{sBrickId}',
			'callback' => 'Combodo\\iTop\\Portal\\Controller\\UrlBrickController::DisplayAction',
			'bind' => 'p_url_brick')
	);

}

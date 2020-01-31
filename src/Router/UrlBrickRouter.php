<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2020 Combodo SARL
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

namespace Combodo\iTop\Portal\Router;

use Combodo\iTop\Portal\Routing\ItopExtensionsExtraRoutes;

/** @noinspection PhpUnhandledExceptionInspection */
ItopExtensionsExtraRoutes::AddRoutes(array(
	array(
		'pattern' => '/url/{sBrickId}',
		'callback' => 'Combodo\\iTop\\Portal\\Controller\\UrlBrickController::DisplayAction',
		'bind' => 'p_url_brick'
	)
));

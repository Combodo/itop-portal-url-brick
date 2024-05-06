<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2024 Combodo SAS
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

namespace Combodo\iTop\Portal\Router;

use Combodo\iTop\Portal\Routing\ItopExtensionsExtraRoutes;

/** @noinspection PhpUnhandledExceptionInspection */
ItopExtensionsExtraRoutes::AddRoutes(array(
    array(
        'pattern' => '/url/{sBrickId}',
        'callback' => 'Combodo\\iTop\\Portal\\Controller\\UrlBrickController::Display',
        'bind' => 'p_url_brick'
    )
));

/**
 * @since 3.1.0
 */
//remove require itopdesignformat at the same time as version_compare(ITOP_DESIGN_LATEST_VERSION , '3.0') < 0
if (!defined("ITOP_DESIGN_LATEST_VERSION")) {
    require_once APPROOT . 'setup/itopdesignformat.class.inc.php';
}
if (version_compare(ITOP_DESIGN_LATEST_VERSION, 3.1, '>=')) {
    /** @noinspection PhpUnhandledExceptionInspection */
    ItopExtensionsExtraRoutes::AddControllersClasses(
        array(
            'Combodo\iTop\Portal\Controller\UrlBrickController'
        )
    );
}
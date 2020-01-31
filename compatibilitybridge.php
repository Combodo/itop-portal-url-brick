<?php

/**
 * Copyright (C) 2013-2020 Combodo SARL
 *
 * This file is part of iTop.
 *
 * iTop is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * iTop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 */

// IMPORTANT: This is a temporary compatibility bridge to enable a smooth migration from iTop 2.6- to iTop 2.7+.
// In the next version of the extension, this will be remove and the require_once from the 2.7 will be moved to the 'datamodel' section of the module.itop-portal-url-brick.php file.

// iTop 2.7 and newer
if(file_exists(APPROOT . 'env-' . utils::GetCurrentEnvironment() . '/itop-portal-base/portal/vendor/autoload.php'))
{
	// Portal framework autoloader is needed for the UrlBrickRouter
	require_once APPROOT . 'env-' . utils::GetCurrentEnvironment() . '/itop-portal-base/portal/vendor/autoload.php';
	// Must be explicitly loaded to register its routes
	require_once __DIR__ . '/src/Router/UrlBrickRouter.php';
	require_once __DIR__ . '/vendor/autoload.php';
}
// iTop 2.6 and older
else
{
	require_once __DIR__ . '/legacy/urlbrick.class.inc.php';
	require_once __DIR__ . '/legacy/urlbrickrouter.class.inc.php';
	require_once __DIR__ . '/legacy/urlbrickcontroller.class.inc.php';
}
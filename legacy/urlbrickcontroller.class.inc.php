<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2020 Combodo SARL
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

namespace Combodo\iTop\Portal\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use IssueLog;
use Combodo\iTop\Portal\Helper\ApplicationHelper;

/**
 * Class UrlBrickController
 *
 * @package Combodo\iTop\Portal\Controller
 * @deprecated since 1.1.0, will be removed in next functional version (1.x.0)
 */
class UrlBrickController extends BrickController
{
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $oRequest
	 * @param \Silex\Application                        $oApp
	 * @param string                                    $sBrickId
	 *
	 * @return mixed
	 */
	public function DisplayAction(Request $oRequest, Application $oApp, $sBrickId)
	{
		/** @var \Combodo\iTop\Portal\Brick\UrlBrick $oBrick */
		$oBrick = ApplicationHelper::GetLoadedBrickFromId($oApp, $sBrickId);
		$aData = array(
		    'oBrick' => $oBrick
        );

		// Manually applying url parameters callback if present.
		// Note: It could be done automatically when loading brick from XML, but it doesn't seem right as the brick is always loaded even when displaying another brick.
		$sUrlCallbackName = $oBrick->GetUrlParametersCallbackName();
		if(!empty($sUrlCallbackName))
		{
			// Checking that the callback is valid
			if (!is_callable($sUrlCallbackName))
			{
				IssueLog::Error(__METHOD__ . ' at line ' . __LINE__ . ' : Invalid url parameters callback "' . $sUrlCallbackName . '" used in brick "' . $oBrick->GetId() . '".');
				$oApp->abort(500, 'Invalid url parameters callback "' . $sUrlCallbackName . '" used in brick "' . $oBrick->GetId() . '".');
			}

			// Calling callback (We check if the method is a simple function or if it's part of a class in which case only static function are supported)
			if (!strpos($sUrlCallbackName, '::'))
			{
				$aUrlParameters = $sUrlCallbackName();
			}
			else
			{
				$aUrlCallbackNameParts = explode('::', $sUrlCallbackName);
				$sUrlCallbackClass = $aUrlCallbackNameParts[0];
				$sUrlCallbackName = $aUrlCallbackNameParts[1];
				$aUrlParameters = $sUrlCallbackClass::$sUrlCallbackName();
			}

			// Adding parameters to url
			if(!is_array($aUrlParameters))
			{
				IssueLog::Warning(__METHOD__ . ' at line ' . __LINE__ . ' : Url parameters callback (' . $oBrick->GetUrlParametersCallbackName() . ') for brick "' . $oBrick->GetId() . '" should have returned an array.');
			}
			else
			{
				$sUrl = $oBrick->GetUrl();
				$sUrlExtraParameters = '';
				$bHasExistingParameters = (!strpos($sUrl, '?')) ? false : true;

				foreach($aUrlParameters as $sParam => $sValue)
				{
					$sUrlExtraParameters .= ( ($sUrlExtraParameters === '') && !$bHasExistingParameters) ? '?' : '&';
					$sUrlExtraParameters .= $sParam . '=' . urlencode($sValue);
				}

				$oBrick->SetUrl($sUrl . $sUrlExtraParameters);
			}
		}

		if($oRequest->isXmlHttpRequest())
        {
            $oResponse = $oApp->json($aData);
        }
        else
        {
            $oResponse = $oApp['twig']->render($oBrick->GetPageTemplatePath(), $aData);
        }

        return $oResponse;
	}
}

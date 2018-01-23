<?php

// Copyright (C) 2010-2018 Combodo SARL
//
//   This file is part of iTop.
//
//   iTop is free software; you can redistribute it and/or modify	
//   it under the terms of the GNU Affero General Public License as published by
//   the Free Software Foundation, either version 3 of the License, or
//   (at your option) any later version.
//
//   iTop is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU Affero General Public License for more details.
//
//   You should have received a copy of the GNU Affero General Public License
//   along with iTop. If not, see <http://www.gnu.org/licenses/>

namespace Combodo\iTop\Portal\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use IssueLog;
use Combodo\iTop\Portal\Helper\ApplicationHelper;

class UrlBrickController extends BrickController
{

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


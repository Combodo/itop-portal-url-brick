<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2019 Combodo SARL
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

namespace Combodo\iTop\Portal\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use IssueLog;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UrlBrickController extends BrickController
{

	public function DisplayAction(Request $oRequest, $sBrickId)
	{
		/** @var \Combodo\iTop\Portal\Brick\BrickCollection $oBrickCollection */
		$oBrickCollection = $this->get('brick_collection');
		
		/** @var \Combodo\iTop\Portal\Brick\UrlBrick $oBrick */
		$oBrick = $oBrickCollection->GetBrickById($sBrickId);
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
				IssueLog::Error(__METHOD__ . ' at line ' . __LINE__ . ' : URL Brick : Invalid url parameters callback "' . $sUrlCallbackName . '" used in brick "' . $oBrick->GetId() . '".');
				throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR,
					'URL Brick : Invalid url parameters callback "' . $sUrlCallbackName . '" used in brick "' . $oBrick->GetId() . '".');			
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
				IssueLog::Warning(__METHOD__ . ' at line ' . __LINE__ . ' : URL Brick : Url parameters callback (' . $oBrick->GetUrlParametersCallbackName() . ') for brick "' . $oBrick->GetId() . '" should have returned an array.');
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
            $oResponse = new JsonResponse($aData);
        }
        else
        {
            $oResponse = $this->render($oBrick->GetPageTemplatePath(), $aData);
        }

        return $oResponse;
	}

}

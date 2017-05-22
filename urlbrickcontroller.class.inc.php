<?php

// Copyright (C) 2010-2015 Combodo SARL
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

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpKernel\HttpKernelInterface;
use \MetaModel;
use \Combodo\iTop\Portal\Helper\ApplicationHelper;
use \Combodo\iTop\Portal\Helper\ContextManipulatorHelper;
use \Combodo\iTop\Portal\Helper\SecurityHelper;

class UrlBrickController extends BrickController
{

	public function DisplayAction(Request $oRequest, Application $oApp, $sBrickId)
	{
		$oBrick = ApplicationHelper::GetLoadedBrickFromId($oApp, $sBrickId);
		$aData = array(
		    'oBrick' => $oBrick
        );

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


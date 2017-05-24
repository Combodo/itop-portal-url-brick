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

namespace Combodo\iTop\Portal\Brick;

use \MetaModel;
use \DOMFormatException;
use \Combodo\iTop\DesignElement;
use \Combodo\iTop\Portal\Brick\PortalBrick;

/**
 * Description of UrlBrick
 *
 * @author Guillaume Lajarige
 */
class UrlBrick extends PortalBrick
{
    const DEFAULT_PAGE_TEMPLATE_PATH = 'itop-portal-url-brick/layout.html.twig';

    const DEFAULT_FULLSCREEN = false;
    const DEFAULT_URL = null;
    const DEFAULT_SUBTITLE = null;

	static $sRouteName = 'p_url_brick';
	protected $sUrl;
	protected $bFullscreen;
	protected $sSubtitle;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->sUrl = static::DEFAULT_URL;
		$this->bFullscreen = static::DEFAULT_FULLSCREEN;
		$this->sSubtitle = static::DEFAULT_SUBTITLE;
	}

	/**
	 * Returns the brick url
	 *
	 * @return string
	 */
	public function GetUrl()
	{
		return $this->sUrl;
	}

	/**
	 * Sets the url of the brick
	 *
	 * @param string $sUrl
     * @return UrlBrick
	 */
	public function SetUrl($sUrl)
	{
		$this->sUrl = $sUrl;
		return $this;
	}

    /**
     * Returns the brick fullscreen
     *
     * @return boolean
     */
    public function GetFullscreen()
    {
        return $this->bFullscreen;
    }

    /**
     * Sets the fullscreen of the brick
     *
     * @param boolean $bFullscreen
     * @return UrlBrick
     */
    public function SetFullscreen($bFullscreen)
    {
        $this->bFullscreen = $bFullscreen;
        return $this;
    }

    /**
     * Returns the brick subtitle
     *
     * @return string
     */
    public function GetSubtitle()
    {
        return $this->sSubtitle;
    }

    /**
     * Sets the subtitle of the brick
     *
     * @param string $sSubtitle
     * @return UrlBrick
     */
    public function SetSubtitle($sSubtitle)
    {
        $this->sSubtitle = $sSubtitle;
        return $this;
    }

	/**
	 * Load the brick's data from the xml passed as a ModuleDesignElement.
	 * This is used to set all the brick attributes at once.
	 *
	 * @param \Combodo\iTop\DesignElement $oMDElement
	 * @return UrlBrick
	 */
	public function LoadFromXml(DesignElement $oMDElement)
	{
		parent::LoadFromXml($oMDElement);

		// Checking specific elements from XML
		foreach ($oMDElement->GetNodes('./*') as $oBrickSubNode)
		{
			switch ($oBrickSubNode->nodeName)
			{
				case 'url':
					$this->SetUrl($oBrickSubNode->GetText(self::DEFAULT_URL));
					break;

                case 'fullscreen':
                    $this->SetFullscreen( ($oBrickSubNode->GetText(self::DEFAULT_FULLSCREEN) === 'true') ? true : false );
                    break;

                case 'subtitle':
                    $this->SetSubtitle($oBrickSubNode->GetText(self::DEFAULT_SUBTITLE));
                    break;
			}
		}

		// Checking specific elements from iTop config
        // Note: We do not do this at the end of the constructor because it must override xml and therefore be called after xml parsing.
        $this->LoadFromConfig();

		// If url is empty, the brick disable itself
        if($this->GetUrl() === null || $this->GetUrl() === '')
        {
            $this->SetActive(false);
        }

		return $this;
	}

    /**
     * Load the brick's data from the iTop config.
     *
     * @return UrlBrick
     */
    public function LoadFromConfig()
    {
        // Checking brick parameters from config file
        $aBricksSettings = MetaModel::GetModuleSetting(PORTAL_MODULE_ID, 'bricks');
        if(is_array($aBricksSettings) && array_key_exists($this->GetId(), $aBricksSettings))
        {
            $aBrickSettings = $aBricksSettings[$this->GetId()];

            // Url
            if(array_key_exists('url', $aBrickSettings))
            {
                $this->SetUrl($aBrickSettings['url']);
            }
        }

        return $this;
    }

}

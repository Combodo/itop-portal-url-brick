<?php

/**
 * Module itop-portal-url-brick
 *
 * @author      Guillaume Lajarige <guillaume.lajarige@combodo.com>
 * @copyright   Copyright (C) 2012-2024 Combodo SAS
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 */

namespace Combodo\iTop\Portal\Brick;

use MetaModel;
use Combodo\iTop\DesignElement;

/**
 * Description of UrlBrick
 *
 * @author Guillaume Lajarige
 * @deprecated since 1.1.0, will be removed in next functional version (1.x.0)
 */
class UrlBrick extends PortalBrick
{
    const DEFAULT_PAGE_TEMPLATE_PATH = 'itop-portal-url-brick/legacy/layout.html.twig';

    const DEFAULT_FULLSCREEN = false;
    const DEFAULT_URL = null;
    const DEFAULT_URL_PARAMETERS_CALLBACK_NAME = null;
    const DEFAULT_SUBTITLE = null;

	static $sRouteName = 'p_url_brick';
	protected $sUrl;
	protected $sUrlParametersCallbackName;
	protected $bFullscreen;
	protected $sSubtitle;

	/**
	 * @inheritDoc
	 */
	public function __construct()
	{
		parent::__construct();

		$this->sUrl = static::DEFAULT_URL;
		$this->sUrlParametersCallbackName = static::DEFAULT_URL_PARAMETERS_CALLBACK_NAME;
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
	 * Returns the brick url parameters callback name (FQ)
	 *
	 * @return string
	 */
	public function GetUrlParametersCallbackName()
	{
		return $this->sUrlParametersCallbackName;
	}

	/**
	 * Sets the url parameters callback name of the brick. Must be FQ.
	 *
	 * @param string $sCallbackName
	 * @return UrlBrick
	 */
	public function SetUrlParametersCallbackName($sCallbackName)
	{
		$this->sUrlParametersCallbackName = $sCallbackName;
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
	 * @inheritDoc
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
					$this->SetUrl($oBrickSubNode->GetText(static::DEFAULT_URL));
					break;

				case 'url_parameters_callback':
					$this->SetUrlParametersCallbackName($oBrickSubNode->GetText(static::DEFAULT_URL_PARAMETERS_CALLBACK_NAME));
					break;

                case 'fullscreen':
                    $this->SetFullscreen( ($oBrickSubNode->GetText(static::DEFAULT_FULLSCREEN) === 'true') ? true : false );
                    break;

                case 'subtitle':
                    $this->SetSubtitle($oBrickSubNode->GetText(static::DEFAULT_SUBTITLE));
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

        // If url parameters callback name is empty, it should be reset to default value
		if($this->sUrlParametersCallbackName === '')
		{
			$this->SetUrlParametersCallbackName(static::DEFAULT_URL_PARAMETERS_CALLBACK_NAME);
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

<?php
/**
 * Component display list of available languages in application and allow to change it by the user.
 *
 * @package    sfDoctrineGuardCulturePlugin
 * @subpackage modules.sfGuardCulture.actions
 * @author     Daniel Ancuta <whisller@gmail.com>
 */
class DisplayLanguagesComponent extends sfComponent
{
    /**
     * @param  sfWebRequest $request
     * @author Daniel Ancuta <whisller@gmail.com>
     */
    public function execute($request)
    {
        $languages = sfDoctrineGuardCulture::getAvailableLanguages();

        if ($template = sfConfig::get('app_sfDoctrineGuardCulturePlugin_display_cultures_template', 'Flags')) {
            $this->getContext()->getConfiguration()->loadHelpers('Partial');

            $actualLanguage = isset($languages[$this->getUser()->getCulture()]) ? $languages[$this->getUser()->getCulture()] : null;

            return include_partial('sfGuardCulture/DisplayLanguages'.$template, array('languages'      => $languages,
                                                                                      'actualLanguage' => $actualLanguage));

            return sfView::NONE;
        }
    }
}
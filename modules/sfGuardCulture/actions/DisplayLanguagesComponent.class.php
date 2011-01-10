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
     * @param sfWebRequest $request
     */
    public function execute($request)
    {
        $languages = sfDoctrineGuardCulture::getAvailableLanguages();

        if ($template = sfConfig::get('app_sfDoctrineGuardCulturePlugin_display_cultures_template', 'Flags')) {
            $this->getContext()->getConfiguration()->loadHelpers('Partial');

            return include_partial('sfGuardCulture/DisplayLanguages'.$template, array('languages' => $languages));

            return sfView::NONE;
        }
    }
}
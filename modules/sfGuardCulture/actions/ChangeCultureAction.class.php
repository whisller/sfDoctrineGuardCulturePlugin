<?php
/**
 * Action allow user to change his language.
 *
 * @package    sfDoctrineGuardCulturePlugin
 * @subpackage modules.sfGuardCulture.actions
 * @author     Daniel Ancuta <whisller@gmail.com>
 */
class ChangeCultureAction extends sfAction
{
    /**
     * @param  sfWebRequest $request
     * @author Daniel Ancuta <whisller@gmail.com>
     */
    public function execute($request)
    {
        $culture = (string)$request->getParameter('culture');

        $this->forward404If(false === sfCultureInfo::validCulture($culture));

        $availableLanguages = sfDoctrineGuardCulture::getAvailableLanguages();

        $this->forward404If(false === in_array($culture, array_keys($availableLanguages)));

        $context          = $this->getContext();
        $controller       = $context->getController();
        $sfPatternRouting = $context->getRouting();
        $request          = $context->getRequest();
        $user             = $context->getUser();

        $user->setCulture($culture);

        if ($user->isAuthenticated() && sfConfig::get('app_sfDoctrineGuardCulturePlugin_change_culture_update_user', false)) {
            $sfGuardUser = $user->getGuardUser();

            if ($sfGuardUser instanceof sfGuardUser) {
                $sfGuardUser->setCulture($culture);
                $sfGuardUser->save();

                $this->dispatcher->notify(new sfEvent($this->getUser(), 'sf_doctrine_guard_culture_plugin.update_user_success', array('culture' => $culture)));
            }
         }

         $changeCultureUrl = $controller->genUrl(sfConfig::get('app_sfDoctrineGuardCulturePlugin_success_change_culture_url', $request->getReferer()), true);

         $availableCultures = sfDoctrineGuardCulture::getAvailableCultures();
         $regexCultures     = implode('|', $availableCultures);
         $host              = $request->getHost();

         if (preg_match('@^('.$regexCultures.')\.@i', $host)) {
             // there is culture in domain

             $this->redirect(preg_replace('@://('.$regexCultures.')\.@i', '://'.$culture.'.', $changeCultureUrl));
         } else {
             // there is no culture in domain, so we can suppose that it is in :sf_culture variable
             if ($route = $sfPatternRouting->findRoute(preg_replace('@'.preg_quote($request->getUriPrefix()).'@i', '', $changeCultureUrl))) {
                 if (isset($route['parameters']['sf_culture'])) {
                     $route['parameters']['sf_culture'] = $culture;
                 }

                 return $this->redirect($sfPatternRouting->generate($route['name'], $route['parameters']));
             }
         }

         return $this->redirect('@homepage');
    }
}
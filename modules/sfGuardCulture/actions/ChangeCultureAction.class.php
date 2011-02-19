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

        $user = $this->getUser();

        $user->setCulture($culture);

        if ($user->isAuthenticated() && sfConfig::get('app_sfDoctrineGuardCulturePlugin_change_culture_update_user', true)) {
            $sfGuardUser = $user->getGuardUser();

            if ($sfGuardUser instanceof sfGuardUser) {
                $sfGuardUser->setCulture($culture);
                $sfGuardUser->save();

                $this->dispatcher->notify(new sfEvent($this->getUser(), 'sf_doctrine_guard_culture_plugin.update_user_success', array('culture' => $culture)));
            }
         }

         $changeCultureUrl = sfConfig::get('app_sfDoctrineGuardCulturePlugin_success_change_culture_url', $request->getReferer());

         $sfPatternRouting = sfContext::getInstance()->getRouting();

         if ($route = $sfPatternRouting->findRoute(preg_replace('@'.preg_quote($request->getUriPrefix().$request->getPathInfoPrefix()).'@i', '', $changeCultureUrl))) {
             if (isset($route['parameters']['sf_culture'])) {
                 $route['parameters']['sf_culture'] = $culture;
             }

             return $this->redirect($sfPatternRouting->generate($route['name'], $route['parameters']));
         }

         return $this->redirect('' != $changeCultureUrl ? $changeCultureUrl : '@homepage');
    }
}
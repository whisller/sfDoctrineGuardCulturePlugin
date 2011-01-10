<?php
/**
 * Class is adding routing for plugin.
 *
 * @package    sfDoctrineGuardCulturePlugin
 * @subpackage lib.routing
 * @author     Daniel Ancuta <whisller@gmail.com>
 */
class sfGuardCultureRouting
{
    /**
     * Listens to the routing.load_configuration event.
     *
     * @param  sfEvent An sfEvent instance
     *
     * @author Daniel Ancuta <whisller@gmail.com>
     */
    static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
    {
        $r = $event->getSubject();

        // preprend our routes

        $r->prependRoute('sf_doctrine_guard_culture_plugin_change_culture', new sfRoute('/change-language/:culture', array('module' => 'sfGuardCulture',
                                                                                                                           'action' => 'ChangeCulture'),
                                                                                                                     array('sf_culture' => '(?:'.implode('|', sfDoctrineGuardCulture::getAvailableCultures()).')')));
    }
}
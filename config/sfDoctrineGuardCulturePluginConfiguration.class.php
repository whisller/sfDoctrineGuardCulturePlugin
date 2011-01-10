<?php
/**
 * sfDoctrineGuardCulturePlugin configuration.
 *
 * @package    sfDoctrineGuardCulturePlugin
 * @subpackage config
 * @author     Daniel Ancuta <whisller@gmail.com>
 */
class sfDoctrineGuardCulturePluginConfiguration extends sfPluginConfiguration
{
    /**
     * @see    sfPluginConfiguration
     *
     * @author Daniel Ancuta <whisller@gmail.com>
     */
    public function initialize()
    {
        if (sfConfig::get('app_sf_guard_culture_plugin_routes_register', true) && in_array('sfGuardCulture', sfConfig::get('sf_enabled_modules', array()))) {
            $this->dispatcher->connect('routing.load_configuration', array('sfGuardCultureRouting', 'listenToRoutingLoadConfigurationEvent'));

            $this->dispatcher->connect('sf_guard_user.post_insert', array('sfGuardCultureExtension', 'listenToUserCreated'));
        }
    }
}
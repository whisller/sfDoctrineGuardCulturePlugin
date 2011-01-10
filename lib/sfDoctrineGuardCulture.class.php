<?php
/**
 * Class with smal util methods for plugin.
 *
 * @package    sfDoctrineGuardCulturePlugin
 * @subpackage lib
 * @author     Daniel Ancuta <whisller@gmail.com>
 */
class sfDoctrineGuardCulture
{
    /**
     * Return array with all available languages.
     *
     * E.g.
     * array('pl' => 'Polski',
     *       'en' => 'English')
     *
     * @author Daniel Ancuta <whisller@gmail.com>
     * @return Array
     */
    public static function getAvailableLanguages()
    {
        $result = array();

        if ($callable = sfConfig::get('app_sfDoctrineGuardCulturePlugin_get_cultures_callable', false)) {
            $result = call_user_func_array($callable);
        } else {
            $result = sfConfig::get('app_sfDoctrineGuardCulturePlugin_available_cultures', array());
        }

        return $result;
    }

    /**
     * Return array with available cultures.
     *
     * E.g.
     * array(0 => 'pl',
     *       1 => 'en')
     *
     * @author Daniel Ancuta <whisller@gmail.com>
     * @return Array
     */
    public static function getAvailableCultures()
    {
        $result = array();

        $result = array_keys(sfDoctrineGuardCulture::getAvailableLanguages());

        return $result;
    }
}
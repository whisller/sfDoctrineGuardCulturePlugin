<?php
/**
 * Class with methods listeners for sfDoctrineGuardCulturePlugin.
 *
 * @package    sfDoctrineGuardCulturePlugin
 * @subpackage lib.event
 * @author     Daniel Ancuta <whisller@gmail.com>
 */
class sfGuardCultureExtension
{
    /**
     * Method is executed when user is created.
     *
     * @param  sfEvent $event
     * @author Daniel Ancuta <whisller@gmail.com>
     */
    public static function listenToUserCreated(sfEvent $event)
    {
        $sfGuardUser = $event->getSubject();
        if (sfContext::hasInstance()) {
            $user = sfContext::getInstance()->getUser();

            $sfGuardUser->setCulture($user->getCulture());
            $sfGuardUser->save();
        }
    }
}
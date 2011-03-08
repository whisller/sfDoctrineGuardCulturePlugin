<?php
/**
 * Filter allow you to change culture by domain.
 *
 * For work correctly with this filter you must have defined subdomains for your domain acording too cultures defined in configuration.
 *
 * @author Daniel Ancuta <whisller@gmail.com>
 */
class sfDoctrineGuardCultureDomainFilter extends sfFilter
{
    /**
     * @param  sfFilterChain $filterChain
     * @author Daniel Ancuta <whisller@gmail.com>
     */
    public function execute($filterChain)
    {
        $context           = $this->getContext();
        $user              = $context->getUser();
        $request           = $context->getRequest();
        $controller        = $context->getController();

        $availableCultures = sfDoctrineGuardCulture::getAvailableCultures();
        $regexCultures     = implode('|', $availableCultures);
        $host              = $request->getHost();

        if (preg_match('@^(www\.)?('.$regexCultures.')\.@i', $host, $matches)) {
            $culture = $matches[2];

            $user->setCulture($culture);
        } else {
            if ($user->isAuthenticated()) {
                // if user is authenticated we can redirect him to his default culture domain, or if he doesn't have it redirect to default app culture
                $culture = 0 < mb_strlen($user->getGuardUser()->getCulture(), 'UTF-8') ? $user->getGuardUser()->getCulture() : sfConfig::get('sf_default_culture');
            } else {
                // redirect user to default culture, it takse prefered culture for user
                $culture = $request->getPreferredCulture(sfDoctrineGuardCulture::getAvailableCultures());
            }

            $controller->redirect(preg_replace('@://(www\.)?@i', '://\\1'.$culture.'.', $request->getUri()));
        }

        $filterChain->execute();
    }
}
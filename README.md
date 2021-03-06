# sfDoctrineGuardCulture plugin (for symfony 1.4) #

The `sfDoctrineGuardCulturePlugin` is adding you ability to change language (culture) by your users.
Plugin also is adding ability to setup list of available languages and display it for frontend user - using simple component.

If you want to save user culture to its sfGuardUser account you must have plugin sfDoctrinePlugin and sfDoctrineGuardPlugin.

## Instalation ##

  * Instal the plugin (via Git)

        git checkout git://github.com/whisller/sfDoctrineGuardCulturePlugin.git

  * Activate the plugin in the `config/ProjectConfiguration.class.php`

        [php]
        class ProjectConfiguration extends sfProjectConfiguration
        {
            public function setup()
            {
                $this->enablePlugins(array('sfDoctrinePlugin',
                                           'sfDoctrineGuardPlugin',
                                           'sfDoctrineGuardCulture',
                                           '...'));
            }
        }

  * Rebuild your model

        symfony doctrine:build-model
        symfony doctrine:build-sql

  * Update you database tables by starting from scratch (it will delete all the existing tables, then re-create them):

        symfony doctrine:insert-sql

    or do everything with one command

        symfony doctrine:build --all --and-load

  * Publish assets

        symfony plugin:publish-assets

  * Enable module in your `settings.yml`
    * For your frontend application: sfGuardCulture

          [yml]
          all:
            settings:
              enabled_modules: [default, sfGuardCulture]

  * Setup sfGuardUser.culture after object is created. In sfGuardUser.class.php

        [php]
        public function postInsert($event)
        {
            $dispatcher = ProjectConfiguration::getActive()->getEventDispatcher();

            $dispatcher->notify(new sfEvent($event->getInvoker(), 'sf_guard_user.post_insert'));

            parent::preInsert($event);
        }

  * Clear you cache

        symfony cc

## Customization ##

  * app_sfDoctrineGuardCulturePlugin_change_culture_update_user (default true)

        If config is setup to true then after change culture by user its sfGuardUser.culture also will be update.

  * app_sfDoctrineGuardCulturePlugin_success_change_culture_url (default null)

        Route where user will be redirect after change the language (culture), if is not set then user will be redirect to referer page if is not set then will be redirect to @homepage

  * app_sfDoctrineGuardCulturePlugin_display_cultures_template (default 'Flags')

        Default view (partial name) for component DisplayLanguages

  * app_sfDoctrineGuardCulturePlugin_DisplayLanguagesFlagsPath (default 'sfDoctrineGuardCulturePlugin/images/flags')

        When you are using "Flags" view for component DisplayLanguages you can specify your own directory to images, remember that pictures must have ".png" extension

  * app_sfDoctrineGuardCulturePlugin_available_cultures (default array('pl' => 'Polski', 'en' => 'English'))

        List of available languages

## Extension points ##

  * sf_doctrine_guard_culture_plugin.update_user_success

        If app_sfDoctrineGuardCulturePlugin_update_user is setup as true, it will be execute after sfGuardUser update


In plugin are used icons from famfamfam package (http://www.famfamfam.com/lab/icons/flags/)
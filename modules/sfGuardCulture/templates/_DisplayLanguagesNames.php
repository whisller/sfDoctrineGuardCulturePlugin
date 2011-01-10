<ul class="sfDoctrineGuardCulturePlugin">
<?php foreach ($languages as $culture => $language): ?>
  <li <?php echo $culture==$sf_user->getCulture()? 'class="sfDoctrineGuardCulturePluginActive"':''; ?>><?php echo link_to($language, '@sf_doctrine_guard_culture_plugin_change_culture?culture='.$culture, array('title' => $language)); ?></li>
<?php endforeach; ?>
</ul>
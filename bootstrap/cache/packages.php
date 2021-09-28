<?php return array (
  'barryvdh/laravel-dompdf' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
    ),
  ),
  'facade/ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'itsgoingd/clockwork' => 
  array (
    'providers' => 
    array (
      0 => 'Clockwork\\Support\\Laravel\\ClockworkServiceProvider',
    ),
    'aliases' => 
    array (
      'Clockwork' => 'Clockwork\\Support\\Laravel\\Facade',
    ),
  ),
  'jenssegers/date' => 
  array (
    'providers' => 
    array (
      0 => 'Jenssegers\\Date\\DateServiceProvider',
    ),
    'aliases' => 
    array (
      'Date' => 'Jenssegers\\Date\\Date',
    ),
  ),
  'laravel-notification-channels/telegram' => 
  array (
    'providers' => 
    array (
      0 => 'NotificationChannels\\Telegram\\TelegramServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'maatwebsite/excel' => 
  array (
    'providers' => 
    array (
      0 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' => 
    array (
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'styde/html' => 
  array (
    'providers' => 
    array (
      0 => 'Styde\\Html\\HtmlServiceProvider',
    ),
    'aliases' => 
    array (
      'Field' => 'Styde\\Html\\Facades\\Field',
      'Alert' => 'Styde\\Html\\Facades\\Alert',
      'Menu' => 'Styde\\Html\\Facades\\Menu',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
    ),
    'dont-discover' => 
    array (
      0 => 'laravelcollective/html',
    ),
  ),
  'uxweb/sweet-alert' => 
  array (
    'providers' => 
    array (
      0 => 'UxWeb\\SweetAlert\\SweetAlertServiceProvider',
    ),
    'aliases' => 
    array (
      'Alert' => 'UxWeb\\SweetAlert\\SweetAlert',
    ),
  ),
);
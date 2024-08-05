<?php
include sprintf('%s/%s/vendor/autoload.php', DIR_APPLICATION, DIRNAME_CLASSES);

$config = $this->app->make('config');

if (strtolower($config->get('app.sentry.environment')) !== 'development') {
    \Sentry\init([
        'dsn' => 'https://2345b508ec2e45e26e156f97908e2207@o4507111295025152.ingest.de.sentry.io/4507532159352912',
        'traces_sample_rate' => 1.0,
        'profiles_sample_rate' => 1.0,
    ]);
}
Core::bind('manager/view/pagination', function($app) {
    return new \Application\Search\Pagination\View\Manager($app);
});

(new \Application\Container\EventRegistration())->registerEvents($this->app);
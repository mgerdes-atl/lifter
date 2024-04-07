<?php

use a9f\Lifter\Configuration\ConfigResolver;
use a9f\Lifter\DependencyInjection\ContainerBuilder;
use a9f\Lifter\LifterApplication;
use Symfony\Component\Console\Input\ArgvInput;

$autoloadFile = (static function (): ?string {
    $candidates = [
        getcwd() . '/vendor/autoload.php',
        __DIR__ . '/../../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
    ];
    foreach ($candidates as $candidate) {
        if (file_exists($candidate)) {
            return $candidate;
        }
    }
    return null;
})();
if ($autoloadFile === null) {
    echo "Could not find autoload.php file";
    exit(1);
}
include $autoloadFile;

$configFile = ConfigResolver::resolveConfigsFromInput(new ArgvInput());

$container = (new ContainerBuilder())->build();

/** @var LifterApplication $application */
$application = $container->get(LifterApplication::class);
$application->run();

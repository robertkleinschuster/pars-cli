<?php


namespace Pars\Cli;


use Laminas\DevelopmentMode\AutoComposer;
use Laminas\DevelopmentMode\Disable;
use Laminas\DevelopmentMode\Enable;
use Laminas\DevelopmentMode\Help;
use Laminas\DevelopmentMode\Status;

class DevCommand
{
    /**
     * Handle the CLI arguments.
     *
     * @param array $arguments
     * @param string $projectDir
     * @param false|resource $errorStream
     * @return int
     */
    public function __invoke(array $arguments, string $projectDir = '', $errorStream = STDERR)
    {
        $help = new Help();

        // Called without arguments
        if (count($arguments) < 1) {
            fwrite(STDERR, 'No arguments provided.' . PHP_EOL . PHP_EOL);
            $help(STDERR);
            return 1;
        }

        $argument = array_shift($arguments);

        switch ($argument) {
            case '-h':
            case '--help':
                $help();
                return 0;
            case 'disable':
                $disable = new Disable($projectDir, $errorStream);
                /*$composer = json_decode(file_get_contents($projectDir . '/composer.json'), true);
                $composerDev = json_decode(file_get_contents($projectDir . '/composer-dev.json'), true);
                $composerNew = array_diff_key($composer, $composerDev);
                file_put_contents($projectDir . '/composer.json', json_encode($composerNew, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                */return $disable();
            case 'enable':
                $enable = new Enable($projectDir, $errorStream);
                /*$composer = json_decode(file_get_contents($projectDir . '/composer.json'), true);
                $composerDev = json_decode(file_get_contents($projectDir . '/composer-dev.json'), true);
                $composerNew = array_replace_recursive($composer, $composerDev);
                file_put_contents($projectDir . '/composer.json', json_encode($composerNew, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                */return $enable();
            case 'status':
                $status = new Status($projectDir);
                return $status();
            case 'auto-composer':
                $auto = new AutoComposer($projectDir, $errorStream);
                return $auto();
            default:
                fwrite($errorStream, 'Unrecognized argument.' . PHP_EOL . PHP_EOL);
                $help($errorStream);
                return 1;
        }
    }
}

<?php

namespace Modla\KeysmithVue\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'keysmith:install')]
class InstallCommand extends Command
{
    use InstallPageView, InstallSettingsView;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keysmith:install {view : The view that should be installed (page, settings)}
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Keysmith Vue package';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        if ($this->argument('view') === 'page') {
            return $this->installPageView();
        } elseif ($this->argument('view') === 'settings') {
            return $this->installSettingsView();
        }

        $this->components->error('Invalid view. Supported views are [page], [settings].');
        
        return 1;
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  bool  $asDev
     * @return bool
     */
    protected function requireComposerPackages(array $packages, $asDev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }
}

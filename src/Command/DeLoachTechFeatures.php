<?php
/**
 * This file is part of the deloachtech/zepher-symfony package.
 *
 * (c) DeLoach Tech, LLC
 * https://deloachtech.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DeLoachTech\ZepherBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class DeLoachTechFeatures extends Command
{
    protected static $defaultName = 'deloachtech:features';

    private $containerBag;

    public function __construct(
        ContainerBagInterface $containerBag
    )
    {
        parent::__construct(self::$defaultName);
        $this->containerBag = $containerBag;
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $project_dir = $this->containerBag->get('kernel.project_dir');
        $files = glob("{$project_dir}/vendor/deloachtech/*/{src,templates}/*/*.{php,twig}", GLOB_BRACE);

        $output->writeln(<<<'EOT'

<comment>DeLoach Tech Features</comment>
The following codebase lines were found in the <info>vendor/deloachtech</info> directory.

EOT
        );

        foreach ($files as $file) {

            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $result = preg_grep('/FEATURE_/', $lines);

            if($result) {
                $_file = str_replace("{$project_dir}/","",$file);
                $output->write("<info>File: {$_file}</info>", true);

                foreach ($result as $line) {
                    $output->write(trim($line), true);
                }
                //$output->write(" ", true);
            }
        }
        $output->write("<info>Finished</info>", true);
        return Command::SUCCESS;

    }

}
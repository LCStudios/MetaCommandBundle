<?php
/**
 * @author Robin Gloster <robin@loc-com.de>
 */

namespace LCStudios\MetaCommandBundle\Console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class MetaCommand extends Command
{

    final protected function execute(InputInterface $input, OutputInterface $output)
    {
        $returnCode = 0;

        foreach ($this->getCommandArray($input) as $commandConfig) {
            $command = $this->getApplication()->find($commandConfig['command']);

            $arguments = $commandConfig;

            $childInput = new ArrayInput($arguments);
            $childInput->setInteractive($input->isInteractive());

            $commandReturnCode = $command->run($childInput, $output);

            if ($commandReturnCode > 0) {
                $returnCode = 1;
            }
        }

        return $returnCode;
    }

    abstract public function getCommandArray(InputInterface $input);
}

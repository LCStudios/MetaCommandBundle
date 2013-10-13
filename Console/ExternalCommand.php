<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 06.10.13
 * Time: 12:19
 */

namespace LCStudios\MetaCommandBundle\Console;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ExternalCommand extends ContainerAwareCommand
{

    final protected function execute(InputInterface $input, OutputInterface $output)
    {
        $capturedOutput = array();
        $returnCode = 0;

        $command = $this->getCommand($input);

        exec($command, $capturedOutput, $returnCode);

        if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
            $output->writeln($command);
        }
        if (OutputInterface::VERBOSITY_QUIET <= $output->getVerbosity()) {
            $output->writeln(implode(PHP_EOL, $capturedOutput));
        }

        return $returnCode;
    }

    abstract protected function getCommand(InputInterface $input);
}

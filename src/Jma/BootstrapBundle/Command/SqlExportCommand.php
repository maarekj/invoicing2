<?php

namespace Jma\BootstrapBundle\Command;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Process\Process;

/**
 * User: maarek
 * Date: 18/05/2014
 * Time: 11:26
 */
class SqlExportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName("sql:export")
            ->addOption('out', 'o', InputOption::VALUE_OPTIONAL, 'Le fichier de sauvegarde', 'export.sql')
            ->addOption('bin', 'b', InputOption::VALUE_OPTIONAL, 'Le chemin du binaire mysqldump', 'mysqldump')
            ->setDescription('Exporte la base de donnée dans un fichier sql');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException Quand le driver n'est pas pdo_mysql
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getContainer()->get('doctrine')->getConnection();
        /** @var $connection Connection */

        $driver = $connection->getDriver()->getName();
        $bin = $input->getOption('bin');
        $out = $input->getOption('out');
        $database = $connection->getDatabase();
        $host = $connection->getHost();
        $port = $connection->getPort();
        $pass = $connection->getPassword();
        $username = $connection->getUsername();

        if ($driver != "pdo_mysql") {
            throw new \InvalidArgumentException('Le driver doit être pdo_mysql.');
        }

        $command = sprintf("%s -h %s -P %s -u %s -p%s %s > $out", $bin, $host, $port, $username, $pass, $database, $out);
        $output->writeln($command);
        $process = new Process($command);
        $process->run(function ($type, $buffer) use ($output, $out) {
            if ('err' === $type) {
                $output->writeln(sprintf('<error>%s</error>', $buffer));
            } else {
                $output->writeln(sprintf('<info>%s</info>', $buffer));
            }
        });

        if ($process->isSuccessful() && $output->getVerbosity() >= 2) {
            $output->writeln("<info>" . file_get_contents($out) . "</info>");
        }
    }
} 
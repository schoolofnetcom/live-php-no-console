<?php

namespace SON\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ClassGenerator extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:class')
            ->setDescription('Cria uma classe com base no template')
            ->setHelp('Altere o template para refletir a alteração')
            ->addArgument('vendor', InputArgument::REQUIRED, 'O vendor name da classe')
            ->addArgument('dir', InputArgument::REQUIRED, 'O diretório do vendor name da classe')
            ->addArgument('namespace', InputArgument::REQUIRED, 'O namespace da classe');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folders = str_replace($input->getArgument('vendor'), $input->getArgument('dir'), $input->getArgument('namespace'));
        $folders = explode('\\', $folders);
        $file = array_pop($folders);

        $directory = ROOT . '/';

        foreach ($folders as $folder) {
            $directory .= $folder . '/';
            if (!is_dir($directory)) {
                mkdir($directory);
            }
        }

        $namespace = explode('\\', $input->getArgument('namespace'));
        $file = array_pop($namespace);
        $namespace = implode('\\', $namespace);

        $template = file_get_contents(ROOT . '/template');

        $template = str_replace('{{ namespace }}', $namespace, $template);
        $template = str_replace('{{ class }}', $file, $template);

        file_put_contents($directory . $file . '.php', $template);

        $output->write('Classe criada com sucesso');
    }
}

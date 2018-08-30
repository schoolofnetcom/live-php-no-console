<?php

namespace SON\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class Weather extends Command
{
    protected function configure()
    {
        $this
            ->setName('weather:city')
            ->setDescription('Weather of city.')
            ->setHelp('This command get weather fom a city in OpenWeatherMap...')
            ->addArgument('city', InputArgument::REQUIRED, 'The name of city.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $section = $output->section();
        $section->write('Connecting in OpenWeatherMap, wait');

        $city = $input->getArgument('city');
        $ch = curl_init("https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&APPID=49cf2bc3fa4696df3e25a0d78127b1ad");
        //$ch = curl_init("https://samples.openweathermap.org/data/2.5/weather?q=London,uk&appid=b6907d289e10d714a6e88b30761fae22");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        $section->overwrite('Temperature: ' . $result['main']['temp']);
    }
}

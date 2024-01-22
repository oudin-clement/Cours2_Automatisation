<?php

namespace App\Console;


use App\Models\Company;
use App\Models\Employee;
use App\Models\Office;
use Faker\Factory;
use Illuminate\Support\Facades\Schema;
use Slim\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
require __DIR__ . '/../../vendor/autoload.php';

class PopulateDatabaseCommand extends Command
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('db:populate');
        $this->setDescription('Populate database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();
        $output->writeln('Populate database...');

        /** @var \Illuminate\Database\Capsule\Manager $db */
        $db = $this->app->getContainer()->get('db');

        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=0");
        $db->getConnection()->statement("TRUNCATE `employees`");
        $db->getConnection()->statement("TRUNCATE `offices`");
        $db->getConnection()->statement("TRUNCATE `companies`");
        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=1");


        $db->getConnection()->statement("INSERT INTO `companies` VALUES
    (1,'$faker->company','$faker->e164PhoneNumber','$faker->companyEmail','https://stackexchange.com/','https://i.stack.imgur.com/UPdHB.jpg', now(), now(), null),
    (2,'$faker->company','$faker->e164PhoneNumber','$faker->companyEmail','https://www.google.com','https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Google_office_%284135991953%29.jpg/800px-Google_office_%284135991953%29.jpg?20190722090506',now(), now(), null)
        ");

        $db->getConnection()->statement("INSERT INTO `offices` VALUES
    (1,'$faker->company','$faker->address','$faker->city','$faker->postcode','$faker->country','$faker->email',NULL,1, now(), now()),
    (2,'$faker->company','$faker->address','$faker->city','$faker->postcode','$faker->country','$faker->email',NULL,1, now(), now()),
    (3,'$faker->company','$faker->address','$faker->city','$faker->postcode','$faker->country','$faker->email',NULL,2, now(), now()),
    (4,'$faker->company','$faker->address','$faker->city','$faker->postcode','$faker->country','$faker->email',NULL,2, now(), now())
        ");

        $db->getConnection()->statement("INSERT INTO `employees` VALUES
     (1,'$faker->firstname','$faker->lastname',1,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (2,'$faker->firstname','$faker->lastname',3,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (3,'$faker->firstname','$faker->lastname',2,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (4,'$faker->firstname','$faker->lastname',1,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (5,'$faker->firstname','$faker->lastname',4,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (6,'$faker->firstname','$faker->lastname',2,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (7,'$faker->firstname','$faker->lastname',3,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now()),
     (8,'$faker->firstname','$faker->lastname',1,'$faker->email',$faker->e164PhoneNumber,'$faker->jobTitle', now(), now())
        ");

        $db->getConnection()->statement("update companies set head_office_id = 1 where id = 1;");
        $db->getConnection()->statement("update companies set head_office_id = 3 where id = 2;");

        $output->writeln('Database created successfully!');
        return 0;
    }
}

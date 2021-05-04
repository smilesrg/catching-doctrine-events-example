<?php

namespace App\Command;

use App\Entity\Phonebook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InspectorCatchDoctrineEventsCommand extends Command
{
    protected static $defaultName = 'inspector:catch-doctrine-events';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $faker = \Faker\Factory::create();

        $phoneBook = new Phonebook();
        $phoneBookRepository = $this->entityManager->getRepository(Phonebook::class);

        $phoneBook->setFirstName($faker->firstName());
        $phoneBook->setLastName($faker->lastName());
        $phoneBook->setPhoneNumber($faker->phoneNumber());

        $this->entityManager->persist($phoneBook);
        $this->entityManager->flush();
        $phoneBookId = $phoneBook->getId();

        $this->entityManager->clear();
        $phoneBook = $phoneBookRepository->find($phoneBookId);

        $phoneBook->setPhoneNumber($faker->phoneNumber());
        $this->entityManager->flush();

        $this->entityManager->remove($phoneBook);
        $this->entityManager->flush();

        $io->success('Command finished successfully');
        return Command::SUCCESS;
    }
}

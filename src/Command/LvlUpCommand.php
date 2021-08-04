<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LvlUpCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserRepository
     */
    private $userRepo;

    protected static $defaultName = 'app:lvlUp';
    protected static $defaultDescription = 'up a role user/other to admin';

    /**
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepo
     */
    public function __construct(EntityManagerInterface $em, UserRepository $userRepo)
    {
        parent::__construct();
        $this->em = $em;
        $this->userRepo = $userRepo;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('up to admin')
            ->setHelp('This command up a user to admin')
            ->addArgument('userEmail', InputArgument::REQUIRED, 'user email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('userEmail');
        $user = null;
        $user = $this->userRepo->findOneBy(['email' => $email]);

        if ($user == null) {
            $output->writeln(' User not found ');
            return Command::FAILURE;
        }

        $user->setRoles(array('ROLE_ADMIN'));

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln(' User ' .$email . ' updated ! ');

        return Command::SUCCESS;
    }
}

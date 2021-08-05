<?php

namespace App\Command;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FindOldPostCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PostRepository
     */
    private $postRepo;


    protected static $defaultName = 'app:findOldPost';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @param EntityManagerInterface $em
     * @param PostRepository $postRepo
     */
    public function __construct(EntityManagerInterface $em, PostRepository $postRepo)
    {
        parent::__construct();
        $this->em = $em;
        $this->postRepo = $postRepo;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('find old post')
            ->setHelp('This command find all post before a date')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Find old post');
        $date = $io->ask('Enter a date, format Y/m/d');

        $post = $this->postRepo->createQueryBuilder('post')
            ->andWhere('post.createdAt <= :date')
            ->andWhere('post.status IN (:statusArray)')
            ->setParameter('date', $date)
            ->setParameter('statusArray', 1)
            ->getQuery()
            ->getResult();

        if (count($post) == 0) {
            $output->writeln(' no Post Found » ');
        } else {
            foreach ($post as $p) {
                $p->setStatus(0);
                $this->em->persist($p);
            }
        }

        $this->em->flush();

        $output->writeln(count($post).' Posts found and updated ! ');

        return Command::SUCCESS;
    }
}

<?php

namespace AppBundle\Command;

use AppBundle\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemoveBooksByTagCommand extends Command
{
    /** @var Registry */
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('library:remove:books:by-tag')
            ->setDescription('Remove books by tag')
            ->setHelp('This command delete all books that have the specified tag')
            ->addArgument('tagName', InputArgument::REQUIRED, 'Tag name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $tagName = $input->getArgument('tagName');
        $books = $this->doctrine->getRepository(Book::class)->findByTagNames([$tagName]);
        $booksCount = count($books);
        $io->title('Start book removing');
        $io->block('Found '.$booksCount.' book(s)');
        try {
            foreach ($books as $book) {
                $this->doctrine->getManager()->remove($book);
            }
            $this->doctrine->getManager()->flush();
            $io->success('Removed '.$booksCount.' book(s)');
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}
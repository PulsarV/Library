<?php

namespace AppBundle\Command;

use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemoveCategoryCommand extends Command
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
            ->setName('library:remove:category')
            ->setDescription('Remove category by name')
            ->setHelp('This command delete category that have the specified name')
            ->addArgument('categoryName', InputArgument::REQUIRED, 'Category name')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Forced removal of a category containing books (books also will be removed)')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $categoryName = $input->getArgument('categoryName');
        $isForceEnabled = $input->getOption('force');

        $io->title('Start category removing');

        /** @var Category $category */
        $category = $this->doctrine->getRepository(Category::class)->findOneByName($categoryName);

        try {
            if ($category) {
                $io->block('Category "'.$categoryName.'" found.');

                $booksCount = $category->getBooks()->count();
                $io->block('Found '.$booksCount.' book(s) inside.');
                if ($booksCount && !$isForceEnabled) {
                    throw new \Exception('Category "'.$categoryName.'" contains '.$booksCount.' book(s) inside and can\'t be removed. If you also want to delete these books, use --force key');
                }
                $this->doctrine->getManager()->remove($category);
                $this->doctrine->getManager()->flush();

                $io->success('Removed category "'.$categoryName.'" and '.$booksCount.' book(s) inside');
            } else {
                $io->error('Category "'.$categoryName.'" not found.');
            }
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}

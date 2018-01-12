<?php

namespace AppBundle\Command;

use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChangeCategoryCommand extends Command
{
    /** @var Registry */
    private $doctrine;

    /** @var Producer */
    private $producer;

    /**
     * ChangeCategoryCommand constructor.
     * @param Registry $doctrine
     * @param Producer $producer
     */
    public function __construct(Registry $doctrine, Producer $producer)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
        $this->producer = $producer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('library:change:category')
            ->setDescription('Move all books from one category to another')
            ->setHelp('This move all books from one category to another')
            ->addArgument('sourceCategoryName', InputArgument::REQUIRED, 'Source category name')
            ->addArgument('destinationCategoryName', InputArgument::REQUIRED, 'Destination category name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $sourceCategoryName = $input->getArgument('sourceCategoryName');
        $destinationCategoryName = $input->getArgument('destinationCategoryName');

        try {
            /** @var Category $sourceCategory */
            $sourceCategory = $this->doctrine->getRepository(Category::class)->findOneByName($sourceCategoryName);
            if (!$sourceCategory) {
                throw new \Exception('Source category doesn\'t exists. Operation aborted.');
            }

            /** @var Category $destinationCategory */
            $destinationCategory = $this->doctrine->getRepository(Category::class)->findOneByName($destinationCategoryName);
            if (!$destinationCategory) {
                throw new \Exception('Destination category doesn\'t exists. Operation aborted.');
            }

            $booksCount = $sourceCategory->getBooks()->count();

            if ($booksCount) {
                $rawMessage = [
                    'source' => $sourceCategory->getId(),
                    'destination' => $destinationCategory->getId(),
                ];

                $this->producer->publish(json_encode($rawMessage));
                $io->success('The task for moving '.$booksCount.' book(s) has been moved to the queue. You can see the status of execution in the file "rabbit_%current_environment%.log"');
            } else {
                $io->warning('Source category doesn\'t contains books. Operation aborted.');
            }
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }
    }
}

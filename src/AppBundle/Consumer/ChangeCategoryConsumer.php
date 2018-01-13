<?php

namespace AppBundle\Consumer;

use AppBundle\Entity\Book;
use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class ChangeCategoryConsumer
 * @package AppBundle\Consumer
 */
class ChangeCategoryConsumer implements ConsumerInterface
{
    /** @var Registry $doctrine */
    private $doctrine;

    /** @var Logger $logger */
    private $logger;

    /**
     * ChangeCategoryConsumer constructor.
     * @param Registry $doctrine
     * @param Logger $logger
     */
    public function __construct(Registry $doctrine, Logger $logger)
    {
        $this->doctrine = $doctrine;
        $this->logger = $logger;
    }

    /**
     * @var AMQPMessage $msg
     * @return void
     */
    public function execute(AMQPMessage $msg)
    {
        $this->logger->addNotice('Start category changing.');

        try {
            $message = json_decode($msg->getBody(), true);

            $sourceId = $message['source'];
            $destinationId = $message['destination'];

            /** @var Category $sourceCategory */
            $sourceCategory = $this->doctrine->getRepository(Category::class)->findOneBy(['id' => $sourceId]);
            if (!$sourceCategory) {
                throw new \Exception('Source category doesn\'t exists. Operation aborted.');
            }
            /** @var Category $destinationCategory */
            $destinationCategory = $this->doctrine->getRepository(Category::class)->findOneBy(['id' => $destinationId]);
            if (!$destinationCategory) {
                throw new \Exception('Destination category doesn\'t exists. Operation aborted.');
            }

            $movedCount = 0;

            /** @var Book $book */
            foreach ($sourceCategory->getBooks() as $book) {
                $book->setCategory($destinationCategory);
                $this->logger->info('Book id='.$book->getId().', name='.$book->getName().' moved.');
                $movedCount++;
            }

            $this->doctrine->getManager()->flush();

            $this->logger->info('Moved '.$movedCount.' books from category "'.$sourceCategory->getName().'" to category "'.$destinationCategory->getName().'".');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        $this->logger->addNotice('Finish category changing.');
    }
}
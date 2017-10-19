<?php

namespace AppBundle\Command;

use AppBundle\Services\ApiClient;
use AppBundle\Services\ResponseHandlers\IResponseHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppNeoDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:neo:data')
            ->setDescription('Request the data from the last 3 days from nasa api and store it into DB')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var IResponseHandler $responseHandler */
        $responseHandler = $this->getContainer()->get('AppBundle\Services\ResponseHandlers\CommandHandler');

        /** @var ApiClient $apiClient */
        $apiClient = $this->getContainer()->get('api.client');

        $params = [
            'date_from' => (new \DateTime('now -3 days'))->format('Y-m-d'),
            'date_to' => ''
        ];

        $result = $apiClient->doRequest(ApiClient::FEED, $params, $responseHandler);

        $output->writeln(sprintf('Number of records: %d', $result));
    }
}

<?php

namespace AppBundle\Committee;

use AppBundle\Address\PostAddressFactory;
use AppBundle\Events;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CommitteeUpdateCommandHandler
{
    private $dispatcher;
    private $addressFactory;
    private $manager;
    private $committeeManager;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        ObjectManager $manager,
        PostAddressFactory $addressFactory,
        CommitteeManager $committeeManager
    ) {
        $this->dispatcher = $dispatcher;
        $this->manager = $manager;
        $this->addressFactory = $addressFactory;
        $this->committeeManager = $committeeManager;
    }

    public function handle(CommitteeCommand $command)
    {
        if (!$committee = $command->getCommittee()) {
            throw new \RuntimeException('A Committee instance is required.');
        }

        $committee->update(
            $command->name,
            $command->description,
            $this->addressFactory->createFromAddress($command->getAddress()),
            $command->getPhone(),
            $command->getPhoto()
        );

        // Uploads an ID photo
        if (null !== $command->getPhoto()) {
            $this->committeeManager->addPhoto($committee);
        }

        $committee->setSocialNetworks(
            $command->facebookPageUrl,
            $command->twitterNickname,
            $command->googlePlusPageUrl
        );

        $this->manager->persist($committee);
        $this->manager->flush();

        $this->dispatcher->dispatch(Events::COMMITTEE_UPDATED, new CommitteeWasUpdatedEvent($committee));
    }
}

<?php

namespace OroCRM\Bundle\ContactUsBundle\Migrations\DataFixtures\ORM\v1_0;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use OroCRM\Bundle\ContactUsBundle\Entity\ContactRequestStatus;

class LoadContactRequestStatusData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            'open'                     => 'Open',
            'resolved'                 => 'Resolved',
            'converted_to_lead'        => 'Converted to lead',
            'converted_to_opportunity' => 'Converted to opportunity',
        ];
        foreach ($data as $name => $label) {
            $status = new ContactRequestStatus($name);
            $status->setLabel($label);
            $manager->persist($status);
        }

        $manager->flush();
    }
}

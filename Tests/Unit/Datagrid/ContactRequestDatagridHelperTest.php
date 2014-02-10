<?php

namespace OroCRM\Bundle\ContactUsBundle\Tests\Unit\Datagrid;

use Oro\Bundle\WorkflowBundle\Entity\WorkflowStep;
use OroCRM\Bundle\ContactUsBundle\Datagrid\ContactRequestDatagridHelper;

class ContactRequestDatagridHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $em;

    /** @var ContactRequestDatagridHelper */
    protected $helper;

    public function setUp()
    {
        $this->em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()->getMock();

        $this->helper = new ContactRequestDatagridHelper($this->em);
    }

    public function tearDown()
    {
        unset($this->em, $this->helper);
    }

    public function testGetStatusChoices()
    {
        $step1 = new WorkflowStep();
        $step1->setLabel('Step 1 Label');

        $step2 = new WorkflowStep();
        $step2->setLabel('Step 2 Label');

        $mockRepo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()->getMock();

        $mockRepo->expects($this->once())->method('findByRelatedEntityByName')
            ->with('OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest')
            ->will($this->returnValue(['step1' => $step1, 'step2' => $step2]));

        $this->em->expects($this->any())
            ->method('getRepository')
            ->with('OroWorkflowBundle:WorkflowStep')
            ->will($this->returnValue($mockRepo));

        $result = $this->helper->getStatusChoices();

        $expectedResults = ['step1' => 'Step 1 Label', 'step2' => 'Step 2 Label'];
        $this->assertEquals($expectedResults, $result);
    }
}

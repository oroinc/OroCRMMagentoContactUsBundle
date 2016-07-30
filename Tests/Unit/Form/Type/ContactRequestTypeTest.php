<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Tests\Unit\Form\Type;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\EmbeddedFormInterface;

use OroCRM\Bundle\MagentoContactUsBundle\Form\Type\ContactRequestType;

class ContactRequestTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContactRequestType */
    protected $formType;

    public function setUp()
    {
        $this->formType = new ContactRequestType();
    }

    public function tearDown()
    {
        unset($this->formType);
    }

    public function testHasName()
    {
        $this->assertEquals('orocrm_magento_contactus_contact_request', $this->formType->getName());
    }

    public function testImplementEmbeddedFormInterface()
    {
        $this->assertTrue($this->formType instanceof EmbeddedFormInterface);

        $this->assertNotEmpty($this->formType->getDefaultCss());
        $this->assertInternalType('string', $this->formType->getDefaultCss());

        $this->assertNotEmpty($this->formType->getDefaultSuccessMessage());
        $this->assertInternalType('string', $this->formType->getDefaultSuccessMessage());
    }

    public function testBuildForm()
    {
        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')
            ->disableOriginalConstructor()->getMock();

        $fields = [];
        $builder->expects($this->exactly(10))
            ->method('add')
            ->will(
                $this->returnCallback(
                    function ($fieldName, $fieldType) use (&$fields) {
                        $fields[$fieldName] = $fieldType;

                        return new \PHPUnit_Framework_MockObject_Stub_ReturnSelf();
                    }
                )
            );

        $this->formType->buildForm($builder, ['dataChannelField' => true]);

        $this->assertSame(
            [
                'dataChannel'            => 'orocrm_channel_select_type',
                'firstName'              => 'text',
                'lastName'               => 'text',
                'organizationName'       => 'text',
                'preferredContactMethod' => 'choice',
                'phone'                  => 'text',
                'emailAddress'           => 'text',
                'contactReason'          => 'entity',
                'comment'                => 'textarea',
                'submit'                 => 'submit',
            ],
            $fields
        );
    }
}

<?php

namespace Oro\Bundle\MagentoContactUsBundle\Tests\Unit\Form\Type;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\EmbeddedFormInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Oro\Bundle\MagentoContactUsBundle\Form\Type\ContactRequestType;

class ContactRequestTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContactRequestType */
    protected $formType;

    /** @var LocalizationHelper|\PHPUnit_Framework_MockObject_MockObject */
    protected $localizationHelper;

    public function setUp()
    {
        $this->formType = new ContactRequestType();
        $this->localizationHelper = $this->createMock(LocalizationHelper::class);

        $this->formType->setLocalizationHelper($this->localizationHelper);
    }

    public function tearDown()
    {
        unset($this->formType);
    }

    public function testHasName()
    {
        $this->assertEquals('oro_magento_contactus_contact_request', $this->formType->getName());
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
        $builder->expects($this->exactly(9))
            ->method('add')
            ->will(
                $this->returnCallback(
                    function ($fieldName, $fieldType) use (&$fields) {
                        $fields[$fieldName] = $fieldType;

                        return new \PHPUnit_Framework_MockObject_Stub_ReturnSelf();
                    }
                )
            );

        $this->formType->buildForm($builder, ['dataChannelField' => false]);

        $this->assertSame(
            [
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

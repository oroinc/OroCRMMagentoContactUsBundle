<?php

namespace OroCRM\Bundle\ContactUsBundle\Tests\Unit\Entity;

use Oro\Bundle\IntegrationBundle\Entity\Channel;

use OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest;

class ContactRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        new ContactRequest();
    }

    public function testSettersAndGetters()
    {
        /** @var Channel $channel */
        $channel                = $this->getMock('Oro\Bundle\IntegrationBundle\Entity\Channel');
        $contactReason          = $this->getMock(
            'OroCRM\Bundle\ContactUsBundle\Entity\ContactReason',
            [],
            [uniqid('label')]
        );
        $firstName              = uniqid('firstName');
        $lastName               = uniqid('lastName');
        $email                  = uniqid('@');
        $comment                = uniqid('comment');
        $organizationName       = uniqid('organizationName');
        $preferredContactMethod = uniqid('preferredContactMethod');
        $feedback               = uniqid('feedback');
        $phone                  = uniqid('123123');
        $createdAt              = new \DateTime();
        $updatedAt              = new \DateTime();

        $request = new ContactRequest();
        $request->setChannel($channel);
        $request->setComment($comment);
        $request->setFeedback($feedback);
        $request->setEmailAddress($email);
        $request->setFirstName($firstName);
        $request->setLastName($lastName);
        $request->setPhone($phone);
        $request->setOrganizationName($organizationName);
        $request->setPreferredContactMethod($preferredContactMethod);
        $request->setContactReason($contactReason);
        $request->setCreatedAt($createdAt);
        $request->setUpdatedAt($updatedAt);

        $this->assertNull($request->getId());
        $this->assertSame($channel, $request->getChannel());
        $this->assertSame($contactReason, $request->getContactReason());
        $this->assertEquals($comment, $request->getComment());
        $this->assertEquals($feedback, $request->getFeedback());
        $this->assertEquals($organizationName, $request->getOrganizationName());
        $this->assertEquals($email, $request->getEmailAddress());
        $this->assertEquals($firstName, $request->getFirstName());
        $this->assertEquals($lastName, $request->getLastName());
        $this->assertEquals($phone, $request->getPhone());
        $this->assertEquals($preferredContactMethod, $request->getPreferredContactMethod());
        $this->assertEquals($createdAt, $request->getCreatedAt());
        $this->assertEquals($updatedAt, $request->getUpdatedAt());

        // should not provoke fatal error, because it's not mandatory field
        $request->setContactReason(null);
    }

    public function testBeforeSave()
    {
        $request = new ContactRequest();

        $this->assertNull($request->getCreatedAt());
        $this->assertNull($request->getUpdatedAt());

        $request->beforeSave();
        $this->assertNotNull($request->getCreatedAt());
        $this->assertInstanceOf('DateTime', $request->getCreatedAt());
        $this->assertNotNull($request->getUpdatedAt());
        $this->assertInstanceOf('DateTime', $request->getUpdatedAt());
        $this->assertSame($request->getCreatedAt(), $request->getUpdatedAt());
    }

    public function testDoPreUpdate()
    {
        $request   = new ContactRequest();
        $updatedAt = new \DateTime();
        $request->setUpdatedAt($updatedAt);

        $request->doPreUpdate();
        $this->assertNotNull($request->getUpdatedAt());
        $this->assertInstanceOf('DateTime', $request->getUpdatedAt());
        $this->assertNotSame($updatedAt, $request->getUpdatedAt());
    }

    /**
     * @dataProvider validationDataProvider
     *
     * @param mixed  $phone
     * @param mixed  $email
     * @param string $method
     * @param int    $expectedViolationCount
     */
    public function testValidationCallback($phone, $email, $method, $expectedViolationCount)
    {
        $request = new ContactRequest();
        $request->setPhone($phone);
        $request->setEmailAddress($email);
        $request->setPreferredContactMethod($method);

        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')
            ->disableOriginalConstructor()->getMock();
        $context->expects($this->exactly($expectedViolationCount))->method('addViolationAt');
        $request->validationCallback($context);
    }

    /**
     * @return array
     */
    public function validationDataProvider()
    {
        return [
            'phone only required'                 => [
                uniqid('phone'),
                null,
                ContactRequest::CONTACT_METHOD_PHONE,
                0
            ],
            'phone only required, error if empty' => [
                null,
                null,
                ContactRequest::CONTACT_METHOD_PHONE,
                1
            ],
            'email only required'                 => [
                null,
                uniqid('email'),
                ContactRequest::CONTACT_METHOD_EMAIL,
                0
            ],
            'email only required, error if empty' => [
                null,
                null,
                ContactRequest::CONTACT_METHOD_EMAIL,
                1
            ],
            'both required'                       => [
                null,
                null,
                ContactRequest::CONTACT_METHOD_BOTH,
                2
            ],
            'both required, email given only'     => [
                null,
                uniqid('email'),
                ContactRequest::CONTACT_METHOD_BOTH,
                1
            ],
            'both required, phone given only'     => [
                uniqid('phone'),
                null,
                ContactRequest::CONTACT_METHOD_BOTH,
                1
            ],
            'both required, both given'           => [
                uniqid('phone'),
                uniqid('email'),
                ContactRequest::CONTACT_METHOD_BOTH,
                0
            ],
        ];
    }
}

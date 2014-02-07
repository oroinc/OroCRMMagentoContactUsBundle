<?php

namespace OroCRM\Bundle\ContactUsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\ExecutionContext;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\IntegrationBundle\Model\IntegrationEntityTrait;
use Oro\Bundle\LocaleBundle\Model\FirstNameInterface;
use Oro\Bundle\LocaleBundle\Model\LastNameInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="orocrm_contactus_request")
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *  routeName="orocrm_contactus_request_index",
 *  defaultValues={
 *      "security"={
 *          "type"="ACL",
 *          "permissions"="All",
 *          "group_name"=""
 *      }
 *  }
 * )
 */
class ContactRequest implements FirstNameInterface, LastNameInterface
{
    const CONTACT_METHOD_BOTH  = 'orocrm.contactus.contactrequest.method.both';
    const CONTACT_METHOD_PHONE = 'orocrm.contactus.contactrequest.method.phone';
    const CONTACT_METHOD_EMAIL = 'orocrm.contactus.contactrequest.method.email';

    use IntegrationEntityTrait;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="smallint", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="organization_name", type="string", nullable=true)
     */
    protected $organizationName;

    /**
     * @var string
     *
     * @ORM\Column(name="preferred_contact_method", type="string", length=50)
     */
    protected $preferredContactMethod;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_reason", type="string", length=100, nullable=true)
     */
    protected $contactReason;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="text", nullable=true)
     */
    protected $feedback;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $comment;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $organizationName
     *
     * @return $this
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param string $preferredContactMethod
     *
     * @return $this
     */
    public function setPreferredContactMethod($preferredContactMethod)
    {
        $this->preferredContactMethod = $preferredContactMethod;
    }

    /**
     * @return string
     */
    public function getPreferredContactMethod()
    {
        return $this->preferredContactMethod;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $contactReason
     *
     * @return $this
     */
    public function setContactReason($contactReason)
    {
        $this->contactReason = $contactReason;
    }

    /**
     * @return string
     */
    public function getContactReason()
    {
        return $this->contactReason;
    }

    /**
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $feedback
     *
     * @return $this
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Pre persist event listener
     *
     * @ORM\PrePersist
     */
    public function beforeSave()
    {
        $this->createdAt = $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Pre update event handler
     *
     * @ORM\PreUpdate
     */
    public function doPreUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Validates contact method
     *
     * @param ExecutionContext $context
     */
    public function validationCallback(ExecutionContext $context)
    {
        $emailError = $phoneError = false;

        switch ($this->getPreferredContactMethod()) {
            case self::CONTACT_METHOD_PHONE:
                $phoneError = !$this->getPhone();
                break;
            case self::CONTACT_METHOD_EMAIL:
                $emailError = !$this->getEmail();
                break;
            case self::CONTACT_METHOD_BOTH:
            default:
                $phoneError = !$this->getPhone();
                $emailError = !$this->getEmail();
        }

        if ($emailError) {
            $context->addViolationAt('email', 'Email is required for chosen contact method');
        }
        if ($phoneError) {
            $context->addViolationAt('phone', 'Phone is required for chosen contact method');
        }
    }
}

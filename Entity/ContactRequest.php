<?php

namespace OroCRM\Bundle\ContactUsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\ExecutionContext;

use Oro\Bundle\EmailBundle\Entity\Email;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowItem;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowStep;
use Oro\Bundle\LocaleBundle\Model\FirstNameInterface;
use Oro\Bundle\LocaleBundle\Model\LastNameInterface;
use Oro\Bundle\IntegrationBundle\Model\IntegrationEntityTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;

use OroCRM\Bundle\CallBundle\Entity\Call;
use OroCRM\Bundle\SalesBundle\Entity\Lead;
use OroCRM\Bundle\SalesBundle\Entity\Opportunity;

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
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", nullable=true)
     */
    protected $emailAddress;

    /**
     * @var ContactReason
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactUsBundle\Entity\ContactReason")
     * @ORM\JoinColumn(name="contact_reason_id", referencedColumnName="id")
     **/
    protected $contactReason;

    /**
     * @var ContactRequestStatus
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactUsBundle\Entity\ContactRequestStatus")
     * @ORM\JoinColumn(name="contact_request_status_name", referencedColumnName="name", onDelete="SET NULL")
     **/
    protected $status;

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
     * @var Opportunity
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\SalesBundle\Entity\Opportunity")
     * @ORM\JoinColumn(name="opportunity_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $opportunity;

    /**
     * @var Lead
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\SalesBundle\Entity\Lead")
     * @ORM\JoinColumn(name="lead_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $lead;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="OroCRM\Bundle\CallBundle\Entity\Call")
     * @ORM\JoinTable(name="orocrm_contactus_request_calls",
     *      joinColumns={@ORM\JoinColumn(name="request_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="call_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $calls;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Oro\Bundle\EmailBundle\Entity\Email")
     * @ORM\JoinTable(name="orocrm_contactus_request_emails",
     *      joinColumns={@ORM\JoinColumn(name="request_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $emails;

    /**
     * TODO: Move field to custom entity config https://magecore.atlassian.net/browse/BAP-2923
     *
     * @var WorkflowItem
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\WorkflowBundle\Entity\WorkflowItem")
     * @ORM\JoinColumn(name="workflow_item_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $workflowItem;

    /**
     * TODO: Move field to custom entity config https://magecore.atlassian.net/browse/BAP-2923
     *
     * @var WorkflowStep
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\WorkflowBundle\Entity\WorkflowStep")
     * @ORM\JoinColumn(name="workflow_step_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $workflowStep;

    public function __construct()
    {
        $this->calls  = new ArrayCollection();
        $this->emails = new ArrayCollection();
    }

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
     *
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
     *
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
     *
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
     *
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
     *
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
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param ContactReason $contactReason
     *
     *
     */
    public function setContactReason(ContactReason $contactReason = null)
    {
        $this->contactReason = $contactReason;
    }

    /**
     * @return ContactReason
     */
    public function getContactReason()
    {
        return $this->contactReason;
    }

    /**
     * @param ContactRequestStatus $status
     *
     *
     */
    public function setStatus(ContactRequestStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return ContactRequestStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $comment
     *
     *
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
     *
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
     *
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
     *
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
     * @param Lead $lead
     */
    public function setLead(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param Opportunity $opportunity
     */
    public function setOpportunity(Opportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    /**
     * @return Opportunity
     */
    public function getOpportunity()
    {
        return $this->opportunity;
    }

    /**
     * @return ArrayCollection
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * @param Call $call
     */
    public function addCall(Call $call)
    {
        if (!$this->hasCall($call)) {
            $this->getCalls()->add($call);
        }
    }

    /**
     * @param Call $call
     */
    public function removeCall(Call $call)
    {
        if ($this->hasCall($call)) {
            $this->getCalls()->removeElement($call);
        }
    }

    /**
     * @param Call $call
     *
     * @return bool
     */
    public function hasCall(Call $call)
    {
        return $this->getCalls()->contains($call);
    }

    /**
     * @return ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param Email $email
     */
    public function addEmail(Email $email)
    {
        if (!$this->hasEmail($email)) {
            $this->getEmails()->add($email);
        }
    }

    /**
     * @param Email $email
     */
    public function removeEmail(Email $email)
    {
        if ($this->hasEmail($email)) {
            $this->getEmails()->removeElement($email);
        }
    }

    /**
     * @param Email $email
     *
     * @return bool
     */
    public function hasEmail(Email $email)
    {
        return $this->getEmails()->contains($email);
    }

    /**
     * @param WorkflowItem $workflowItem
     */
    public function setWorkflowItem(WorkflowItem $workflowItem)
    {
        $this->workflowItem = $workflowItem;
    }

    /**
     * @return WorkflowItem
     */
    public function getWorkflowItem()
    {
        return $this->workflowItem;
    }

    /**
     * @param WorkflowStep $workflowStep
     */
    public function setWorkflowStep(WorkflowStep $workflowStep)
    {
        $this->workflowStep = $workflowStep;
    }

    /**
     * @return WorkflowStep
     */
    public function getWorkflowStep()
    {
        return $this->workflowStep;
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
                $emailError = !$this->getEmailAddress();
                break;
            case self::CONTACT_METHOD_BOTH:
            default:
                $phoneError = !$this->getPhone();
                $emailError = !$this->getEmailAddress();
        }

        if ($emailError) {
            $context->addViolationAt('emailAddress', 'Email is required for chosen contact method');
        }
        if ($phoneError) {
            $context->addViolationAt('phone', 'Phone is required for chosen contact method');
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->createdAt = $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
        $em              = $eventArgs->getEntityManager();
        $defaultStatus   = $em->getReference('OroCRMContactUsBundle:ContactRequestStatus', 'open');
        $this->setStatus($defaultStatus);
    }
}

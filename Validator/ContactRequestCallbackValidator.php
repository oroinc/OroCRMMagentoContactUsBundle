<?php

namespace OroCRM\Bundle\ContactUsBundle\Validator;

use Symfony\Component\Validator\ExecutionContext;

use OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest;

class ContactRequestCallbackValidator
{
    /**
     * Validates contact method
     *
     * @param ContactRequest   $object
     * @param ExecutionContext $context
     */
    public static function validate(ContactRequest $object, ExecutionContext $context)
    {
        $emailError = $phoneError = false;

        switch ($object->getPreferredContactMethod()) {
            case ContactRequest::CONTACT_METHOD_PHONE:
                $phoneError = !$object->getPhone();
                break;
            case ContactRequest::CONTACT_METHOD_EMAIL:
                $emailError = !$object->getEmailAddress();
                break;
            case ContactRequest::CONTACT_METHOD_BOTH:
            default:
                $phoneError = !$object->getPhone();
                $emailError = !$object->getEmailAddress();
        }

        if ($emailError) {
            $context->addViolationAt('emailAddress', 'Email is required for chosen contact method');
        }
        if ($phoneError) {
            $context->addViolationAt('phone', 'Phone is required for chosen contact method');
        }
    }
}

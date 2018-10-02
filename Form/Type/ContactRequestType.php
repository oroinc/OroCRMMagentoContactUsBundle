<?php

namespace Oro\Bundle\MagentoContactUsBundle\Form\Type;

use Oro\Bundle\ContactUsBundle\Entity\ContactReason;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\EmbeddedFormInterface;

use Oro\Bundle\ContactUsBundle\Entity\ContactRequest;
use Oro\Bundle\ContactUsBundle\Entity\Repository\ContactReasonRepository;

/**
 * Represents contact request type for ContactRequest entity
*/
class ContactRequestType extends AbstractType implements EmbeddedFormInterface
{
    /**
     * @var LocalizationHelper
     */
    private $localizationHelper;

    /**
     * @param LocalizationHelper $localizationHelper
     */
    public function setLocalizationHelper(LocalizationHelper $localizationHelper)
    {
        $this->localizationHelper = $localizationHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oro_magento_contactus_contact_request';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['dataChannelField']) {
            $builder->add(
                'dataChannel',
                'oro_channel_select_type',
                [
                    'required' => false,
                    'label'    => 'oro.contactus.contactrequest.data_channel.label',
                    'entities' => [
                        'Oro\\Bundle\\ContactUsBundle\\Entity\\ContactRequest'
                    ],
                ]
            );
        }

        $builder->add('firstName', 'text', ['label' => 'oro.contactus.contactrequest.first_name.label']);
        $builder->add('lastName', 'text', ['label' => 'oro.contactus.contactrequest.last_name.label']);
        $builder->add(
            'organizationName',
            'text',
            ['required' => false, 'label' => 'oro.contactus.contactrequest.organization_name.label']
        );
        $builder->add(
            'preferredContactMethod',
            'choice',
            [
                'choices'  => [
                    ContactRequest::CONTACT_METHOD_BOTH  => ContactRequest::CONTACT_METHOD_BOTH,
                    ContactRequest::CONTACT_METHOD_PHONE => ContactRequest::CONTACT_METHOD_PHONE,
                    ContactRequest::CONTACT_METHOD_EMAIL => ContactRequest::CONTACT_METHOD_EMAIL
                ],
                'required' => true,
                'label'    => 'oro.contactus.contactrequest.preferred_contact_method.label',
                'client_validation' => false,
            ]
        );
        $builder->add(
            'phone',
            'text',
            ['required' => false, 'label' => 'oro.contactus.contactrequest.phone.label']
        );
        $builder->add(
            'emailAddress',
            'text',
            ['required' => false, 'label' => 'oro.contactus.contactrequest.email_address.label']
        );
        $builder->add(
            'contactReason',
            'entity',
            [
                'class'       => 'OroContactUsBundle:ContactReason',
                'choice_label' => function (ContactReason $entity) {
                    return $this->getLocalizationHelper()->getLocalizedValue($entity->getTitles());
                },
                'empty_value' => 'oro.contactus.contactrequest.choose_contact_reason.label',
                'required'    => false,
                'label'       => 'oro.contactus.contactrequest.contact_reason.label',
                'client_validation' => false,
                'query_builder' => function (ContactReasonRepository $er) {
                    return $er->getExistedContactReasonsQB()
                        ->addSelect('titles')
                        ->leftJoin('cr.titles', 'titles');
                },
            ]
        );
        $builder->add('comment', 'textarea', ['label' => 'oro.contactus.contactrequest.comment.label']);
        $builder->add('submit', 'submit');
    }

    /**
     * @return LocalizationHelper
     */
    private function getLocalizationHelper()
    {
        if (!$this->localizationHelper) {
            throw new \LogicException(sprintf('No localization helper set for %s type', get_class($this)));
        }

        return $this->localizationHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Oro\Bundle\ContactUsBundle\Entity\ContactRequest',
                'dataChannelField' => false
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getDefaultCss()
    {
        return <<<CSS
ul, li {
     list-style: none;
     overflow: hidden;
     clear: both;
     margin: 0;
 }
 textarea,
 input[type="text"],
 input[type="password"],
 input[type="datetime"],
 input[type="datetime-local"],
 input[type="date"],
 input[type="month"],
 input[type="time"],
 input[type="week"],
 input[type="number"],
 input[type="email"],
 input[type="url"],
 input[type="search"],
 input[type="tel"],
 input[type="color"],
 .uneditable-input {
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
    box-sizing: content-box;
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
}
select,
textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
.uneditable-input {
    border-radius: 3px;
    color: #555555;
    display: inline-block;
    font-size: 13px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 10px;
    padding: 4px 6px;
    vertical-align: middle;
}
textarea{
    resize: vertical;
    height: 150px;
}
select {
    height: 26px;
    line-height: 26px;
    border: 1px solid #ccc;
    width: 262px;
}
.page-title {
    width: 100%;
    overflow: hidden;
    border-bottom: 1px solid #ccc;
    margin: 0 0 25px;
}
 .page-title h1{
     margin: 0;
     font-size: 20px;
     color: #0a263c;
 }

.fieldset {
    border: 1px solid #bbafa0;
    background: #fbfaf6;
    padding: 22px 25px 12px 33px;
    margin: 28px 0;
    font-size: 13px;
    line-height: 16px;
    font-family: 'Helvetica Neue',Arial,Helvetica,sans-serif;
}

.fieldset .legend {
    float: left;
    font-size: 13px;
    line-height: 20px;
    border: 1px solid #f19900;
    background: #f9f3e3;
    color: #e76200;
    margin: -33px 0 0 -10px;
    padding: 0 8px;
    position: relative;
    font-family: 'Helvetica Neue',Arial,Helvetica,sans-serif;
    font-weight: bold;
}
.form-list{
    padding: 0;
}
.form-list .control-group {
    margin-bottom: 0px;
}
.form-list li{
    margin: 0 0 3px;
}
.form-list label {
    float: left;
    color: #666;
    font-weight: bold;
    position: relative;
    z-index: 0;
    margin-bottom: 0;
}
.form-list .controls {
    display: block;
    clear: both;
    width: 260px;
}

.form-list input[type="text"],
.form-list input[type="email"] {
    width: 254px;
    padding: 3px;
    margin-bottom: 3px;

}

.form-list li.wide .controls {
    width: 550px;
}

.form-list li.wide textarea {
    width: 100%;
    padding: 3px;
    margin-bottom: 3px;
}

.buttons-set {
    clear: both;
    margin: 4em 0 0;
    padding: 8px 10px 0;
    border-top: 1px solid #e4e4e4;
    text-align: right;
}

.buttons-set p.required {
    margin: 0 0 10px;
    font-size: 11px;
    text-align: right;
    color: #EB340A;
    font: 11px/14px Arial, Helvetica, sans-serif;
}

.buttons-set button {
    float: right;
    margin-left: 5px;
    display: block;
    height: 19px;
    border: 1px solid #de5400;
    background: #f18200;
    padding: 0 8px;
    font: bold 12px/19px Arial, Helvetica, sans-serif;
    text-align: center;
    white-space: nowrap;
    color: #fff;
    box-sizing: content-box;
}
.page-title h1{
    font: 20px/24px Arial, Helvetica, sans-serif;
}
span.validation-failed {
    color: #c81717;
    display: block;
    margin: 3px 0 5px 0px;
    font: bold 1em/1.1em 'Helvetica Neue',Arial,Helvetica,sans-serif;
}
label em {
    color: #eb340a;
    font-size: 16px;
}
CSS;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSuccessMessage()
    {
        return '<p>Form has been submitted successfully</p>{back_link}';
    }
}

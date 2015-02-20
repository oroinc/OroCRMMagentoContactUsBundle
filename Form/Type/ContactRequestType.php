<?php
namespace OroCRM\Bundle\MagentoContactUsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Oro\Component\Layout\LayoutManipulatorInterface;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\EmbeddedFormInterface;
use Oro\Bundle\EmbeddedFormBundle\Manager\LayoutUpdateInterface;

use OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest;

class ContactRequestType extends AbstractType implements EmbeddedFormInterface, LayoutUpdateInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'orocrm_magento_contactus_contact_request';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['dataChannelField']) {
            $builder->add(
                'dataChannel',
                'orocrm_channel_select_type',
                [
                    'required' => true,
                    'label'    => 'orocrm.contactus.contactrequest.data_channel.label',
                    'entities' => [
                        'OroCRM\\Bundle\\ContactUsBundle\\Entity\\ContactRequest'
                    ],
                ]
            );
        }

        $builder->add('firstName', 'text', ['label' => 'orocrm.contactus.contactrequest.first_name.label']);
        $builder->add('lastName', 'text', ['label' => 'orocrm.contactus.contactrequest.last_name.label']);
        $builder->add(
            'organizationName',
            'text',
            ['required' => false, 'label' => 'orocrm.contactus.contactrequest.organization_name.label']
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
                'label'    => 'orocrm.contactus.contactrequest.preferred_contact_method.label',
                'client_validation' => false,
            ]
        );
        $builder->add(
            'phone',
            'text',
            ['required' => false, 'label' => 'orocrm.contactus.contactrequest.phone.label']
        );
        $builder->add(
            'emailAddress',
            'text',
            ['required' => false, 'label' => 'orocrm.contactus.contactrequest.email_address.label']
        );
        $builder->add(
            'contactReason',
            'entity',
            [
                'class'       => 'OroCRMContactUsBundle:ContactReason',
                'property'    => 'label',
                'empty_value' => 'orocrm.contactus.contactrequest.choose_contact_reason.label',
                'required'    => false,
                'label'       => 'orocrm.contactus.contactrequest.contact_reason.label',
                'client_validation' => false,
            ]
        );
        $builder->add('comment', 'textarea', ['label' => 'orocrm.contactus.contactrequest.comment.label']);
        $builder->add('submit', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest',
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

    /**
     * {@inheritdoc}
     */
    public function updateLayout(LayoutManipulatorInterface $layoutManipulator)
    {
        $layoutManipulator->setBlockTheme('OroCRMMagentoContactUsBundle::MagentoContactForm.html.twig');
        $layoutManipulator
            ->remove('form')
            ->add(
                'embedded_form',
                'content',
                'form',
                [
                    'form_name' => 'embedded_form',
                    'preferred_fields' => [
                        'firstName',
                        'lastName',
                        'organizationName',
                        'preferredContactMethod',
                        'phone',
                        'emailAddress',
                        'contactReason'
                    ],
                    'groups'    => [
                        'contact' => [
                            'title'   => 'Contact Information',
                            'default' => true,
                        ],
                    ],
                ]
            )
            ->move('embedded_form_submit', 'embedded_form', 'embedded_form:group_contact');
    }
}

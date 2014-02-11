<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Controller;

use FOS\Rest\Util\Codes;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use OroCRM\Bundle\MagentoContactUsBundle\Entity\ContactRequest;

class ContactRequestController extends Controller
{
    /**
     * @Route("/view/{id}", name="orocrm_magento_contactus_request_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="orocrm_magento_contactus_request_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="OroCRMMagentoContactUsBundle:ContactRequest"
     * )
     */
    public function viewAction(ContactRequest $contactRequest)
    {
        return [
            'entity' => $contactRequest
        ];
    }

    /**
     * @Route(name="orocrm_magento_contactus_request_index")
     * @Template
     * @AclAncestor("orocrm_magento_contactus_request_view")
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/info/{id}", name="orocrm_magento_contactus_request_info", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("orocrm_magento_contactus_request_view")
     */
    public function infoAction(ContactRequest $contactRequest)
    {
        return [
            'entity' => $contactRequest
        ];
    }

    /**
     * @Route("/update/{id}", name="orocrm_magento_contactus_request_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="orocrm_magento_contactus_request_edit",
     *      type="entity",
     *      permission="EDIT",
     *      class="OroCRMMagentoContactUsBundle:ContactRequest"
     * )
     */
    public function updateAction(ContactRequest $contactRequest)
    {
        return $this->update($contactRequest);
    }

    /**
     * @Route("/create", name="orocrm_magento_contactus_request_create")
     * @Template("OroCRMMagentoContactUsBundle:ContactRequest:update.html.twig")
     * @Acl(
     *      id="orocrm_magento_contactus_request_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="OroCRMMagentoContactUsBundle:ContactRequest"
     * )
     */
    public function createAction()
    {
        return $this->update(new ContactRequest());
    }

    /**
     * @Route("/delete/{id}", name="orocrm_magento_contactus_request_delete", requirements={"id"="\d+"})
     * @Acl(
     *      id="orocrm_magento_contactus_request_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="OroCRMMagentoContactUsBundle:ContactRequest"
     * )
     */
    public function deleteAction(ContactRequest $contactRequest)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.entity_manager');

        $em->remove($contactRequest);
        $em->flush();

        return new JsonResponse('', Codes::HTTP_OK);
    }

    /**
     * @param ContactRequest $contactRequest
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(ContactRequest $contactRequest)
    {
        if ($this->get('orocrm_magento_contact_us.contact_request.form.handler')->process($contactRequest)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('orocrm.magentocontactus.contactrequest.entity.saved')
            );

            return $this->get('oro_ui.router')->redirectAfterSave(
                ['route'      => 'orocrm_magento_contactus_request_update',
                 'parameters' => ['id' => $contactRequest->getId()]
                ],
                ['route'      => 'orocrm_magento_contactus_request_view',
                 'parameters' => ['id' => $contactRequest->getId()]
                ],
                $contactRequest
            );
        }

        return [
            'entity' => $contactRequest,
            'form'   => $this->get('orocrm_magento_contact_us.contact_request.form')->createView(),
        ];
    }
}

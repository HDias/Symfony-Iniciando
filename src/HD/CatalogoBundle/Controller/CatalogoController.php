<?php

namespace HD\CatalogoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HD\CatalogoBundle\Entity\Catalogo;
use HD\CatalogoBundle\Form\CatalogoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//Checa a restrição de acesso a action via annotation = DELETEAction
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Catalogo controller.
 * 
 */
class CatalogoController extends Controller
{

    /**
     * Lists all Catalogo entities.
     * @Template("CatalogoBundle:Catalogo:index.html.twig")
     * Nesta Action foi configurado em routing.yml para usar annotation
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CatalogoBundle:Catalogo')->findAll();

        //Usando Annotation para definir o template
        return array(
            'entities' => $entities,
       );
    }
    /**
     * Creates a new Catalogo entity.
     * @Template()
     */
    public function createAction(Request $request)
    {
        $entity = new Catalogo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('catalogo_show', array('id' => $entity->getId())));
        }

        //Se o nome da Action corresponder ao nome do template
        // a annotation template() se encarrega de direcionar a action ao template 
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Catalogo entity.
     *
     * @param Catalogo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Catalogo $entity)
    {
        $form = $this->createForm(new CatalogoType(), $entity, array(
            'action' => $this->generateUrl('catalogo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Catalogo entity.
     *
     */
    public function newAction()
    {
        $entity = new Catalogo();
        $form   = $this->createCreateForm($entity);

        return $this->render('CatalogoBundle:Catalogo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Catalogo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CatalogoBundle:Catalogo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Catalogo entity.
     *
     */
    public function editAction($id)
    {
        // Para não ser necessário colocar as regras de acesso de todas as rotas no security.yml
        // Faça nos controllers
        if (false === $this->get('security.authorization_checker')->isGranted(
            'ROLE_ADMIN'
           )) {
            throw new AccessDeniedException("Somente ADMIN pode acessar");
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CatalogoBundle:Catalogo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Catalogo entity.
    *
    * @param Catalogo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Catalogo $entity)
    {
        $form = $this->createForm(new CatalogoType(), $entity, array(
            'action' => $this->generateUrl('catalogo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Catalogo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catalogo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('catalogo_edit', array('id' => $id)));
        }

        return $this->render('CatalogoBundle:Catalogo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Catalogo entity.
     * 
     * Para fazer a verificação de autenticação via Annotation
     * instale o JMSSecurityExtraBundle:
     * https://github.com/schmittjoh/JMSSecurityExtraBundle
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CatalogoBundle:Catalogo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catalogo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('catalogo'));
    }

    /**
     * Creates a form to delete a Catalogo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('catalogo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

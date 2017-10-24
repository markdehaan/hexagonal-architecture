<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegisterUserType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function listAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('AppBundle:User:list.html.twig', ['users' => $users]);
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm(RegisterUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();
            $this->get('command_bus')->handle($command);
            /*
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $message = new \Swift_Message('Welkom');
            $message->setFrom('no_reply@pizza-avond.webstores');
            $message->setTo($user->getEmail());
            $message->setBody(sprintf('Hallo %s, ook zin in een pizza?', $user->getName()));
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('user_list');
            */
        }

        return $this->render('AppBundle:User:create.html.twig', ['form' => $form->createView()]);
    }
}

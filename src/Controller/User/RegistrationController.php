<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\User\RegistrationType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="app_register")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, UserManager $userManager)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->render('user/registration.html.twig', ['form' => $form->createView()]);
        }

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('user/registration.html.twig', ['form' => $form->createView()]);
        }

        // set confirmation token
        $userManager->updatePassword($user);

        // persist customer and user
        $userManager->saveUser($user);

        // authenticate created user
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'app_user_provider', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set(User::FIRST_LOGIN_FLAG, true);

        // redirect to thanks page
        return $this->redirectToRoute('app_homepage');
    }
}

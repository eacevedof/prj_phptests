<?php
namespace DesignPatterns\SrtaDeveloper\Webapp;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Commdand\RegisterUserAccountCommand;

class UserAccountController extends Controller
{
    public function registerAction(Request $request)
    {
        //... more things to do
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $comandBus = $this->get("app.application.command_bus");
            list($email,$password,$firstnme,$lastname) = $form->getData();
            $command = new RegisterUserAccountCommand($email,$password,$firstnme,$lastname);
            $comandBus->execute($command);
            return new Response();
        }

        return $this->render("UserManagementBundle:UserAccount:register.html.twig",["form"=>$form->createView()]);
    }//registerAction

}//UserAccountController

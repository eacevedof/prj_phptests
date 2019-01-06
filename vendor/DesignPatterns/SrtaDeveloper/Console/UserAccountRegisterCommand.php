<?php
namespace DesignPatterns\SrtaDeveloper\Console;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInteface;

use App\Commdand\RegisterUserAccountCommand;

class UserAccountRegisterCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName("utils:useraccount:register")
            ->setDescription("Registra cuentas de usuario.")
            ->setHelp("El comando <info>%command.name%</info> registra las cuentas de usuario en el fichero.")
            ->addArgument("filepath",InputArgument::REQUIRED,"Who do you want to greet?");
    }//configure

    public function execute(InputInterface $input,OutputInteface $output)
    {
        $filepath = $input->getArgument("filepath");
        $fp = fopen($filepath,"r");
        $commandBus = $this->get("app.application.command_bus");
        while($row = fgetcsv($fp,1024))
        {
            list($email,$passwor,$firstname,$lastname) = $row;
            $command = new RegisterUserAccountCommand($email,$passwor,$firstname,$lastname);
            $commandBus->execute($command);
        }
    }//execute

}//UserAccountRegisterCommand

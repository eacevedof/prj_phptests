<?php
namespace DesignPatterns\SrtaDeveloper\Behat;

use DesignPatterns\SrtaDeveloper\App\Command\RegisterUserAccountCommand;

class TestUserAccount 
{
    public function queSolicitoRegistrarmeConLosDatos(Request $request)
    {
        $table = $table->getRowsHash();
        $command = new RegisterUserAccountCommand(
            $table["email"],
            $table["clave"],
            $table["nombre"],
            $table["apellids"]
        );
        $this->getCommandBus()->execute($command);
    }//queSolicitoRegistrarmeConLosDatos

    /**
     * @Then se crea el usuario con email :email
     */
    public function seCreaElUsuarioConEmail($email)
    {
        $userAccountRepository = $this->getContainer()->get("app.domain.user_account.repository");
        $userAccount = $userAccountRepository->findByEmail($email);

        \Assert\that($userAccount)->notNull();
        \Assert\that($userAccount->getEmail()==$email)->true();

    }//seCreaElUsuarioConEmail

    public function seNotificaElMensajeAlEmail($message,$email)
    {
        foreach($this->getMailerAdapter()->getEmails() as $emailMessage)
        {
            if($emailMessage["subject"] === $message && $emailMessage["to"]===$email)
            {
                return;
            }
        }
        throw new \Exeption("Expected email '$message' not sent to '$email'.");
    }//seNotificaElMensajeAlEmail

}//TestUserAccount

<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name DesignPatterns\App\Handler\RegisterUserAccountCommandHandler
 * @file RegisterUserAccountCommandHandler.php
 * @version 1.0.0
 * @date 02-09-2018 17:21
 * @observations
 *  Ejemplo []()
 */
namespace DesignPatterns\SrtaDeveloper\App\Handler;

class RegisterUserAccountCommandHandler implements CommandHandlerInterface
{
    private $factory;
    private $repository;

    public function __construct(UserAccountFactoryInterface $factory, UserAccountRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;

    }//_construct

    public function handle(RegisterUserAccountCommand $command)
    {
        $userAccount = $this->factory->createUserAccount(
            $command->getEmail(),
            $command->getPassword(),
            $command->getFirstName(),
            $command->getLastName()
        );
        $this->repository->add($userAccount);
    }//handle

}//RegisterUserAccountCommandHandler
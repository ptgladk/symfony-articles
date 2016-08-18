<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class AdminCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:create')
            ->setDescription('Create admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $defaultAdminParams = $this->getContainer()->getParameter('default_admin');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $admin = $em->getRepository('AppBundle:User')->findOneBy(array(
            'username' => 'admin'
        ));

        $message = '<info>Admin was created (username: ' . $defaultAdminParams['username'] .
            ' / password: ' . $defaultAdminParams['password'] . ')</info>';

        if (!$admin) {
            $this->createAdmin($defaultAdminParams);
            $output->writeln($message);
        } else {
            $question = $this->getHelperSet()->get('question');
            $confirmation = new ConfirmationQuestion(
                '<question>Admin already exist. Do you want to rewrite admin data y/N ?</question>',
                false
            );
            if ($question->ask($input, $output, $confirmation)) {
                $this->createAdmin($defaultAdminParams, $admin);
                $output->writeln($message);
            }
        }
    }

    /**
     * @param array $params
     * @param User $admin
     */
    protected function createAdmin(array $params, $admin = null)
    {
        if (!$admin) {
            $admin = new User();
        }
        $admin->setUsername($params['username']);
        $admin->setPassword($params['password']);
        $admin->setEmail($params['email']);
        $admin->setRole(User::ROLE_ADMIN);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($admin);
        $em->flush();
    }
}
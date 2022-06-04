<?php

namespace App\Controller;

use App\Entity\Users;
use DateTimeImmutable;
use App\Model\UsersDTO;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractFOSRestController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SecurityController.php',
        ]);
    }
        /**
     * @Route("api/activate/{salt}/{id}", name="app_activation")
     */
    public function activate ($salt,? Users $users,EntityManagerInterface $em){
        $usersRepo=$em->getRepository(Users::class);
        $usersbis=$usersRepo->findOneBy(['salt' => $salt]);
        if (isset($usersbis) && isset($users) && $usersbis->getId()==$users->getId())
        {
            $users->setIsActif(1);
            $em->persist($users);
            $em->flush();
            //RedirectResponse
            return $this->redirect("http://localhost:4200/");
        }
        return $this->redirect("http://localhost:4200/");

    }

    /**
     * @Rest\Post("/api/register", name="app_register")
     * @Rest\View()
     * @ParamConverter("dto",converter="fos_rest.request_body")
     */
    public function register(EntityManagerInterface $em,ConstraintViolationList $violations,UsersDTO $dto,UserPasswordHasherInterface $hasher, MailerInterface $mailer){
     if ($violations->__toString()!=''){
         return $this->view(["errors" => $violations]);
     }
        $salt=uniqid();
        $users=$dto->toEntity();
        $datetimeImmutable = new DateTimeImmutable();
        $users->setCreatedAt($datetimeImmutable);
        $users->setSalt($salt);
        // $hasher = $hasherFactory->getPasswordHasher($users->getPassword());
        
        // $hashedPassword = $hasher->hash($users->getPassword());
        
        // $users->setPassword($hashedPassword);
        // $encoded = $encoder->encodePassword($users, $users->getPassword());
        // $users->setPassword($encoded);
        $users->setPassword($hasher->hashPassword($users, $users->getPassword()));
        $users->setIsActif(0);
        $users->setIsDeleted(0);
        $em->persist($users);
        $em->flush();
        $email=(new Email())->to($users->getEmail())
        ->subject('Bienvenue sur le site D-Livre&Moi de E6K')
        ->text('https://localhost:8000/api/activate/'.$users->getSalt().'/'.$users->getId().' Veuillez cliquer sur ce lien pour activer votre compte')
        ->html('<div><a href="https://localhost:8000/api/activate/'.$users->getSalt().'/'.$users->getId().'">Veuillez cliquer sur ce lien pour activer votre compte </a></div>')
        ->from("arbreplantebuisson@gmail.com");
        $mailer->send($email);
        return $this->view(["users"=> $users],Response::HTTP_CREATED);
    }


        /**
     * @Rest\Get(path="/api/users/email/{email}", name="personne_getbyemail")
     */
    public function getbyEmail($email,EntityManagerInterface $em)
    {
        $usersRepo=$em->getRepository(Users::class);
        $user=$usersRepo->findOneBy(['email' => $email]);
        if($user instanceof Users) {

            return $this->view([
                true
             ]);
            }
        else{
            return $this->view([
                false
             ]);
        }    

    }
}

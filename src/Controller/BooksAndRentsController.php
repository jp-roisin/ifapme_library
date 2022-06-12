<?php

namespace App\Controller;

use DateInterval;
use App\Entity\Users;
use App\Entity\BooksAndRents;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BooksAndRentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BooksAndRentsController extends AbstractFOSRestController
{
    #[Route('/super_bro', name: 'app_books_and_rents', methods: ['GET', 'POST'])]
    public function super_bro(BooksAndRentsRepository $repo): Response
    {
        $bev=json_encode($repo->findByISBN("9781781101032"), JSON_NUMERIC_CHECK);
        dd($bev);
        return $this->json([$bev,Response::HTTP_ACCEPTED]);
    }


    #[Route('/books/all', name: 'app_books_and_rents_all', methods: ['GET', 'POST'])]
    public function getAll(BooksAndRentsRepository $repo): Response
    {
        return $this->json(['BooksAll'=>$repo->findAll(),Response::HTTP_ACCEPTED]);
    }

    #[Route('/books/ISBN/{ISBN}', name: 'app_books_and_rents_ISBN', methods: ['GET', 'POST'])]
    public function findByISBN($ISBN, BooksAndRentsRepository $repo): Response
    {
        $BOOKS=$repo->findByISBN($ISBN);
        if ($BOOKS===[]){
            return $this->json(['BooksAll'=>"no books",Response::HTTP_NO_CONTENT]);
        }
        else{
            return $this->json(['BooksAll'=>$BOOKS,Response::HTTP_ACCEPTED]);
        }
    }

    //  // #[Route('/create/location', name: 'answer_question', methods: ['GET', 'POST'])]
    // // #[ParamConverter('BooksAndRents', class: BooksAndRents::class,  options: ['mapping' => ['slug' => 'slug']])] 


    /**
     * @Rest\Post("/api/create/location", name="books_rents")
     * @Rest\View()
     * @ParamConverter("BooksAndRents",converter="fos_rest.request_body")
     */
    public function addFollow(Request $req, BooksAndRents $BooksAndRents,ManagerRegistry $doctrine, UsersRepository $repoUser){
        $em = $doctrine->getManager();
        $BooksAndRents->setRentStartedAt(new \DateTime("now"));
        $dateEnd=new \DateTime("now");
        $oldDay = $dateEnd->format("d");
        $dateEnd->add(new \DateInterval("P1M"));
        $BooksAndRents->setRentEndedAt($dateEnd);
        if($BooksAndRents->getIsRented()==0){
             $BooksAndRents->setIsRented(1);
            }
        else {
            $BooksAndRents->setIsRented(0);
        }
        $em->persist($BooksAndRents);
         $em->flush();
        return $this->view("| Response :".Response::HTTP_CREATED." |");
    }


    
    /**
     * @Rest\Post("/api/searchBOOKS/{ISBN}", name="search_books")
     * @Rest\View()
     */
    public function createBooksAndRents($ISBN,ManagerRegistry $doctrine){
        $curl = curl_init();
        $em = $doctrine->getManager();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://www.googleapis.com/books/v1/volumes?q=isbn:".$ISBN,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER=> 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CONNECTTIMEOUT=> 30,
            CURLOPT_POST=> true,
            CURLOPT_CUSTOMREQUEST => "GET"
        ]);

        $response = curl_exec($curl);
        $response = json_decode($response,true);
        
        curl_close($curl);
        $response=$response["items"];
        // return $response;
        foreach ($response as $bookAPI) {
            $bookAndRents = new BooksAndRents;
            $bookAndRents->setIsbn($bookAPI["volumeInfo"]["industryIdentifiers"][0]["identifier"]);
            if(isset($bookAPI["volumeInfo"]["authors"][0]))
            {
                $bookAndRents->setAuthor($bookAPI["volumeInfo"]["authors"][0]);
            }
           
            $bookAndRents->setTitle($bookAPI["volumeInfo"]["title"]);

            if(isset($bookAPI["volumeInfo"]["publisher"]))
                {
                    $bookAndRents->setPublisher($bookAPI["volumeInfo"]["publisher"]);
                }

                if(isset($bookAPI["volumeInfo"]["categories"]))
                {
                    $bookAndRents->setCategory($bookAPI["volumeInfo"]["categories"][0]);
                }
                if(isset($bookAPI["volumeInfo"]["description"]))
                {
                    $bookAndRents->setDescription($bookAPI["volumeInfo"]["description"]);
                }
                if(isset($bookAPI["volumeInfo"]["imageLinks"]["smallThumbnail"]))
                {
                    $bookAndRents->setCover($bookAPI["volumeInfo"]["imageLinks"]["smallThumbnail"]);
                }
         
            $bookAndRents->setLanguage($bookAPI["volumeInfo"]["language"]);
            $em->persist($bookAndRents);
          
        }
        $em->flush();

        return $this->view("| Response :".Response::HTTP_CREATED." |");
    }
}

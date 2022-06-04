<?php

namespace App\DataFixtures;

use App\Entity\BooksAndRents;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://www.googleapis.com/books/v1/volumes?q=intitle:harry+potter&maxResults=40&langRestrict=fr",
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
            $manager->persist($bookAndRents);
        }
        $manager->flush();
    }

}

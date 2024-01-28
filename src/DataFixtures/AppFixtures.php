<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Intern;
use App\Entity\Company;
use App\Entity\Industry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Adding Admins
        /*$admins = [
            // An array containing admin data
            // Email, first name, and last name of each admin
            [
                "email" => "maxime@oclock.io",
                "firstname" => "Maxime",
                "lastname" => "LE GENTIL"
            ],
            [
                "email" => "chokri@oclock.io",
                "firstname" => "Chokri",
                "lastname" => "KRAIEM"
            ],
            [
                "email" => "thomas@oclock.io",
                "firstname" => "Thomas",
                "lastname" => "MORIN"
            ],
            [
                "email" => "florent@oclock.io",
                "firstname" => "Florent",
                "lastname" => "CORNIAU"
            ],
            [
                "email" => "mael@oclock.io",
                "firstname" => "Mael",
                "lastname" => "ROUE"
            ]
        ];

        // Loop through admin data and create Admin entities
        for ($i = 0; $i <= 4; $i++)
        {
            // Create a new Admin entity
            $admin = new Admin();

            // Set properties inherited from "User" for each admin
            $admin->setEmail($admins[$i]["email"]);
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setPassword('$2y$10$CgNmX5BtDFIj0CGIvtp/Bul60TXBZaZ/4tkPqKWcqqn6FiLX1JOO.'); // Hash du mot de passe "admin"
            $admin->setCreatedAt(new \DateTimeImmutable());

            $admin->setFirstname($admins[$i]["firstname"]);
            $admin->setLastname($admins[$i]["lastname"]);

            $manager->persist($admin);
        }

        // Adding Companies
        $companys = [
            // An array containing company data with email addresses
            [
                "email" => "decathlon@oclock.io"
            ],
            [
                "email" => "intersport@oclock.io"
            ],
            [
                "email" => "kfc@oclock.io"
            ],
            [
                "email" => "burgerking@oclock.io"
            ],
            [
                "email" => "sport2000@oclock.io"
            ]
        ];

        // An array containing company data with email addresses
        for ($i = 0; $i < 5; $i++)
        {
            // Create a new Company entity
            $company = new Company();

             // Set properties inherited from "User" for each company
            $company->setEmail($companys[$i]["email"]);
            $company->setRoles(['ROLE_COMPANY']);
            $company->setPassword('$2y$10$CgNmX5BtDFIj0CGIvtp/Bul60TXBZaZ/4tkPqKWcqqn6FiLX1JOO.'); // Hashing password's "admin"
            $company->setCreatedAt(new \DateTimeImmutable());

             // Include details such as name, region, SIRET number, LinkedIn URL, and description
            $company->setName('Entreprise Corporation' . $i); // Exemple : Entreprise Corporation 1 etc
            $company->setRegion('Charente-Maritime');
            $company->setSiretNumber(mt_rand(10000000000000, 99999999999999));
            $company->setLinkedin('https://www.linkedin.com/in/entreprise-' . $i); // Exemple : https://www.linkedin.com/in/entreprise-1 etc
            $company->setDescription('Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans.');

            $manager->persist($company);
        }

            // Adding Interns
            $interns = [
            // An array containing intern data with email addresses, first names, and last names
            [
                    "email" => "nouveau1@oclock.io",
                    "firstname" => "Prénom 1",
                    "lastname" => "Intern 1"                
                ],
                [
                    "email" => "nouveau2@oclock.io",
                    "firstname" => "Prénom 2",
                    "lastname" => "Intern 2"                 
                ],
                [
                    "email" => "nouveau3@oclock.io",
                    "firstname" => "Prénom 3",
                    "lastname" => "Intern 3"             
                ],
                [
                    "email" => "nouveau4@oclock.io",
                    "firstname" => "Prénom 4",
                    "lastname" => "Intern 4"           
                ],
                [
                    "email" => "nouveau5@oclock.io",
                    "firstname" => "Prénom 5",
                    "lastname" => "Intern 5"             
                ]
            ];

        // Loop through intern data and create Intern entities
        for ($i = 0; $i < 5; $i++)
        {
            // Create a new Intern entity
            $intern = new Intern();

            // Set properties inherited from "User" for each intern
            $intern->setEmail($interns[$i]["email"]);
            $intern->setRoles(['ROLE_INTERN']);
             // Include details such as first name, last name, region, LinkedIn URL, description, etc.
            $intern->setFirstname($interns[$i]["firstname"]);
            $intern->setLastname($interns[$i]["lastname"]);
            $intern->setPassword('$2y$10$CgNmX5BtDFIj0CGIvtp/Bul60TXBZaZ/4tkPqKWcqqn6FiLX1JOO.'); // Hash du mot de passe "admin" 
            $intern->setCreatedAt(new \DateTimeImmutable());           
            $intern->setRegion('Charente-Maritime');          
            $intern->setLinkedin('https://www.linkedin.com/in/entreprise-' . $i); // Exemple : https://www.linkedin.com/in/entreprise-1 etc
            $intern->setDescription('Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans.');

            $manager->persist($intern);
        }*/

        // Adding Industries
        $industries = [
            // An array containing names of different industries
            'Agroalimentaire',
            'Banque / Assurance',
            'Bois / Papier / Carton / Imprimerie',
            'BTP / Matériaux de construction',
            'Chimie / Parachimie',
            'Commerce / Négoce / Distribution',
            'Édition / Communication / Multimédia',
            'Électronique / Électricité',
            'Études et conseils',
            'Industrie pharmaceutique',
            'Informatique / Télécoms',
            'Machines et équipements / Automobile',
            'Métallurgie / Travail du métal',
            'Plastique / Caoutchouc',
            'Services aux entreprises',
            'Textile / Habillement / Chaussure',
            'Transports / Logistique',
        ];

        // Loop through industry names and create Industry entities
        for ($i = 0; $i < count($industries); $i++)
        {
            // Create a new Industry entity for each industry name
            $industry = new Industry();
            // Set the name of the industry and other relevant details
            $industry->setName($industries[$i]);
            $industry->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($industry);
        }

        // Commit all changes to the database
        $manager->flush();
    }

}
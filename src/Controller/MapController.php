<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MapController extends AbstractController
{
    #[Route('/', name: 'app_map')]
    public function index(): Response
    {

// Adresse IP à géolocaliser
$ipAddress = '176.144.37.250'; // Remplacez par l'adresse IP à géolocaliser

// URL de l'API ip-api.com
$url = "http://ip-api.com/json/$ipAddress";

// Récupération des données JSON depuis l'API
$response = file_get_contents($url);

// Décodage des données JSON en tableau associatif
$data = json_decode($response, true);

// Vérification si la requête a réussi
if ($data['status'] == 'success') {
    // Affichage des informations de localisation
    echo "City: {$data['city']}\n";
    echo "Country: {$data['country']}\n";
    echo "Latitude: {$data['lat']}\n";
    echo "Longitude: {$data['lon']}\n";
} else {
    // Affichage de l'erreur si la requête a échoué
    echo "Erreur: {$data['message']}\n";
}








        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }
}

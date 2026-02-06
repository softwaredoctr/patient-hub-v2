<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Enum\AccountSourceType;
use App\Service\ChargeService;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PatientController extends AbstractController
{
    #[Route('/patient/{id}', name: 'patient_show')]
    public function show(Patient $patient): Response {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/visit-item/{id}/charge', name: 'visit_item_charge', methods: ['POST'])]
    public function chargeVisitItem(
        \App\Entity\VisitItem $visitItem,
        ChargeService $chargeService
    ): Response {
        $chargeService->chargeVisitItem($visitItem, $this->getUser());

        return $this->redirectToRoute('patient_show', [
            'id' => $visitItem->getVisit()->getPatient()->getId(),
        ]);
    }

    #[Route('/visit-item/{id}/remove-charge', name: 'visit_item_remove_charge', methods: ['POST'])]
    public function removeCharge(
        \App\Entity\VisitItem $visitItem,
        ChargeService $chargeService
    ): Response {
        $chargeService->removeCharge(
            $visitItem,
            'Removed by staff',
            $this->getUser()
        );

        return $this->redirectToRoute('patient_show', [
            'id' => $visitItem->getVisit()->getPatient()->getId(),
        ]);
    }

    #[Route('/patient/{id}/pay', name: 'patient_pay', methods: ['POST'])]
    public function pay(Patient $patient,Request $request,PaymentService $paymentService): Response {
        
        $paymentService->recordPayment(
            $patient,
            $request->request->get('amount'),
            AccountSourceType::MANUAL,
            $this->getUser(),
            'Manual payment recorded'
        );

        return $this->redirectToRoute('patient_show', [
            'id' => $patient->getId(),
        ]);
    }
}

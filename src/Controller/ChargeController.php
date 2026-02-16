<?php

namespace App\Controller;

use App\Entity\VisitItem;
use App\Service\ChargeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STAFF')]
final class ChargeController extends AbstractController
{
    #[Route('/visit-item/{id}/charge', name: 'visit_item_charge', methods: ['POST'])]
    public function charge(VisitItem $visitItem,ChargeService $chargeService): RedirectResponse {
        $chargeService->chargeVisitItem(
            $visitItem,
            $this->getUser()
        );

        return $this->redirectToRoute('visit_show', [
            'id' => $visitItem->getVisit()->getId(),
        ]);
    }

    #[Route('/visit-item/{id}/remove-charge', name: 'visit_item_remove_charge', methods: ['POST'])]
    public function removeCharge(VisitItem $visitItem, ChargeService $chargeService): RedirectResponse {
        $chargeService->removeCharge(
            $visitItem,
            'Removed by staff',
            $this->getUser()
        );

        return $this->redirectToRoute('visit_show', [
            'id' => $visitItem->getVisit()->getId(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\ConditionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LifeController extends AbstractController
{
    /**
     * @Route("/estateData/?moveToCity={moveToCity}&moveFromCity={moveFromCity}", name="cityMove")
     */
    public function getEstateData(Request $request, ConditionsRepository $conditionsRepository)
    {
        return $this->render('life.html.twig', [
            'moveFromEstate' => $conditionsRepository->getCity($request->get('moveFromCity')),
            'moveToEstate' => $conditionsRepository->getCity($request->get('moveToCity')),
            'moveToData' => $conditionsRepository->getCityIndeces($request->get('moveToCity')),
            'moveFromData' => $conditionsRepository->getCityIndeces($request->get('moveFromCity')),
            'moveToCity' => $request->get('moveToCity'),
            'moveFromCity' => $request->get('moveFromCity')
        ]);
    }

    /**
     * @Route("/")
     */
    public function getCityList(Request $request, ConditionsRepository $conditionsRepository)
    {
        $rows = $conditionsRepository->getCityList()['rows'];
        $cities = [];

        foreach ($rows as $row) {
            $cities[$row[0]['value']] = $row[0]['value'];
        }

        $form = $this->createFormBuilder()
            ->add('moveFromCity', ChoiceType::class, [
                'label' => 'Odkud',
                'choices' => $cities,
                'attr'=> ['class' => 'select2']
            ])
            ->add('moveToCity', ChoiceType::class, [
                'label' => 'Kam',
                'choices' => $cities,
                'attr' => ['class' => 'select2']
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            return $this->redirect($this->generateUrl("cityMove", [
                'moveFromCity' => $form->get('moveFromCity')->getData(),
                'moveToCity' => $form->get('moveToCity')->getData(),
            ]));
        }

        return $this->render('list.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
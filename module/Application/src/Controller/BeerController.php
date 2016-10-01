<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BeerController extends AbstractActionController
{
    public $tableGateway;

    public function __construct($tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function indexAction()
    {
        $beers = $this->tableGateway->select()->toArray();

        return new ViewModel(['beers' => $beers]);
    }

    public function createAction()
    {
        $form = new \Application\Form\Beer;
        foreach ($form->getElements() as $element) {
            if (! $element instanceof \Zend\Form\Element\Submit) {
                $element->setAttributes([
                    'class' => 'form-control'
                ]);
            }
        }
        $view = new ViewModel(['form' => $form]);
        $view->setTemplate('application/beer/save.phtml');

        return $view;
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $beer = $this->tableGateway->select(['id' => $id]);
        if (count($beer) == 0) {
            throw new \Exception("Beer not found", 404);
        }

        $this->tableGateway->delete(['id' => $id]);

        // return $this->redirect()->toUrl('/beer');
        return $this->redirect()->toRoute('beer');
    }
}

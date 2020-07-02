<?php declare(strict_types=1);

namespace App\Application\Service\ViewModel;

use LSBProject\RequestBundle\Request\AbstractRequest;

interface ViewModelInterface
{
    public function createView(AbstractRequest $request): ViewInterface;
}

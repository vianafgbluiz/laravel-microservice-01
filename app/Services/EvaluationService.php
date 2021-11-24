<?php

namespace App\Services;

use Carlosfgti\MicroservicesCommon\Services\Traits\ConsumeExternalService;

class EvaluationService
{

    use ConsumeExternalService;

    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = config('services.micro_02.token');
        $this->url = config('services.micro_02.url');
    }

    public function getEvaluationsCompany(string $company)
    {
        return $this->request('get', "/evaluations/{$company}");
    }
}

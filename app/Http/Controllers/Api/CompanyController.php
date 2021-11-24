<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    protected $repository;
    protected $evaluationService;

    public function __construct(
        Company $model,
        EvaluationService $evaluationService
    )
    {
        $this->evaluationService = $evaluationService;
        $this->repository = $model;
    }

    public function index(Request $request)
    {
        $companies = $this->repository->getCompanies($request->get('filter', ''));

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao listar empresas',
            'data' => [
                'companies' => CompanyResource::collection($companies)
            ]
        );

        return response()->json($data);
    }

    public function store(StoreUpdateCompanyRequest $request)
    {
        $company = $this->repository->create($request->validated());

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao adicionar empresa',
            'data' => [
                'company' => new CompanyResource($company)
            ]
        );

        return response()->json($data, 201);
    }

    public function show($uuid)
    {
        $company = $this->repository->with('category')->where('uuid', $uuid)->firstOrFail();

        $evaluations = $this->evaluationService->getEvaluationsCompany($uuid);

//        $data = array(
//            'success' => true,
//            'message' => 'Sucesso ao exibir empresa',
//            'data' => [
//                'company' =>
//            ]
//        );

        return (new CompanyResource($company))->additional([
            'evaluations' => $evaluations->json()['data']['evaluations']
        ]);
    }

    public function update(StoreUpdateCompanyRequest $request, $uuid)
    {
        $company = $this->repository->with('category')->where('uuid', $uuid)->firstOrFail();

        $company->update($request->validated());

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao atualizar empresa'
        );

        return response()->json($data, 200);
    }

    public function destroy($uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();

        $company->delete();

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao remover a empresa'
        );

        return response()->json($data, 200);
    }
}

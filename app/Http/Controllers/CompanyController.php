<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        return response()->json([
            'companies' => $request->user()->companies->map(function ($company) {
                return $company->only(['title', 'phone', 'description']);
            })
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'companies' => 'present|array',
            'companies.*.title' => 'required|string|min:3|max:55',
            'companies.*.phone' => 'nullable|string|max:13',
            'companies.*.description' => 'nullable|string|max:255',
        ]);
        foreach ($request->input('companies') as $data) {
            $company = new Company();
            $company->fill([
                'user_id' => $request->user()->id,
                'title' => $data['title'],
                'phone' => !empty($data['phone']) ? $data['phone'] : null,
                'description' => !empty($data['description']) ? $data['description'] : null
            ])->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'All companies created successfully'
        ]);
    }
}

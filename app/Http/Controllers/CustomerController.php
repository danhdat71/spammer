<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterCustomerRequest;
use App\Http\Requests\UpdateCustomerInfoRequest;
use App\Imports\CustomerImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Services\SmsService;
use Throwable;

class CustomerController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * paginate
     *
     * @var int
     */
    protected $paginate = 20;

    /**
     * importExcel
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function importExcel(Request $request): JsonResponse
    {
        try {
            $fileExcel = $request->file('excel');
            Excel::import(new CustomerImport, $fileExcel);

            return $this->messageSuccess('Import thành công !');
        } catch (Throwable $th) {
            return $this->responseFail($th->getMessage());
        }
    }

    /**
     * get customer list
     *
     * @param  FilterCustomerRequest $request
     * @return View
     */
    public function index(FilterCustomerRequest $request): View
    {
        $customers = Customer::when(!empty($request['keyword']), function($q) use($request) {
            $q->where('name', 'like', '%' . $request['keyword'] . '%');
            $q->orWhere('phone', 'like', '%' . $request['keyword'] . '%');
            $q->orWhere('address', 'like', '%' . $request['keyword'] . '%');
            $q->orWhere('cccd', 'like', '%' . $request['keyword'] . '%');
        })
        ->when(!is_null($request['is_bad']), function($q) use($request) {
            $q->where('is_bad', $request['is_bad']);
        })
        ->when(!is_null($request['is_zalo_spamed']), function($q) use($request) {
            $q->where('is_zalo_spamed', $request['is_zalo_spamed']);
        })
        ->when(!is_null($request['order_by']), function($q) use($request) {
            $orderBy = explode('|', $request['order_by']);
            $q->orderBy($orderBy[0], $orderBy[1]);
        })
        ->paginate($this->paginate);

        return view('customers', [
            'slide' => 'customers',
            'customers' => $customers,
            'filter' => $this->buildFilterArray($request)
        ]);
    }

    /**
     * delete
     *
     * @param  string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $result = Customer::find($id);

        if (!$result) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        $result->delete();

        return redirect()->back();
    }

    /**
     * Truncate all data customer
     * danger
     *
     * @return RedirectResponse
     */
    public function truncate(): RedirectResponse
    {
        $result = Customer::truncate();

        if (!$result) {
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect()->back();
    }

    /**
     * buildFilterObject
     *
     * @param  Request $request
     * @return array
     */
    public function buildFilterArray(Request $request): array
    {
        return [
            'keyword' => $request['keyword'] ?? '',
            'is_bad' => $request['is_bad'] ?? '',
            'is_zalo_spamed' => $request['is_zalo_spamed'] ?? '',
            'order_by' => $request['order_by'] ?? ''
        ];
    }

    /**
     * update customer status
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->update($request->all());

            return $this->messageSuccess('Cập nhật thành công !');
        }

        return $this->responseFail('Cập nhật status lỗi !');
    }

    /**
     * Update customer info
     *
     * @param  UpdateCustomerInfoRequest $request
     * @param  string $id
     * @return JsonResponse
     */
    public function update(UpdateCustomerInfoRequest $request, string $id): JsonResponse
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->update($request->all());

            return $this->messageSuccess('Update thành công !');
        }

        return $this->responseFail('Update có lỗi xảy ra !');
    }

    /**
     * Show customer info
     *
     * @param  string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $customer = Customer::find($id);

        if ($customer) {
            return $this->responseSuccess($customer);
        }

        return $this->responseFail('Lỗi get thông tin customer !');
    }

    public function testSms()
    {
        return $this->smsService->sendSMS();
    }
}

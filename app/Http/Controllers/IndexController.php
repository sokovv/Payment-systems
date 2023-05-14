<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\User;
use App\Services\TransferService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


/**
 * Summary of IndexController
 */
class IndexController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private $userService;

    public function __construct( UserService $userServices)
    {
        $this->userService = $userServices;
    }
    public function index()
    {
        $this->userService->userCreate();
        $users = User::class::get();
        $user = Auth::user();

        return view('index.index', ['users' => $users, 'user' => $user]);
    }

    /**
     * Summary of transfer
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request)
    {
        $user = Auth::user();
        $id = User::pluck('id');

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'min:1', Rule::notIn([$user->id]), Rule::in($id)],
            'sum' => ['required', 'numeric', 'min:1', "max:{$user->balance}"],
            'date' => ['required', 'after:' . date('Y-m-d')],
        ], [
            'required' => 'Поле надо бы заполнить',
            'max' => 'У вас недостаточно денежных средств',
            'in' => 'Пользователя с таким id не существует',
            'not_in' => 'Зачем себе переводить?',
            'after' => 'В прошлое нельзя переводить',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $id_client = $request->input('id');
        $sum_client = $request->input('sum');
        $date_transfer = $request->input('date');

        $client = User::class::find($id_client);
        $name_client = $client->name;

        $transferService = new TransferService();
        $data = $transferService->transferCreate($sum_client, $name_client, $date_transfer, $id_client);
        Transfer::class::create($data);

        return back();
    }
}

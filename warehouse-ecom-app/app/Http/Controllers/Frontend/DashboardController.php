<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function Logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function DashboardRoute(){
        $fetch_user_details = DB::table('app_user_roles')
        ->where('email', '=', Auth::user()->email)
        ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
            $status = $user_details->status;
        }
       if($user_status === 'Moderator'){
            if ($status === 'Active') {
                $fetch_product= DB::table('warehous_product_details')
                ->where('status', '=' ,'Active')
                ->where('stock_status', '=', 'In stock')
                ->get();
                return view('pages.backend.dashboards.moderator', compact('user_status', 'fetch_product'));
            } else {
                return view('errors.403');
            }
        }elseif ($user_status === 'Admin') {
            $product_query_stock = request()->query('product_query_stock');
            $product_query_preorder = request()->query('product_query_preorder');
            if (!empty($product_query_stock)) {
                $sock_order_list = DB::table('stock_product_order_models')
                ->join('clients', 'stock_product_order_models.client_id', 'clients.client_id')
                    ->orWhere('stock_product_order_models.order_id', 'LIKE', "%$product_query_stock%")
                    ->orWhere('stock_product_order_models.product_name', 'LIKE', "%$product_query_stock%")
                    ->select(
                        'clients.client_name',
                        'clients.contact',
                        'clients.email',
                        'clients.address',
                        'clients.client_name',
                        'stock_product_order_models.order_id',
                        'stock_product_order_models.product_name',
                        'stock_product_order_models.quantity',
                        'stock_product_order_models.payment',
                        'stock_product_order_models.status',
                        'stock_product_order_models.created_at',
                     )
                    ->orderBy('stock_product_order_models.order_id', 'DESC')
                    ->paginate('10');
            }else{
                $sock_order_list = DB::table('stock_product_order_models')
                ->join('clients', 'stock_product_order_models.client_id', 'clients.client_id')
                ->select(
                    'clients.client_name',
                    'clients.contact',
                    'clients.email',
                    'clients.address',
                    'clients.client_name',
                    'stock_product_order_models.order_id',
                    'stock_product_order_models.product_name',
                    'stock_product_order_models.quantity',
                    'stock_product_order_models.payment',
                    'stock_product_order_models.status',
                    'stock_product_order_models.created_at',
                )
                    ->orderBy('stock_product_order_models.order_id', 'DESC')
                    ->paginate('10');
            }
            if(!empty($product_query)){
                $pre_order_list = DB::table('pre_order_product_order_models')
                ->join('clients', 'pre_order_product_order_models.client_id', 'clients.client_id')
                ->orWhere('pre_order_product_order_models.order_id', 'LIKE', "%$product_query_stock%")
                ->orWhere('pre_order_product_order_models.details', 'LIKE', "%$product_query_stock%")
                ->select(
                    'clients.client_name',
                    'clients.contact',
                    'clients.email',
                    'clients.address',
                    'clients.client_name',
                    'pre_order_product_order_models.order_id',
                    'pre_order_product_order_models.details',
                    'pre_order_product_order_models.payment',
                    'pre_order_product_order_models.status',
                    'pre_order_product_order_models.created_at',
                )
                    ->orderBy('stock_product_order_models.order_id', 'DESC')
                    ->paginate('10');
            }else{
                $pre_order_list = DB::table('pre_order_product_order_models')
                    ->join('clients', 'pre_order_product_order_models.client_id', 'clients.client_id')
                    ->select(
                        'clients.client_name',
                        'clients.contact',
                        'clients.email',
                        'clients.address',
                        'clients.client_name',
                        'pre_order_product_order_models.order_id',
                        'pre_order_product_order_models.details',
                        'pre_order_product_order_models.payment',
                        'pre_order_product_order_models.status',
                        'pre_order_product_order_models.created_at',
                    )
                    ->orderBy('pre_order_product_order_models.order_id', 'DESC')
                    ->paginate('10');
            }
            return view('pages.backend.dashboards.admin', compact('user_status', 'sock_order_list', 'pre_order_list'));
        }
    }
}

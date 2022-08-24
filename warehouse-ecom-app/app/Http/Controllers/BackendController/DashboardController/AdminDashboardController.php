<?php

namespace App\Http\Controllers\BackendController\DashboardController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\AppUserRole;
use App\Models\AreaModel;
use App\Models\User;
use App\Models\WarehouseModel;
use App\Models\Caregory;
use App\Models\TotalSKUSerial;
use App\Models\WarehousProductDetails;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewModeratorPanelWithRegistration(){
        $name_query = request()->query('name_query');
        $fetch_user_details = DB::table('app_user_roles')
            ->where('email', '=', Auth::user()->email)
            ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
        }
        if (!empty($name_query)) {
            $fetch_moderator = DB::table('app_user_roles')
                ->where('email','LIKE', "%$name_query%")
                ->where('role', '!=', 'Admin')
                ->orderBy('id', 'DESC')
                ->paginate('10');
        }else{
            $fetch_moderator = DB::table('app_user_roles')
                ->where('role', '!=', 'Admin')
                ->orderBy('id', 'DESC')
                ->paginate('10');
        }
        $fetch_product = DB::table('warehous_product_details')
        ->join('warehouse_models', 'warehous_product_details.warehouse_id', 'warehouse_models.warehouse_id')
        ->where('warehouse_models.status', '=', 'Active')
        ->where('warehous_product_details.status', '=', 'Active')
        ->select('warehous_product_details.sku_id', 'warehous_product_details.name', 'warehous_product_details.img', 'warehous_product_details.category', 'warehous_product_details.selling_price', 'warehous_product_details.stock_status')
        ->orderBy('sku_id', 'DESC')
        ->paginate('10');
        return view('pages.backend.dashboards.helping-pages.admin-pages.moderator-panel', compact('user_status', 'fetch_moderator', 'fetch_product'));
    }

    public function StoreModerator(Request $request){
        $validateInputData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255',
        ]);
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $role = 'Moderator';
        $hashed_password = Hash::make($password);
        User::insert([
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'created_at' => Carbon::now()
        ]);
        AppUserRole::insert([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Moderator successfully registered');
    }

    public function ModeratorStatusUpdate(Request $request){
        $assigned_email = $request->email;
        $current_status = $request->current_status;
        if($current_status == 'Active'){
            $new_status = 'Inactive';
        }else{
            $new_status = 'Active';
        }
        $update_user_status = [
            'status' => $new_status,
            'updated_at' => Carbon::now()
        ];
        DB::table('app_user_roles')
        ->where('email', '=', $assigned_email)
        ->update($update_user_status);
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function ViewWarehouseAreaPanel(){
        $name_query = request()->query('name_query');
        $fetch_user_details = DB::table('app_user_roles')
            ->where('email', '=', Auth::user()->email)
            ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
        }
        $get_area = DB::table('area_models')
        ->get();
        if (!empty($name_query)) {
            $fetch_ware_house = DB::table('warehouse_models')
            ->where('name', 'LIKE', "%$name_query%")
            ->orderBy('warehouse_id', 'DESC')
            ->paginate('10');
        } else {
            $fetch_ware_house = DB::table('warehouse_models')
            ->orderBy('id', 'DESC')
            ->paginate('10');
        }
        return view('pages.backend.dashboards.helping-pages.admin-pages.warehouse-panel', compact('user_status', 'get_area', 'fetch_ware_house'));
    }

    public function StoreWareHouseArea(Request $request){
        $validateInputData = $request->validate([
            'area' => 'required|max:255|unique:area_models,area',
        ]);
        $input_area=$request->area;
        AreaModel::insert([
            'area' => $input_area,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Area created successfully');
    }

    public function StoreWareHouse(Request $request){
        $validateInputData = $request->validate([
            'warhouse_name' => 'required|max:255|unique:warehouse_models,name',
            'selected_area' => 'required|max:255',
        ]);
        $warhouse_name = $request->warhouse_name;
        $selected_area = $request->selected_area;
        $warehouse_id = IdGenerator::generate(['table' => 'warehouse_models', 'field' => 'warehouse_id', 'length' => 12, 'prefix' => 'WH-']);
        WarehouseModel::insert([
            'warehouse_id' => $warehouse_id,
            'name' => $warhouse_name,
            'area' => $selected_area,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Warehouse created successfully');
    }

    public function WarehouseStatusUpdate(Request $request){
        $warehouse_id = $request->warehouse_id;
        $current_status = $request->current_status;
        if ($current_status == 'Active') {
            $new_status = 'Inactive';
        } else {
            $new_status = 'Active';
        }
        $update_user_status = [
            'status' => $new_status,
            'updated_at' => Carbon::now()
        ];
        DB::table('warehouse_models')
        ->where('warehouse_id', '=', $warehouse_id)
        ->update($update_user_status);
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function CategoryStatusUpdate(Request $request){
        $name = $request->name;
        $current_status = $request->current_status;
        if ($current_status == 'Active') {
            $new_status = 'Inactive';
        } else {
            $new_status = 'Active';
        }
        $update_user_status = [
            'status' => $new_status,
            'updated_at' => Carbon::now()
        ];
        DB::table('caregories')
            ->where('name', '=', $name)
            ->update($update_user_status);
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function StoreCategory(Request $request){
        $validateInputData = $request->validate([
            'category_name' => 'required|max:255|unique:caregories,name',
        ]);
        $category_name = $request->category_name;
        Caregory::insert([
            'name' => $category_name,
            'status' => 'Active',
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Category registered successfully');
    }

    public function StoreProduct(Request $request)
    {
        $validateInputData = $request->validate([
            'product_name' => 'required|max:255',
            'category' => 'required|max:255',
            'warehouse' => 'required|max:255',
            'specification' => 'required',
            'buying_price' => 'required|numeric|min:1',
            'selling_price' => 'required|numeric|min:1',
            'total_stock' => 'required|numeric|min:1',
            'main_image' => 'mimes:jpg,jpeg,png',
            'product_type_variation_quantity.*' => 'numeric',
        ]);
        $sku_id = IdGenerator::generate(['table' => 'total_s_k_u_serials', 'field' => 'sku_id', 'length' => 10, 'prefix' => 'sku-']);
        $is_offer = "No";
        $status = "Active";
        $product_name = $request->product_name;
        $category = $request->category;
        $warehouse_id = $request->warehouse;
        $specification = $request->specification;
        $buying_price = $request->buying_price;
        $selling_price = $request->selling_price;
        $total_stock = $request->total_stock;
        $main_image = $request->main_image;
        $product_type_variation = $request->product_type_variation;
        $product_type_variation_quantity = $request->product_type_variation_quantity;
        if (!empty($main_image)) {
            $file_name_gen = hexdec(uniqid()) . '-' . $sku_id . '.' . $main_image->getClientOriginalExtension();
            Image::make($main_image)->resize(600, 600)->save('public/product_assets/img/' . $file_name_gen);
            $final_image = '/public/product_assets/img/' . $file_name_gen;
            WarehousProductDetails::insert([
                'sku_id' => $sku_id,
                'name' => $product_name,
                'img' => $final_image,
                'category' => $category,
                'warehouse_id' => $warehouse_id,
                'specification' => $specification,
                'buying_price' => $buying_price,
                'selling_price' => $selling_price,
                'quantiry' => $total_stock,
                'is_offer' => $is_offer,
                'status' => $status,
                'author' => Auth::user()->name,
                'created_at' => Carbon::now()
            ]);
        }else{
            WarehousProductDetails::insert([
                'sku_id' => $sku_id,
                'name' => $product_name,
                'category' => $category,
                'warehouse_id' => $warehouse_id,
                'specification' => $specification,
                'buying_price' => $buying_price,
                'selling_price' => $selling_price,
                'quantiry' => $total_stock,
                'is_offer' => $is_offer,
                'status' => $status,
                'author' => Auth::user()->name,
                'created_at' => Carbon::now()
            ]);
        }
        if(!empty($product_type_variation)){
            for ($count = 0; $count < count($product_type_variation); $count++) {
                $data = array(
                    'sku_id' => $sku_id,
                    'variation_name' => $product_type_variation[$count],
                    'variation_type' => $product_type_variation_quantity[$count],
                    'created_at' => Carbon::now()
                );
                $insert_data[] = $data;
            }
            DB::table('warehouse_product_variations')
            ->insert($insert_data);
        }
        TotalSKUSerial::insert([
            'sku_id' => $sku_id,
            'is_offer' => $is_offer,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function ProductStatusUpdate(Request $request){
        $sku = $request->sku;
        $current_status = $request->current_status;
        if ($current_status == 'Active') {
            $new_status = 'Inactive';
        } else {
            $new_status = 'Active';
        }
        $update_user_status = [
            'status' => $new_status,
            'updated_at' => Carbon::now()
        ];
        DB::table('warehous_product_details')
        ->where('sku_id', '=', $sku)
        ->update($update_user_status);
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function CategoryStockPanel(){
        $fetch_user_details = DB::table('app_user_roles')
            ->where('email', '=', Auth::user()->email)
            ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
            $status = $user_details->status;
        }
        $name_query = request()->query('name_query');
        $product_query = request()->query('product_query');
        if (!empty($name_query)) {
            $category_list = DB::table('caregories')
            ->where('name', 'LIKE', "%$name_query%")
            ->orderBy('id', 'DESC')
                ->paginate('10');
        } else {
            $category_list = DB::table('caregories')
            ->orderBy('id', 'DESC')
                ->paginate('10');
        }
        $fetch_ware_house = DB::table('warehouse_models')
        ->where('status', '=', 'Active')
            ->orderBy('warehouse_id', 'DESC')
            ->get();
        $category_list_select = DB::table('caregories')
        ->where('status', '=', 'Active')
            ->orderBy('id', 'ASC')
            ->get();
        if (!empty($product_query)) {
            $fetch_product = DB::table('warehous_product_details')
            ->join('warehouse_models', 'warehous_product_details.warehouse_id', 'warehouse_models.warehouse_id')
            ->where('warehouse_models.status', '=', 'Active')
                ->where('warehous_product_details.name', 'LIKE', "%$product_query%")
                ->select(
                    'warehous_product_details.sku_id',
                    'warehouse_models.name as warehouse_name',
                    'warehous_product_details.name',
                    'warehous_product_details.img',
                    'warehous_product_details.category',
                    'warehous_product_details.specification',
                    'warehous_product_details.buying_price',
                    'warehous_product_details.selling_price',
                    'warehous_product_details.quantiry',
                    'warehous_product_details.stock_status',
                    'warehous_product_details.is_offer',
                    'warehous_product_details.status',
                    'warehous_product_details.author',
                    'warehous_product_details.created_at'
                )
                ->orderBy('sku_id', 'DESC')
                ->paginate('10');
        } else {
            $fetch_product = DB::table('warehous_product_details')
            ->join('warehouse_models', 'warehous_product_details.warehouse_id', 'warehouse_models.warehouse_id')
            ->where('warehouse_models.status', '=', 'Active')
                ->select(
                    'warehous_product_details.sku_id',
                    'warehouse_models.name as warehouse_name',
                    'warehous_product_details.name',
                    'warehous_product_details.img',
                    'warehous_product_details.category',
                    'warehous_product_details.specification',
                    'warehous_product_details.buying_price',
                    'warehous_product_details.selling_price',
                    'warehous_product_details.quantiry',
                    'warehous_product_details.stock_status',
                    'warehous_product_details.is_offer',
                    'warehous_product_details.status',
                    'warehous_product_details.author',
                    'warehous_product_details.created_at'
                )
                ->orderBy('sku_id', 'DESC')
                ->paginate('10');
        }
        return view('pages.backend.dashboards.helping-pages.admin-pages.category-stock', compact('user_status', 'category_list', 'category_list_select', 'fetch_ware_house', 'fetch_product'));
    }

    public function ViewmoderatorEditPage(Request $request){
        $email = $request->email;
        $fetch_user_details = DB::table('app_user_roles')
        ->where('email', '=', Auth::user()->email)
        ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
            $status = $user_details->status;
        }
        $fetch_user = DB::table('users')
        ->where('email', '=', $email)
        ->get();
        $fetch_role=DB::table('app_user_roles')
        ->where('email', '=', $email)
        ->get();
        return view('pages.backend.dashboards.helping-pages.admin-pages.edit-moderator', compact('fetch_user', 'fetch_role', 'user_status'));
    }

    public function GetDeleteModerator(Request $request){
        $email = $request->email;
        DB::table('users')
        ->where('email','=',$email)
        ->delete();
        DB::table('app_user_roles')
        ->where('email', '=', $email)
        ->delete();
        return redirect()->back()->with('success', 'Moderator deleted successfully');
    }

    public function GetWarehouseDelete(Request $request){
        $warehouse_id = $request->warehouse_id;
        DB::table('warehouse_models')
        ->where('warehouse_id', '=', $warehouse_id)
        ->delete();
         DB::table('warehouse_models')
         ->where('warehouse_id', '=', $warehouse_id)
         ->update([
            'warehouse_id' => 'Removed warehouse',
            'status' => 'Inactive',
            'updated_at' => Carbon::now()
         ]);
        return redirect()->back()->with('success', 'Warehouse deleted successfully');
    }

    public function Updatederator(Request $request){
        $validateInputData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $name = $request->name;
        $role = $request->role;
        $email = $request->email;
        DB::table('app_user_roles')
        ->where('email','=', $email)
        ->update([
            'name' => $name,
            'role' => $role,
            'updated_at' => Carbon::now()
        ]);
        DB::table('users')
        ->where('email', '=', $email)
        ->update([
            'name' => $name,
            'updated_at' => Carbon::now()
        ]);
        return redirect()->route('moderator.panel')->with('success', 'Moderator updated successfully');
    }
    public function ProductEditView(Request $request){
        $sku = $request->sku;
        $fetch_user_details = DB::table('app_user_roles')
        ->where('email', '=', Auth::user()->email)
        ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
            $status = $user_details->status;
        }
        $fetch_product_details = DB::table('warehous_product_details')
        ->where('sku_id', '=', $sku)
            ->get();
        return view('pages.backend.dashboards.helping-pages.admin-pages.edit-product', compact('fetch_product_details', 'user_status'));
    }

    public function ProductUpdate(Request $request){
        $validateInputData = $request->validate([
            'name' => 'required|max:255',
            'add_stock' => 'required|numeric|max:255',
        ]);
        $name= $request->name;
        $add_stock = $request->add_stock;
        $sku_id = $request->sku_id;
        $fetch_current_stock = DB::table('warehous_product_details')
        ->where('sku_id','=', $sku_id)
        ->get();
        foreach($fetch_current_stock as $stock){
            $current_stock = $stock->quantiry;
        }
        $new_stock = $current_stock+ $add_stock;
        $update_data =[
            'name' => $name,
            'quantiry' => $new_stock,
            'stock_status' => 'In stock',
            'updated_at' => Carbon::now()
        ];
        DB::table('warehous_product_details')
        ->where('sku_id', '=', $sku_id)
        ->update($update_data);
        return redirect()->route('category.stockPanel')->with('success', 'Product Updated successfully');
    }

    public function StockOrderUpdateComplete(Request $request){
        $order_id = $request->order_id;
        $current_status = $request->current_status;
        if ($current_status == 'Active') {
            $new_status = 'Complete';
        } else {
            $new_status = 'Complete';
        }
        $update_user_status = [
            'status' => $new_status,
            'updated_at' => Carbon::now()
        ];
        DB::table('stock_product_order_models')
            ->where('order_id', '=', $order_id)
            ->update($update_user_status);

        $fetch_status = DB::table('stock_product_order_models')
        ->join('clients', 'stock_product_order_models.client_id', 'clients.client_id')
        ->where('stock_product_order_models.order_id', '=', $order_id)
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
        ->get();
        foreach($fetch_status as $status){
            $client_name = $status->client_name;
            $email = $status->email;
            $order_id = $status->client_name;
            $product_specification_order = $status->product_name;
            $payment = $status->payment;
            $status = $status->status;
        }
        $data = [
            'client_name' => $client_name,
            'order_id' => $order_id,
            'details' => $product_specification_order,
            'payment' => $payment,
            'order_type' => 'Stock order',
            'status' => $status
        ];
        $user['to'] = $email;
        Mail::send('email.order-complete-mail', $data, function ($messages) use ($user) {
            $messages->to($user['to']);
            $messages->subject('Ecom warehouse Order Complete Confirmation');
        });
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function PreOrderUpdateComplete(Request $request){
        $order_id = $request->order_id;
        $current_status = $request->current_status;
        if ($current_status == 'Active') {
            $new_status = 'Complete';
        } else {
            $new_status = 'Complete';
        }
        $update_user_status = [
            'status' => $new_status,
            'updated_at' => Carbon::now()
        ];
        DB::table('pre_order_product_order_models')
        ->where('order_id', '=', $order_id)
            ->update($update_user_status);

        $fetch_status = DB::table('pre_order_product_order_models')
        ->join('clients', 'pre_order_product_order_models.client_id', 'clients.client_id')
        ->where('pre_order_product_order_models.order_id', '=', $order_id)
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
            ->get();
        foreach ($fetch_status as $status) {
            $client_name = $status->client_name;
            $email = $status->email;
            $order_id = $status->client_name;
            $product_specification_order = $status->details;
            $payment = $status->payment;
            $status = $status->status;
        }
        $data = [
            'client_name' => $client_name,
            'order_id' => $order_id,
            'details' => $product_specification_order,
            'payment' => $payment,
            'order_type' => 'Pre order',
            'status' => $status
        ];
        $user['to'] = $email;
        Mail::send('email.order-complete-mail', $data, function ($messages) use ($user) {
            $messages->to($user['to']);
            $messages->subject('Ecom warehouse Order Complete Confirmation');
        });
        return redirect()->back()->with('success', 'Status updated successfully');
    }
}

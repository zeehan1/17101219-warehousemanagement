<?php

namespace App\Http\Controllers\BackendController\DashboardController;

use App\Http\Controllers\Controller;
use App\Models\Caregory;
use App\Models\Client;
use App\Models\PreOrderProductOrderModel;
use App\Models\StockProductOrderModel;
use App\Models\TotalSKUSerial;
use App\Models\WarehousProductDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CategoryProductPanelView(){
        $fetch_user_details = DB::table('app_user_roles')
        ->where('email', '=', Auth::user()->email)
            ->get();
        $fetch_ware_house = DB::table('warehouse_models')
        ->where('status', '=', 'Active')
        ->orderBy('warehouse_id', 'DESC')
            ->get();
        $category_list = DB::table('caregories')
        ->where('status', '=' ,'Active')
        ->orderBy('id', 'ASC')
        ->get();
        foreach ($fetch_user_details as $user_details) {
            $user_status = $user_details->role;
        }
        return view('pages.backend.dashboards.helping-pages.moderator-pages.category-panel', compact('user_status' , 'fetch_ware_house', 'category_list'));
    }

    public function StoreCategory(Request $request){
        $validateInputData = $request->validate([
            'category_name' => 'required|max:255|unique:caregories,name',
        ]);
        $category_name = $request->category_name;
        Caregory::insert([
             'name' => $category_name,
             'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Category added successfully. Waiting for Admin Approval');
    }

    public function StoreProduct(Request $request){
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
            $file_name_gen = hexdec(uniqid()) . '-' .$sku_id . '.' .$main_image->getClientOriginalExtension();
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
                'author' => Auth::user()->name,
                'created_at' => Carbon::now()
            ]);
        }
        if (!empty($product_type_variation)) {
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
            'sku_id'=> $sku_id,
            'is_offer' => $is_offer,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Product added successfully. Waiting for Admin Approval');
    }

    public function RegisterStockOrder(Request $request){
        $validateInputData = $request->validate([
            'client_name' => 'required|max:255',
            'email' => 'required|max:255',
            'selected_product' => 'required|max:255',
            'product_quantity' => 'required|numeric',
            'payment' =>'required'
        ]);

        $client_name = $request->client_name;
        $email = $request->email;
        $contact = $request->contact;
        $address = $request->address;
        $product_sku=$request->selected_product;
        $product_quantity = $request->product_quantity;
        $findProduct= DB::table('warehous_product_details')
        ->where('sku_id','=', $product_sku)
        ->get();
        foreach($findProduct as $product){
            $selected_product = $product->name;
            $total_stock = $product->quantiry;
        }
        $final_stock = $total_stock - $product_quantity;
        if($final_stock <=0){
            $stock_status = 'Out of stock';
        }else{
            $stock_status = 'In stock';
        }
        $payment = $request->payment;
        $order_id = IdGenerator::generate(['table' => 'stock_product_order_models', 'field' => 'order_id', 'length' => 10, 'prefix' => 'order-']);
        $client_id = IdGenerator::generate(['table' => 'clients', 'field' => 'client_id', 'length' => 10, 'prefix' => 'client-']);
        Client::insert([
            'client_id' => $client_id,
            'client_name' => $client_name,
            'contact' => $contact,
            'email' => $email,
            'address' => $address,
            'created_at' => Carbon::now()
        ]);
        StockProductOrderModel::insert([
            'order_id' => $order_id,
            'client_id' => $client_id,
            'product_name' => $selected_product,
            'quantity' => $product_quantity,
            'payment' => $payment,
            'created_at' => Carbon::now()
        ]);
        DB::table('warehous_product_details')
        ->where('sku_id', '=', $product_sku)
        ->update([
            'quantiry' => $final_stock,
            'stock_status' => $stock_status,
            'updated_at' => Carbon::now()
        ]);
        $data = [
            'client_name' => $client_name,
            'order_id' => $order_id,
            'details' => $selected_product,
            'payment' => $payment,
            'order_type' => 'Stock order'
        ];
        $user['to'] = $email;
        Mail::send('email.order-mail', $data, function ($messages) use ($user) {
            $messages->to($user['to']);
            $messages->subject('Request for vehicle approval');
        });
        return redirect()->back()->with('success', 'Product ordered successfully. Waiting for Admin Approval');
    }

    public function RegisterPreOrder(Request $request){
        $validateInputData = $request->validate([
            'client_name_order' => 'required|max:255',
            'email_order' => 'required|max:255',
            'product_specification_order' => 'required|max:255',
            'payment_order' => 'required'
        ]);
        $client_name = $request->client_name_order;
        $email = $request->email_order;
        $contact = $request->contact_order;
        $address = $request->address_order;
        $product_specification_order = $request->product_specification_order;
        $payment = $request->payment_order;
        $order_id = IdGenerator::generate(['table' => 'stock_product_order_models', 'field' => 'order_id', 'length' => 10, 'prefix' => 'order-']);
        $client_id = IdGenerator::generate(['table' => 'clients', 'field' => 'client_id', 'length' => 10, 'prefix' => 'client-']);
        Client::insert([
            'client_id' => $client_id,
            'client_name' => $client_name,
            'contact' => $contact,
            'email' => $email,
            'address' => $address,
            'created_at' => Carbon::now()
        ]);
        PreOrderProductOrderModel::insert([
            'order_id' => $order_id,
            'client_id' => $client_id,
            'details' =>  $product_specification_order,
            'payment' => $payment,
            'created_at' => Carbon::now()
        ]);
        $data = [
            'client_name' => $client_name,
            'order_id' => $order_id,
            'details' => $product_specification_order,
            'payment' => $payment,
            'order_type' => 'Stock order'
        ];
        $user['to'] = $email;
        Mail::send('email.order-mail', $data, function ($messages) use ($user) {
            $messages->to($user['to']);
            $messages->subject('Ecom warehouse Order placement Confirmation');
        });
        return redirect()->back()->with('success', 'Product ordered successfully. Waiting for Admin Approval');
    }
}

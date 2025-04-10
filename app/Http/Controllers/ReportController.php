<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Datatables, Charts;

use  App\Utils\TransactionUtil,
    App\Utils\ProductUtil;

use App\Contact, App\Product, App\Category,
    App\Unit, App\Brands, App\BusinessLocation, App\ExpenseCategory, App\CashRegister, App\User, App\PurchaseLine, App\Transaction, App\CustomerGroup, App\TransactionSellLine;

class ReportController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $transactionUtil;
    protected $productUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
    }

    /**
     * Shows profit\loss of a business
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfitLoss(Request $request)
    {
        if (!auth()->user()->can('profit_loss_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) { 

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $location_id = $request->get('location_id');

            //For Opening stock date should be 1 day before
            $day_before_start_date = \Carbon::createFromFormat('Y-m-d', $start_date)->subDay()->format('Y-m-d');
            //Get Opening stock
            $opening_stock = $this->transactionUtil->getOpeningClosingStock($business_id, $day_before_start_date, $location_id, true);

            //Get Closing stock
            $closing_stock = $this->transactionUtil->getOpeningClosingStock($business_id, 
                $end_date, $location_id);

            //Get Purchase details
            $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, 
                $start_date, $end_date, $location_id);

            //Get Sell details
            $sell_details = $this->transactionUtil->getSellTotals($business_id, $start_date, 
                $end_date, $location_id);

            //Get total expense
            $total_expense = $this->transactionUtil->getTotalExpense($business_id, $start_date, 
                $end_date, $location_id);

            //Get total stock adjusted
            $total_stock_adjustment = $this->transactionUtil->getTotalStockAdjustment($business_id, $start_date, 
                $end_date, $location_id);

            $total_transfer_shipping_charges = $this->transactionUtil->getTotalTransferShippingCharges($business_id, $start_date, 
                $end_date, $location_id);

            //Discounts
            $total_purchase_discount = $this->transactionUtil->getTotalDiscounts($business_id,'purchase', $start_date, $end_date, $location_id);
            $total_sell_discount = $this->transactionUtil->getTotalDiscounts($business_id, 'sell', $start_date, $end_date, $location_id);

            $data['opening_stock'] = !empty($opening_stock) ? $opening_stock : 0;
            $data['closing_stock'] = !empty($closing_stock) ? $closing_stock : 0;
            $data['total_purchase'] = !empty($purchase_details['total_purchase_exc_tax']) ? $purchase_details['total_purchase_exc_tax'] : 0;
            $data['total_sell'] = !empty($sell_details['total_sell_exc_tax']) ? $sell_details['total_sell_exc_tax'] : 0;
            $data['total_expense'] = !empty($total_expense) ? $total_expense : 0;

            $data['total_adjustment'] = !empty($total_stock_adjustment->total_adjustment) ? $total_stock_adjustment->total_adjustment : 0;

            $data['total_recovered'] = !empty($total_stock_adjustment->total_recovered) ? $total_stock_adjustment->total_recovered : 0;

            $data['total_transfer_shipping_charges'] = !empty($total_transfer_shipping_charges) ? $total_transfer_shipping_charges : 0;

            $data['total_purchase_discount'] = !empty($total_purchase_discount) ? $total_purchase_discount : 0;
            $data['total_sell_discount'] = !empty($total_sell_discount) ? $total_sell_discount : 0;

            $data['net_profit'] = $data['total_sell'] + $data['closing_stock'] - 
                                $data['total_purchase'] - $data['total_sell_discount']- 
                                $data['opening_stock'] - $data['total_expense'] - 
                                $data['total_adjustment'] + $data['total_recovered'] - 
                                $data['total_transfer_shipping_charges'] + $data['total_purchase_discount'];
            return $data;
        }

        $business_locations = BusinessLocation::forDropdown($business_id, true);
        return view ('report.profit_loss', compact('business_locations'));
    }

    /**
     * Shows product report of a business
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseSell(Request $request)
    {
        if (!auth()->user()->can('purchase_n_sell_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $location_id = $request->get('location_id');

            $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start_date, $end_date, $location_id);

            $sell_details = $this->transactionUtil->getSellTotals($business_id, $start_date, $end_date, 
                                                                    $location_id);

            $difference = [
                'total' => $sell_details['total_sell_inc_tax'] - $purchase_details['total_purchase_inc_tax'],
                'due' => $sell_details['invoice_due'] - $purchase_details['purchase_due']
            ];

            return ['purchase' => $purchase_details, 
                    'sell' => $sell_details, 
                    'difference' => $difference
                ];
        }

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.purchase_sell')
                    ->with(compact('business_locations'));
    }

    /**
     * Shows report for Supplier
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomerSuppliers(Request $request)
    {
        if (!auth()->user()->can('contacts_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {
            $contacts = Contact::where('contacts.business_id', $business_id)
                        ->join('transactions AS t', 'contacts.id', '=', 't.contact_id')
                        ->groupBy('contacts.id')
                        ->select( 
                            DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),

                            DB::raw("SUM(IF(t.type = 'sell', final_total, 0)) as total_invoice"),

                            DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),

                            DB::raw("SUM(IF(t.type = 'sell', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),

                            'contacts.supplier_business_name',
                            'contacts.name',
                            'contacts.id'
                        );
            $permitted_locations = auth()->user()->permitted_locations();
            if($permitted_locations != 'all'){
                $contacts->whereIn('t.location_id', $permitted_locations);
            }
            return Datatables::of($contacts)
                ->editColumn('name', function($row){
                    return '<a href="' . action('ContactController@show', [$row->id]) . '" target="_blank">' . 
                            $row->name . ' ' . $row->supplier_business_name . 
                        '</a>';
                })
                ->editColumn('total_purchase', function($row){
                    return '<span class="display_currency" data-currency_symbol = true>' . $row->total_purchase . '</span>';
                })
                ->editColumn('total_invoice', function($row){
                    return '<span class="display_currency" data-currency_symbol = true>' . $row->total_invoice . '</span>';
                })
                ->addColumn('due', 
                    '<span class="display_currency" data-currency_symbol=true data-highlight=true>{{($total_invoice - $invoice_received) - ($total_purchase - $purchase_paid)}}</span>'
                )
                ->removeColumn('supplier_business_name')
                ->removeColumn('invoice_received')
                ->removeColumn('purchase_paid')
                ->removeColumn('id')
                ->rawColumns(['total_purchase', 'total_invoice', 'due', 'name'])
                ->make(true);
        }

        return view ('report.contact');
    }

    /**
     * Shows product stock report
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockReport(Request $request)
    {
        if (!auth()->user()->can('stock_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

         //Return the details in ajax call
        if ($request->ajax()) {
            $query = Product::where('products.business_id', $business_id)
                        ->leftjoin('units', 'products.unit_id', '=', 'units.id')
                        
                        ->leftjoin('variation_location_details as vld', 'products.id', '=', 'vld.product_id');

            $permitted_locations = auth()->user()->permitted_locations();
            $location_filter = '';

            if($permitted_locations != 'all'){
                $query->whereIn('vld.location_id', $permitted_locations);

                $locations_imploded = implode(', ', $permitted_locations);
                $location_filter .= "AND transactions.location_id IN ($locations_imploded) ";
            }

            if(!empty($request->input('location_id'))){

                $location_id = $request->input('location_id');

                $query->where('vld.location_id', $location_id);

                $location_filter .= "AND transactions.location_id=$location_id";
            }

            if(!empty($request->input('category_id'))){
                $query->where('products.category_id', $request->input('category_id'));
            }
            if(!empty($request->input('sub_category_id'))){
                $query->where('products.sub_category_id', $request->input('sub_category_id'));
            }
            if(!empty($request->input('brand_id'))){
                $query->where('products.brand_id', $request->input('brand_id'));
            }
            if(!empty($request->input('unit_id'))){
                $query->where('products.unit_id', $request->input('unit_id'));
            }

            $products = $query->select(
                            DB::raw("(SELECT SUM(quantity) FROM transaction_sell_lines LEFT JOIN transactions ON transaction_sell_lines.transaction_id=transactions.id WHERE transactions.status='final' $location_filter AND  
                                transaction_sell_lines.product_id=products.id) as total_sold"),
                            DB::raw("SUM(vld.qty_available) as stock"),
                            'sku',
                            'products.name as product',
                            'products.type',
                            'units.short_name as unit',
                            'products.enable_stock as enable_stock',
                            'products.id as DT_RowId'
                        )->groupBy('products.id');

            return Datatables::of($products)
                ->editColumn('stock', function($row){
                    if($row->enable_stock){
                        $stock = $row->stock ? $row->stock : 0 ;
                        return $stock . ' ' . $row->unit;
                    } else {
                        return 'N/A';
                    }
                })
                ->editColumn('total_sold', function($row){
                    if($row->total_sold){
                        return $row->total_sold . ' ' . $row->unit;
                    } else {
                        return '0.00' . ' ' . $row->unit;
                    }
                })
                ->removeColumn('enable_stock')
                ->removeColumn('unit')
                ->removeColumn('id')
                ->make(true);
        }

        $categories = Category::where('business_id', $business_id)
                            ->where('parent_id', 0)
                            ->pluck('name', 'id');
        $brands = Brands::where('business_id', $business_id)
                            ->pluck('name', 'id');
        $units = Unit::where('business_id', $business_id)
                            ->pluck('short_name', 'id');
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.stock_report')
                ->with(compact('categories', 'brands', 'units', 'business_locations'));

    }
    /**
     * Shows product stock details
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockDetails(Request $request)
    {
         //Return the details in ajax call
        if ($request->ajax()) {
            $business_id = $request->session()->get('user.business_id');
            $product_id = $request->input('product_id');
            $query = Product::leftjoin('units as u', 'products.unit_id', '=', 'u.id')
                            ->join('variations as v', 'products.id', '=', 'v.product_id')
                            ->join('product_variations as pv', 'pv.id', '=', 'v.product_variation_id')
                            ->leftjoin('variation_location_details as vld', 'v.id', '=', 'vld.variation_id')
                            ->where( 'products.business_id', $business_id)
                            ->where('products.id', $product_id);

            $permitted_locations = auth()->user()->permitted_locations();
            $location_filter = '';
            if($permitted_locations != 'all'){
                $query->whereIn('vld.location_id', $permitted_locations);
                $locations_imploded = implode(', ', $permitted_locations);
                $location_filter .= "AND transactions.location_id IN ($locations_imploded) ";
            }

            if(!empty($request->input('location_id'))){

                $location_id = $request->input('location_id');

                $query->where('vld.location_id', $location_id);

                $location_filter .= "AND transactions.location_id=$location_id";
            }
                $product_details =  $query->select('products.name as product', 
                                    'u.short_name as unit',
                                    'pv.name as product_variation',
                                    'v.name as variation',
                                    'v.sub_sku as sub_sku',
                                    DB::raw("SUM(vld.qty_available) as stock"),
                                    DB::raw("(SELECT SUM(quantity) FROM transaction_sell_lines LEFT JOIN transactions ON transaction_sell_lines.transaction_id=transactions.id WHERE transactions.status='final' $location_filter AND  
                                        transaction_sell_lines.variation_id=v.id) as total_sold")
                                )
                            ->groupBy('v.id')
                            ->get();

            return view ('report.stock_details')
                        ->with(compact('product_details'));
        }
    }

    /**
     * Shows tax report of a business
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxReport(Request $request)
    {
        if (!auth()->user()->can('tax_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $location_id = $request->get('location_id');

            $input_tax_details = $this->transactionUtil->getInputTax($business_id, $start_date, $end_date, $location_id);

            $input_tax = view('report.partials.tax_details')->with(['tax_details' => $input_tax_details])->render();

            $output_tax_details = $this->transactionUtil->getOutputTax($business_id, $start_date, $end_date, 
                $location_id);

            $output_tax = view('report.partials.tax_details')->with( ['tax_details' => $output_tax_details])->render();

            return ['input_tax' => $input_tax, 
                    'output_tax' => $output_tax,
                    'tax_diff' => $output_tax_details['total_tax'] - $input_tax_details['total_tax']
                ];
        }

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.tax_report')
                    ->with(compact('business_locations'));
    }

    /**
     * Shows trending products
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrendingProducts(Request $request)
    {
        if (!auth()->user()->can('trending_product_report.view') ) {
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = $request->session()->get('user.business_id');
        $filters = $request->only(['category', 'sub_category', 'brand', 'unit', 'limit', 'location_id']);

        $date_range = $request->input('date_range');
        
        if(!empty($date_range)){
            $date_range_array = explode('~',$date_range);
            $filters['start_date'] = $this->transactionUtil->uf_date(trim($date_range_array[0]));
            $filters['end_date'] = $this->transactionUtil->uf_date(trim($date_range_array[1]));
        }

        $products = $this->productUtil->getTrendingProducts($business_id, $filters);

        $values = array();
        $labels = array();
        foreach ($products as $product) {
            $values[] = $product->total_unit_sold;
            $labels[] = $product->product . ' (' . $product->unit . ')';
        }
       $chart = Charts::create('bar', 'highcharts')
            ->title(" ")
            ->dimensions(0, 400) 
            ->template("material")
            ->values($values)
            ->labels($labels)
            ->elementLabel(__('report.total_unit_sold'));

        $categories = Category::where('business_id', $business_id)
                            ->where('parent_id', 0)
                            ->pluck('name', 'id');
        $brands = Brands::where('business_id', $business_id)
                            ->pluck('name', 'id');
        $units = Unit::where('business_id', $business_id)
                            ->pluck('short_name', 'id');
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.trending_products')
                    ->with(compact('chart', 'categories', 'brands', 'units', 'business_locations'));
    }

    /**
     * Shows expense report of a business
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpenseReport(Request $request)
    {
        if (!auth()->user()->can('expense_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');
        $filters = $request->only(['category', 'location_id']);

        $date_range = $request->input('date_range');
        
        if(!empty($date_range)){
            $date_range_array = explode('~',$date_range);
            $filters['start_date'] = $this->transactionUtil->uf_date(trim($date_range_array[0]));
            $filters['end_date'] = $this->transactionUtil->uf_date(trim($date_range_array[1]));
        } else {
            $filters['start_date'] = \Carbon::now()->startOfMonth()->format('Y-m-d');
            $filters['end_date'] = \Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $expenses = $this->transactionUtil->getExpenseReport($business_id, $filters);

        $values = array();
        $labels = array();
        foreach ($expenses as $expense) {
            $values[] = $expense->total_expense;
            $labels[] = !empty($expense->category) ? $expense->category : __('report.others');
        }

        $chart = Charts::create('bar', 'highcharts')
            ->title(__('report.expense_report'))
            ->dimensions(0, 400) 
            ->template("material")
            ->values($values)
            ->labels($labels)
            ->elementLabel(__('report.total_expense'));

        $categories = ExpenseCategory::where('business_id', $business_id)
                            ->pluck('name', 'id');
        
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.expense_report')
                    ->with(compact('chart', 'categories', 'business_locations'));
    }

    /**
     * Shows stock adjustment report
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockAdjustmentReport(Request $request){

        if (!auth()->user()->can('stock_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {
            $query =  Transaction::where('business_id', $business_id)
                            ->where('type', 'stock_adjustment');

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if($permitted_locations != 'all'){
                $query->whereIn('location_id', $permitted_locations);
            }

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            if( !empty($start_date) && !empty($end_date) ){
                $query->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
            }
            $location_id = $request->get('location_id');
            if( !empty($location_id)){
                $query->where('location_id', $location_id);
            }

            $stock_adjustment_details = $query->select(
                                DB::raw("SUM(final_total) as total_amount"),
                                DB::raw("SUM(total_amount_recovered) as total_recovered"),
                                DB::raw("SUM(IF(adjustment_type = 'normal', final_total, 0)) as total_normal"),
                                DB::raw("SUM(IF(adjustment_type = 'abnormal', final_total, 0)) as total_abnormal")
                            )->first();
            return $stock_adjustment_details;
        }
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.stock_adjustment_report')
                    ->with(compact('business_locations'));
    }

    /**
     * Shows register report of a business
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegisterReport(Request $request)
    {
        if (!auth()->user()->can('register_report.view') ) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {
            $registers = CashRegister::join('users as u', 
                                            'u.id', '=', 'cash_registers.user_id')
                        ->where('cash_registers.business_id', $business_id)
                        ->select(
                            'cash_registers.*',
                            DB::raw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, ''), '<br>', COALESCE(email, '')) as user_name"));

            if(!empty($request->input('user_id'))){
                $registers->where('cash_registers.user_id', $request->input('user_id'));
            }
            if(!empty($request->input('status'))){
                $registers->where('cash_registers.status', $request->input('status'));
            }
            return Datatables::of($registers)
                ->editColumn('total_card_slips', function($row){
                    if($row->status == 'close'){
                        return $row->total_card_slips;
                    } else {
                        return '';
                    }
                })
                ->editColumn('total_cheques', function($row){
                    if($row->status == 'close'){
                        return $row->total_cheques;
                    } else {
                        return '';
                    }
                })
                ->editColumn('closed_at', function($row){
                    if($row->status == 'close'){
                        return $this->productUtil->format_date($row->closed_at, true);
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function($row){
                     return $this->productUtil->format_date($row->created_at, true);
                })
                ->editColumn('closing_amount', function($row){
                    if($row->status == 'close'){
                        return '<span class="display_currency" data-currency_symbol="true">' . 
                        $row->closing_amount . '</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', '<button type="button" data-href="{{action(\'CashRegisterController@show\', [$id])}}" class="btn btn-xs btn-info btn-modal" 
                    data-container=".view_register"><i class="fa fa-external-link" aria-hidden="true"></i> @lang("messages.view")</button>')
                ->filterColumn('user_name', function($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, ''), '<br>', COALESCE(email, '')) like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['action', 'user_name', 'closing_amount'])
                ->make(true);
        }

        $users = User::forDropdown($business_id, false);

        return view ('report.register_report')
                    ->with(compact('users'));
    }

    /**
     * Shows sales representative report
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesRepresentativeReport(Request $request){

        if (!auth()->user()->can('sales_representative.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        $users = User::allUsersDropdown($business_id, false);
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.sales_representative')
                ->with(compact('users', 'business_locations'));
    }

    /**
     * Shows sales representative total expense
     *
     * @return json
     */
    public function getSalesRepresentativeTotalExpense(Request $request){

        if (!auth()->user()->can('sales_representative.view') ) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $business_id = $request->session()->get('user.business_id');

            $filters = $request->only(['expense_for', 'location_id', 'start_date', 'end_date']);

            $total_expense = $this->transactionUtil->getExpenseReport($business_id, $filters, 'total');

            return $total_expense;
        }
    }

    /**
     * Shows sales representative total sales
     *
     * @return json
     */
    public function getSalesRepresentativeTotalSell(Request $request)
    {
        if (!auth()->user()->can('sales_representative.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $location_id = $request->get('location_id');
            $created_by = $request->get('created_by');

            $sell_details = $this->transactionUtil->getSellTotals($business_id, $start_date, $end_date, $location_id, $created_by);

            return ['total_sell_exc_tax' => $sell_details['total_sell_exc_tax']];
        }
    }

    /**
     * Shows sales representative total commission
     *
     * @return json
     */
    public function getSalesRepresentativeTotalCommission(Request $request)
    {
        if (!auth()->user()->can('sales_representative.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $location_id = $request->get('location_id');
            $commission_agent = $request->get('commission_agent');

            $sell_details = $this->transactionUtil->getTotalSellCommission($business_id, $start_date, $end_date, $location_id, $commission_agent);

            //Get Commision
            $commission_percentage = User::find($commission_agent)->cmmsn_percent;
            $total_commission = $commission_percentage * $sell_details['total_sales_with_commission'] / 100;

            return ['total_sales_with_commission' => 
                        $sell_details['total_sales_with_commission'],
                    'total_commission' => $total_commission,
                    'commission_percentage' => $commission_percentage
                ];
        }
    }

    /**
     * Shows product stock expiry report
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockExpiryReport(Request $request)
    {
        if (!auth()->user()->can('stock_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {
            $query = PurchaseLine::leftjoin('transactions as t', 
                                'purchase_lines.transaction_id', '=', 't.id')
                            ->leftjoin('products as p', 'purchase_lines.product_id', '=', 
                                'p.id')
                            ->leftjoin('variations as v', 'purchase_lines.variation_id', '=', 
                                'v.id')
                            ->leftjoin('product_variations as pv', 'v.product_variation_id', 
                                '=', 'pv.id')
                            ->leftjoin('business_locations as l', 't.location_id', '=', 'l.id')
                            ->leftjoin('units as u', 'p.unit_id', '=', 'u.id')
                            ->where('t.business_id', $business_id)
                            //->whereNotNull('p.expiry_period')
                            //->whereNotNull('p.expiry_period_type')
                            ->whereNotNull('exp_date')
                            ->where('p.enable_stock', 1)
                            ->whereRaw('purchase_lines.quantity > purchase_lines.quantity_sold + quantity_adjusted');
                            
            $permitted_locations = auth()->user()->permitted_locations();

            if($permitted_locations != 'all'){
                $query->whereIn('t.location_id', $permitted_locations);
            }

            if(!empty($request->input('location_id'))){
                $location_id = $request->input('location_id');
                $query->where('t.location_id', $location_id);
            }

            if(!empty($request->input('category_id'))){
                $query->where('p.category_id', $request->input('category_id'));
            }
            if(!empty($request->input('sub_category_id'))){
                $query->where('p.sub_category_id', $request->input('sub_category_id'));
            }
            if(!empty($request->input('brand_id'))){
                $query->where('p.brand_id', $request->input('brand_id'));
            }
            if(!empty($request->input('unit_id'))){
                $query->where('p.unit_id', $request->input('unit_id'));
            }
            if(!empty($request->input('exp_date_filter'))){
                $query->whereDate('exp_date', '<=',$request->input('exp_date_filter'));
            }

            $report = $query->select('p.name as product',
                                    'p.sku',
                                    'p.type as product_type', 
                                    'v.name as variation',
                                    'pv.name as product_variation',
                                    'l.name as location',
                                    'mfg_date',
                                    'exp_date',
                                    'u.short_name as unit',
                                    DB::raw("SUM(COALESCE(quantity, 0) - COALESCE(quantity_sold, 0) - COALESCE(quantity_adjusted, 0)) as stock_left"),
                                    't.ref_no',
                                    't.id as transaction_id',
                                    'purchase_lines.id as purchase_line_id',
                                    'purchase_lines.lot_number')
                                    ->groupBy('purchase_lines.id');

            return Datatables::of($report)
                ->editColumn('name', function($row){
                    if($row->product_type == 'variable'){
                        return $row->product . ' - ' . 
                        $row->product_variation . ' - ' . $row->variation;
                    } else {
                        return $row->product;
                    }
                })
                ->editColumn('mfg_date', function($row){
                    if(!empty($row->mfg_date)){
                        return $this->productUtil->format_date($row->mfg_date);
                    } else {
                        return '--';
                    }
                })
                ->editColumn('exp_date', function($row){
                    if(!empty($row->exp_date)){
                        $carbon_exp = \Carbon::createFromFormat('Y-m-d', $row->exp_date);
                        $carbon_now = \Carbon::now();
                        if( $carbon_now->diffInDays($carbon_exp, false) >= 0 ){
                            return $this->productUtil->format_date($row->exp_date) . '<br><small>( <span class="time-to-now">' . $row->exp_date . '</span> )</small>';
                        } else {
                            return $this->productUtil->format_date($row->exp_date) . ' &nbsp; <span class="label label-danger">' . __('report.expired') . '</span><br><small>( <span class="time-from-now">' . $row->exp_date . '</span> )</small>';
                        }
                    } else {
                        return '--';
                    }
                })
                ->editColumn('ref_no', function($row){
                    return '<a href="' . action('PurchaseController@show', [$row->transaction_id])
                            . '" target="_blank" >' . $row->ref_no . '</a>';
                })
                ->editColumn('stock_left', function($row){
                    return $row->stock_left . ' ' . $row->unit;
                })
                ->addColumn('edit',
                    '<button type="button" class="btn btn-primary btn-xs stock_expiry_edit_btn" data-transaction_id={{$transaction_id}} data-purchase_line_id={{$purchase_line_id}}> <i class="fa fa-edit"></i> ' . __("messages.edit") . 
                    '</button>'
                )
                ->rawColumns(['exp_date', 'ref_no', 'edit'])
                ->make(true);
        }

        $categories = Category::where('business_id', $business_id)
                            ->where('parent_id', 0)
                            ->pluck('name', 'id');
        $brands = Brands::where('business_id', $business_id)
                            ->pluck('name', 'id');
        $units = Unit::where('business_id', $business_id)
                            ->pluck('short_name', 'id');
        $business_locations = BusinessLocation::forDropdown($business_id, true);
        $view_stock_filter = array(
            \Carbon::now()->subDay()->format('Y-m-d') => __('report.expired'),
            \Carbon::now()->addWeek()->format('Y-m-d') => __('report.expiring_in_1_week'),
            \Carbon::now()->addDays(15)->format('Y-m-d') => __('report.expiring_in_15_days'),
            \Carbon::now()->addMonth()->format('Y-m-d') => __('report.expiring_in_1_month'),
            \Carbon::now()->addMonths(3)->format('Y-m-d') => __('report.expiring_in_3_months'),
            \Carbon::now()->addMonths(6)->format('Y-m-d') => __('report.expiring_in_6_months'),
            \Carbon::now()->addYear()->format('Y-m-d') => __('report.expiring_in_1_year')
        );

        return view ('report.stock_expiry_report')
                ->with(compact('categories', 'brands', 'units', 'business_locations', 'view_stock_filter'));
    }

    /**
     * Shows product stock expiry report
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockExpiryReportEditModal(Request $request, $purchase_line_id){

        if (!auth()->user()->can('stock_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {
            $purchase_line = PurchaseLine::join('transactions as t', 
                                'purchase_lines.transaction_id', '=', 't.id')
                                ->join('products as p', 
                                'purchase_lines.product_id', '=', 'p.id')
                                ->where('purchase_lines.id', $purchase_line_id)
                                ->where('t.business_id', $business_id)
                                ->select(['purchase_lines.*', 'p.name', 't.ref_no'])
                                ->first();

            if(!empty($purchase_line)){
                $purchase_line->stock_left = $purchase_line->quantity - $purchase_line->quantity_sold - $purchase_line->quantity_adjusted;

                if(!empty($purchase_line->exp_date)){
                    $purchase_line->exp_date = date('m/d/Y', strtotime($purchase_line->exp_date));
                }
            }

            return view ('report.partials.stock_expiry_edit_modal')
                ->with(compact('purchase_line'));
        }
    }

    /**
     * Update product stock expiry report
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStockExpiryReport(Request $request){

        if (!auth()->user()->can('stock_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');

            //Return the details in ajax call
            if ($request->ajax()) {
                DB::beginTransaction();

                $input = $request->only(['purchase_line_id', 'stock_left', 'exp_date']);

                $purchase_line = PurchaseLine::join('transactions as t', 
                                    'purchase_lines.transaction_id', '=', 't.id')
                                    ->join('products as p', 
                                    'purchase_lines.product_id', '=', 'p.id')
                                    ->where('purchase_lines.id', $input['purchase_line_id'])
                                    ->where('t.business_id', $business_id)
                                    ->select(['purchase_lines.*', 'p.name', 't.ref_no'])
                                    ->first();

                if(!empty($purchase_line)){
                    $stock_left = $purchase_line->quantity - $purchase_line->quantity_sold - $purchase_line->quantity_adjusted;

                    $difference = $stock_left - $input['stock_left'];

                    $new_quantity = $input['stock_left'] + $purchase_line->quantity_sold + $purchase_line->quantity_adjusted;
                    if($new_quantity != 0){
                        $new_purchase_price = ($purchase_line->purchase_price * $purchase_line->quantity) / $new_quantity;
                        $new_pp_inc_tax = ($purchase_line->purchase_price_inc_tax * $purchase_line->quantity) / $new_quantity;
                    } else {
                        $new_purchase_price = $purchase_line->purchase_price;
                        $new_pp_inc_tax = $purchase_line->purchase_price_inc_tax;
                    }

                    $purchase_line->quantity = $new_quantity;
                    if($input['exp_date']){
                        $purchase_line->exp_date = \Carbon::createFromFormat('m/d/Y', $input['exp_date'])->toDateString();                        
                    }

                    $purchase_line->purchase_price = $new_purchase_price;
                    $purchase_line->purchase_price_inc_tax = $new_pp_inc_tax;
                    $purchase_line->save();
                    
                }

                DB::commit();

                $output = array('success' => 1, 
                            'msg' => __('lang_v1.updated_succesfully')
                        );
            }
        } catch(\Exception $e){
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => __('messages.something_went_wrong')
                        );
        }

        return $output;
    }

    /**
     * Shows product stock expiry report
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomerGroup(Request $request)
    {
        if (!auth()->user()->can('contacts_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        if ($request->ajax()) {
            $query = Transaction::leftjoin('customer_groups AS CG', 'transactions.customer_group_id', '=', 'CG.id')
                        ->where('transactions.business_id', $business_id)
                        ->where('transactions.type', 'sell')
                        ->groupBy('transactions.customer_group_id')
                        ->select(DB::raw("SUM(final_total) as total_sell"), 'CG.name');

            $group_id = $request->get('customer_group_id', null);
            if(!empty($group_id)){
                $query->where('transactions.customer_group_id', $group_id);
            }

            $location_id = $request->get('location_id', null);
            if(!empty($location_id)){
                $query->where('transactions.location_id', $location_id);
            }

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            
            if(!empty($start_date) && !empty($end_date)){
                $query->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
            }
            

            return Datatables::of($query)
                ->editColumn('total_sell', function($row){
                    return '<span class="display_currency" data-currency_symbol = true>' . $row->total_sell . '</span>';
                })
                ->rawColumns(['total_sell'])
                ->make(true);
        }

        $customer_group = CustomerGroup::forDropdown($business_id, false, true);
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view ('report.customer_group')
            ->with(compact('customer_group', 'business_locations'));
    }

    /**
     * Shows product purchase report
     *
     * @return \Illuminate\Http\Response
     */
    public function getproductPurchaseReport(Request $request){

        if (!auth()->user()->can('purchase_n_sell_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');
        if ($request->ajax()) {
            $variation_id = $request->get('variation_id', null);
            $query = PurchaseLine::join('transactions as t', 'purchase_lines.transaction_id', 
                                    '=', 't.id')
                                ->join('variations as v', 'purchase_lines.variation_id', 
                                    '=', 'v.id')
                                ->join('product_variations as pv', 'v.product_variation_id', '=', 'pv.id')
                                ->join('contacts as c', 't.contact_id', '=', 'c.id')
                                ->join('products as p', 'pv.product_id', '=', 'p.id')
                                ->where('t.business_id', $business_id)
                                ->where('t.type', 'purchase')
                                ->where('purchase_lines.variation_id', $variation_id)
                                ->select(
                                    'p.name as product_name',
                                    'p.type as product_type',
                                    'pv.name as product_variation',
                                    'v.name as variation_name',
                                    'c.name as supplier',
                                    't.id as transaction_id',
                                    't.ref_no',
                                    't.transaction_date as transaction_date',
                                    'purchase_lines.purchase_price as unit_purchase_price'
                                )
                                ->groupBy('purchase_lines.id');

            $location_id = $request->get('location_id', null);
            if(!empty($location_id)){
                $query->where('t.location_id', $location_id);
            }

            $supplier_id = $request->get('supplier_id', null);
            if(!empty($supplier_id)){
                $query->where('t.contact_id', $supplier_id);
            }

            return Datatables::of($query)
                ->editColumn('product_name', function($row){
                    $product_name = $row->product_name;
                    if($row->product_type == 'variable'){
                        $product_name .= ' - ' . $row->product_variation . ' - ' . $row->variation_name;
                    }

                    return $product_name;
                })
                 ->editColumn('ref_no', function($row){
                    return '<a href="' . action('PurchaseController@show', [$row->transaction_id])
                            . '" target="_blank" >' . $row->ref_no . '</a>';
                })
                ->editColumn('transaction_date', '{{@format_date($transaction_date)}}')
                ->editColumn('unit_purchase_price', function($row){
                    return '<span class="display_currency" data-currency_symbol = true>' . $row->unit_purchase_price . '</span>';
                })
                ->rawColumns(['ref_no', 'unit_purchase_price'])
                ->make(true);
        }

        $business_locations = BusinessLocation::forDropdown($business_id);
        $suppliers = Contact::suppliersDropdown($business_id);

        return view ('report.product_purchase_report')
            ->with(compact('business_locations', 'suppliers'));
    }

    /**
     * Shows product purchase report
     *
     * @return \Illuminate\Http\Response
     */
    public function getproductSellReport(Request $request){

        if (!auth()->user()->can('purchase_n_sell_report.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');
        if ($request->ajax()) {
            $variation_id = $request->get('variation_id', null);
            $query = TransactionSellLine::join('transactions as t', 
                                    'transaction_sell_lines.transaction_id', 
                                    '=', 't.id')
                                ->join('variations as v', 'transaction_sell_lines.variation_id', 
                                    '=', 'v.id')
                                ->join('product_variations as pv', 'v.product_variation_id', '=', 'pv.id')
                                ->join('contacts as c', 't.contact_id', '=', 'c.id')
                                ->join('products as p', 'pv.product_id', '=', 'p.id')
                                ->where('t.business_id', $business_id)
                                ->where('t.type', 'sell')
                                ->where('transaction_sell_lines.variation_id', $variation_id)
                                ->select(
                                    'p.name as product_name',
                                    'p.type as product_type',
                                    'pv.name as product_variation',
                                    'v.name as variation_name',
                                    'c.name as customer',
                                    't.id as transaction_id',
                                    't.invoice_no',
                                    't.transaction_date as transaction_date',
                                    'transaction_sell_lines.unit_price as unit_sale_price'
                                )
                                ->groupBy('transaction_sell_lines.id');

            $location_id = $request->get('location_id', null);
            if(!empty($location_id)){
                $query->where('t.location_id', $location_id);
            }

            $customer_id = $request->get('customer_id', null);
            if(!empty($customer_id)){
                $query->where('t.contact_id', $customer_id);
            }

            return Datatables::of($query)
                ->editColumn('product_name', function($row){
                    $product_name = $row->product_name;
                    if($row->product_type == 'variable'){
                        $product_name .= ' - ' . $row->product_variation . ' - ' . $row->variation_name;
                    }

                    return $product_name;
                })
                 ->editColumn('invoice_no', function($row){
                    return '<a href="' . action('SellController@show', [$row->transaction_id])
                            . '" target="_blank" >' . $row->invoice_no . '</a>';
                })
                ->editColumn('transaction_date', '{{@format_date($transaction_date)}}')
                ->editColumn('unit_sale_price', function($row){
                    return '<span class="display_currency" data-currency_symbol = true>' . $row->unit_sale_price . '</span>';
                })
                ->rawColumns(['invoice_no', 'unit_sale_price'])
                ->make(true);
        }

        $business_locations = BusinessLocation::forDropdown($business_id);
        $customers = Contact::customersDropdown($business_id);

        return view ('report.product_sell_report')
            ->with(compact('business_locations', 'customers'));
    }
}
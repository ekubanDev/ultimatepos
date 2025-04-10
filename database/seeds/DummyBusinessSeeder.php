<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Role, 
	Spatie\Permission\Models\Permission;

use App\User;

class DummyBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $password = bcrypt('123456');

        $today = \Carbon::now()->format('Y-m-d H:i:s');
        $yesterday = \Carbon::now()->subDays(2)->format('Y-m-d H:i:s');
        $last_week = \Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
        $last_15th_day = \Carbon::now()->subDays(15)->format('Y-m-d H:i:s');
        $last_month = \Carbon::now()->subDays(30)->format('Y-m-d H:i:s');

        $next_6_month = \Carbon::now()->addMonths(6)->format('Y-m-d');
        $next_12_month = \Carbon::now()->addMonths(12)->format('Y-m-d');
        $next_18_month = \Carbon::now()->addMonths(18)->format('Y-m-d');

        DB::statement("SET FOREIGN_KEY_CHECKS = 0");

         $shortcuts = '{"pos":{"express_checkout":"shift+e","pay_n_ckeckout":"shift+p","draft":"shift+d","cancel":"shift+c","edit_discount":"shift+i","edit_order_tax":"shift+t","add_payment_row":"shift+r","finalize_payment":"shift+f","recent_product_quantity":"f2","add_new_product":"f4"}}';
        
        DB::insert("INSERT INTO business (id, name, currency_id, start_date, tax_number_1, tax_label_1, tax_number_2, tax_label_2, default_sales_tax, default_profit_percent, owner_id, time_zone, fy_start_month, accounting_method, default_sales_discount, sell_price_tax, logo, sku_prefix, enable_product_expiry, expiry_type, on_product_expiry, stop_selling_before, enable_tooltip, purchase_in_diff_currency, purchase_currency_id, p_exchange_rate, transaction_edit_days, stock_expiry_alert_days, keyboard_shortcuts, pos_settings, enable_brand, enable_category, enable_sub_category, enable_price_tax, enable_purchase_status, default_unit, enable_editing_product_from_purchase, sales_cmsn_agnt, item_addition_method, enable_inline_tax, currency_symbol_placement, created_at, updated_at) VALUES
			(1, 'Awesome Shop', 2, '2018-01-01', '3412569900', 'GSTIN', NULL, NULL, NULL, 25.00, 1, 'America/Phoenix', 1, 'fifo', '10.00', 'includes', NULL, 'AS', 0, 'add_expiry', 'keep_selling', 0, 1, 0, NULL, '1.000', 30, 30, '$shortcuts', NULL, 1, 1, 1, 1, 1, NULL, 1, NULL, 1, 1, 'before', '2018-01-04 02:15:19', '2018-01-04 02:17:08'),
			(2, 'Awesome Pharmacy', 2, '2018-04-10', '3412569900', 'VAT', NULL, NULL, NULL, 25.00, 4, 'America/Chicago', 1, 'fifo', NULL, 'includes', NULL, 'AP', 1, 'add_manufacturing', 'stop_selling', 0, 1, 0, NULL, '1.000', 30, 30, '$shortcuts', NULL, 1, 1, 1, 1, 1, 4, 1, NULL, 1, 0, 'before', '2018-04-10 08:12:40', '2018-04-10 10:21:38'),
			(3, 'Ultimate Electronics', 2, '2018-04-10', '12548555003', 'GST', NULL, NULL, NULL, 25.00, 5, 'America/Chicago', 1, 'fifo', NULL, 'includes', NULL, 'AE', 0, 'add_expiry', 'keep_selling', 0, 1, 0, NULL, '1.000', 30, 30, '$shortcuts', NULL, 1, 1, 1, 1, 1, 5, 1, NULL, 1, 0, 'before', '2018-04-10 10:46:15', '2018-04-10 11:53:35'),
			(4, 'Awesome Services', 124, NULL, '3412569900', 'GST', NULL, NULL, NULL, 25.00, 6, 'America/Chicago', 1, 'fifo', NULL, 'includes', NULL, 'AS', 0, 'add_expiry', 'keep_selling', 0, 1, 0, NULL, '1.000', 30, 30, '$shortcuts', NULL, 0, 1, 0, 1, 1, NULL, 1, NULL, 1, 0, 'before', '2018-04-10 12:20:42', '2018-04-10 12:23:40')");

        DB::insert("INSERT INTO business_locations (id, business_id, name, landmark, country, state, city, zip_code, invoice_scheme_id, invoice_layout_id, print_receipt_on_invoice, receipt_printer_type, printer_id, mobile, alternate_number, email, deleted_at, created_at, updated_at) VALUES
					(1, 1, 'Awesome Shop', 'Linking Street', 'USA', 'Arizona', 'Phoenix', '85001', 1, 1, 1, 'browser', NULL, NULL, NULL, NULL, NULL, '2018-01-04 02:15:20', '2018-01-04 02:15:20'),
(2, 2, 'Awesome Pharmacy', 'Linking Street', 'USA', 'Arizona', 'Phoenix', '492001', 2, 2, 1, 'browser', NULL, '', '', '', NULL, '2018-04-10 08:12:40', '2018-04-10 08:12:40'),
(3, 3, 'Ultimate Electronics', 'Linking Street', 'USA', 'Arizona', 'Phoenix', '492001', 3, 3, 1, 'browser', NULL, '', '', '', NULL, '2018-04-10 10:46:16', '2018-04-10 10:46:16'),
(4, 4, 'Awesome Services', 'Linking Street', 'USA', 'Arizona', 'Phoenix', '282001', 4, 4, 1, 'browser', NULL, '', '', '', NULL, '2018-04-10 12:20:43', '2018-04-10 12:20:43')");

        DB::insert("INSERT INTO users (id, surname, first_name, last_name, username, email, password, language, contact_no, address, remember_token, business_id, is_cmmsn_agnt, cmmsn_percent, deleted_at, created_at, updated_at) VALUES
					(1, 'Mr', 'Admin', NULL, 'admin', 'admin@example.com', '$password', 'en', NULL, NULL, '6wUbpN3xEjDDyQwCfHiGqO7JkIQgjYoDFeQMxcp09YQXq1Ih1e5EqydddBMz', 1, 0, '0.00', NULL, '2018-01-04 02:15:19', '2018-01-04 02:15:19'),
(2, 'Mr', 'Demo', 'Cashier', 'cashier', 'cashier@example.com', '$password', 'en', NULL, NULL, NULL, 1, 0, '0.00', NULL, '2018-01-04 02:20:58', '2018-01-04 02:20:58'),
(3, 'Mr.', 'Demo', 'Admin', 'demo-admin', 'demoadmin@example.com', '$password', 'en', NULL, NULL, NULL, 1, 0, '0.00', NULL, '2018-01-06 07:10:57', '2018-01-06 07:10:57'),
(4, 'Mr', 'Demo', 'Admin', 'admin-pharmacy', 'admin-pharma@example.com', '$password', 'en', NULL, NULL, 'MJnleh4kefXZtw3FCI2yHKEwr45Rs5nZxyQyGSFRfjIcQn93sJZyw7BAzSUq', 2, 0, '0.00', NULL, '2018-04-10 08:12:40', '2018-04-10 08:12:40'),
(5, 'Mr', 'Demo', 'Admin', 'admin-electronics', 'admin-electronics@example.com', '$password', 'en', NULL, NULL, 'YzGFoRAfllUjyB12qIZhowlteUPhvR1cd77YREQuqemSUftHp72aRLZMrzwR', 3, 0, '0.00', NULL, '2018-04-10 10:46:15', '2018-04-10 10:46:15'),
(6, 'Mr', 'Demo', 'Admin', 'admin-services', 'admin-services@example.com', '$password', 'en', NULL, NULL, 'CdBNjmTIXVU0nEgcEg85L97w6JEjvuE6CfF7mvhmz7Ad2K7IxJVd9WPLdxcg', 4, 0, '0.00', NULL, '2018-04-10 12:20:42', '2018-04-10 12:20:42')");

        DB::insert("INSERT INTO brands (id, business_id, name, description, created_by, deleted_at, created_at, updated_at) VALUES
					(1, 1, 'Levis', NULL, 1, NULL, '2018-01-03 21:19:47', '2018-01-03 21:19:47'),
(2, 1, 'Espirit', NULL, 1, NULL, '2018-01-03 21:19:58', '2018-01-03 21:19:58'),
(3, 1, 'U.S. Polo Assn.', NULL, 1, NULL, '2018-01-03 21:20:26', '2018-01-03 21:20:26'),
(4, 1, 'Nike', NULL, 1, NULL, '2018-01-03 21:20:34', '2018-01-03 21:20:34'),
(5, 1, 'Puma', NULL, 1, NULL, '2018-01-03 21:20:40', '2018-01-03 21:20:40'),
(6, 1, 'Adidas', NULL, 1, NULL, '2018-01-03 21:20:46', '2018-01-03 21:20:46'),
(7, 1, 'Samsung', NULL, 1, NULL, '2018-01-06 05:40:14', '2018-01-06 05:40:14'),
(8, 1, 'Apple', NULL, 1, NULL, '2018-01-06 05:40:23', '2018-01-06 05:40:23'),
(9, 1, 'Acer', NULL, 1, NULL, '2018-01-06 06:03:37', '2018-01-06 06:03:37'),
(10, 1, 'Bowflex', NULL, 1, NULL, '2018-01-06 06:15:31', '2018-01-06 06:15:31'),
(11, 1, 'Oreo', NULL, 1, NULL, '2018-01-06 06:35:00', '2018-01-06 06:35:00'),
(12, 1, 'Sharewood', NULL, 1, NULL, '2018-01-06 06:40:52', '2018-01-06 06:40:52'),
(13, 1, 'Barilla', NULL, 1, NULL, '2018-01-06 06:44:59', '2018-01-06 06:44:59'),
(14, 1, 'Lipton', NULL, 1, NULL, '2018-01-06 06:48:12', '2018-01-06 06:48:12'),
(15, 2, 'Acino', NULL, 4, NULL, '2018-04-10 08:14:44', '2018-04-10 08:14:44'),
(16, 2, 'Cipla', NULL, 4, NULL, '2018-04-10 08:15:04', '2018-04-10 08:15:04'),
(17, 2, 'BAYER', NULL, 4, NULL, '2018-04-10 08:15:32', '2018-04-10 08:15:32'),
(18, 3, 'Samsung', NULL, 5, NULL, '2018-04-10 10:57:28', '2018-04-10 10:57:28'),
(19, 3, 'LG', NULL, 5, NULL, '2018-04-10 10:57:35', '2018-04-10 10:57:35'),
(20, 3, 'Apple', NULL, 5, NULL, '2018-04-10 10:57:42', '2018-04-10 10:57:42'),
(21, 3, 'Sony', NULL, 5, NULL, '2018-04-10 10:57:49', '2018-04-10 10:57:49'),
(22, 3, 'Panasonic', NULL, 5, NULL, '2018-04-10 10:57:57', '2018-04-10 10:57:57'),
(23, 3, 'HP', NULL, 5, NULL, '2018-04-10 11:07:21', '2018-04-10 11:07:21')");

        DB::insert("INSERT INTO categories (id, name, business_id, short_code, parent_id, created_by, deleted_at, created_at, updated_at) VALUES
					(1, 'Men''s', 1, NULL, 0, 1, NULL, '2018-01-03 21:06:34', '2018-01-03 21:06:34'),
(2, 'Women''s', 1, NULL, 0, 1, NULL, '2018-01-03 21:06:46', '2018-01-03 21:06:46'),
(3, 'Accessories', 1, NULL, 0, 1, NULL, '2018-01-03 21:07:03', '2018-01-03 21:07:03'),
(4, 'Jeans', 1, NULL, 1, 1, NULL, '2018-01-03 21:07:34', '2018-01-03 21:07:34'),
(5, 'Shirts', 1, NULL, 1, 1, NULL, '2018-01-03 21:08:18', '2018-01-03 21:08:18'),
(6, 'Belts', 1, NULL, 3, 1, NULL, '2018-01-03 21:08:41', '2018-01-03 21:08:41'),
(8, 'Shoes', 1, NULL, 3, 1, NULL, '2018-01-03 21:09:04', '2018-01-03 21:09:04'),
(10, 'Sandal', 1, NULL, 3, 1, NULL, '2018-01-03 21:09:23', '2018-01-03 21:09:23'),
(11, 'Wallets', 1, NULL, 3, 1, NULL, '2018-01-03 23:05:50', '2018-01-03 23:05:50'),
(12, 'Electronics', 1, NULL, 0, 1, NULL, '2018-01-06 05:24:34', '2018-01-06 05:24:34'),
(13, 'Cell Phones', 1, NULL, 12, 1, NULL, '2018-01-06 05:24:57', '2018-01-06 05:24:57'),
(14, 'Computers', 1, NULL, 12, 1, NULL, '2018-01-06 05:25:55', '2018-01-06 05:25:55'),
(15, 'Sports', 1, NULL, 0, 1, NULL, '2018-01-06 05:27:33', '2018-01-06 05:27:33'),
(16, 'Athletic Clothing', 1, NULL, 15, 1, NULL, '2018-01-06 05:28:40', '2018-01-06 05:28:40'),
(17, 'Exercise & Fitness', 1, NULL, 15, 1, NULL, '2018-01-06 05:29:19', '2018-01-06 05:29:19'),
(18, 'Books', 1, NULL, 0, 1, NULL, '2018-01-06 05:29:59', '2018-01-06 05:29:59'),
(19, 'Autobiography', 1, NULL, 18, 1, NULL, '2018-01-06 05:30:16', '2018-01-06 05:30:16'),
(20, 'Children''s books', 1, NULL, 18, 1, NULL, '2018-01-06 05:30:58', '2018-01-06 05:30:58'),
(21, 'Food & Grocery', 1, NULL, 0, 1, NULL, '2018-01-06 05:31:35', '2018-01-06 05:31:35'),
(22, 'Capsule', 2, NULL, 0, 4, NULL, '2018-04-10 08:19:58', '2018-04-10 08:20:54'),
(23, 'Bandages', 2, NULL, 0, 4, NULL, '2018-04-10 08:20:48', '2018-04-10 08:20:48'),
(24, 'Cream', 2, NULL, 0, 4, NULL, '2018-04-10 08:21:23', '2018-04-10 08:21:23'),
(25, 'Drops', 2, NULL, 0, 4, NULL, '2018-04-10 08:21:31', '2018-04-10 08:21:31'),
(26, 'Gel', 2, NULL, 0, 4, NULL, '2018-04-10 08:21:57', '2018-04-10 08:21:57'),
(27, 'Bottle', 2, NULL, 0, 4, NULL, '2018-04-10 08:22:30', '2018-04-10 08:22:30'),
(28, 'Mobile Phones', 3, NULL, 0, 5, NULL, '2018-04-10 10:59:49', '2018-04-10 10:59:49'),
(29, 'Tablets', 3, NULL, 0, 5, NULL, '2018-04-10 11:00:02', '2018-04-10 11:00:02'),
(30, 'Laptops', 3, NULL, 0, 5, NULL, '2018-04-10 11:00:09', '2018-04-10 11:00:09'),
(31, 'TVs', 3, NULL, 0, 5, NULL, '2018-04-10 11:00:15', '2018-04-10 11:00:15'),
(32, 'Cameras', 3, NULL, 0, 5, NULL, '2018-04-10 11:00:29', '2018-04-10 11:00:29'),
(33, 'Accessories', 3, NULL, 0, 5, NULL, '2018-04-10 11:00:57', '2018-04-10 11:00:57'),
(34, 'Car Services', 4, NULL, 0, 6, NULL, '2018-04-10 12:25:33', '2018-04-10 12:30:10'),
(35, 'Hair Styling', 4, NULL, 0, 6, NULL, '2018-04-10 12:28:32', '2018-04-10 12:29:18'),
(36, 'Plumbing', 4, NULL, 0, 6, NULL, '2018-04-10 12:30:41', '2018-04-10 12:30:41'),
(37, 'Bodycare', 4, NULL, 0, 6, NULL, '2018-04-10 12:30:52', '2018-04-10 12:30:52'),
(38, 'Spa', 4, NULL, 0, 6, NULL, '2018-04-10 12:31:01', '2018-04-10 12:31:01')");

        DB::insert("INSERT INTO contacts (id, business_id, type, supplier_business_name, name, contact_id, tax_number, city, state, country, landmark, mobile, landline, alternate_number, pay_term_number, pay_term_type, created_by, is_default, customer_group_id, deleted_at, created_at, updated_at) VALUES
					(1, 1, 'customer', NULL, 'Walk-In Customer', NULL, NULL, 'Phoenix', 'Arizona', 'USA', 'Linking Street', '(378) 400-1234', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2018-01-03 20:45:20', '2018-01-03 21:05:37'),
(2, 1, 'supplier', 'Alpha Clothings', 'Michael', NULL, '4590091535', 'Phoenix', 'Arizona', 'USA', 'Linking Street', '(378) 400-1234', NULL, NULL, 15, 'days', 1, 0, NULL, NULL, '2018-01-03 20:59:38', '2018-01-03 21:05:10'),
(3, 1, 'supplier', 'Manhattan Clothing Ltd.', 'Philip', NULL, '54869310093', 'Phoenix', 'Arizona', 'USA', 'Linking Street', '(378) 400-1234', NULL, NULL, 15, 'days', 1, 0, NULL, NULL, '2018-01-03 21:00:55', '2018-01-03 21:14:06'),
(4, 1, 'customer', NULL, 'Harry', NULL, NULL, 'Phoenix', 'Arizona', 'USA', 'Linking Street', '(378) 400-1234', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2018-01-03 21:01:40', '2018-01-03 21:05:32'),
(5, 1, 'supplier', 'Digital Ocean', 'Mike McCubbin', NULL, '52965489001', 'Phoenix', 'Arizona', 'USA', 'Linking Street', '(378) 400-1234', NULL, NULL, 30, 'days', 1, 0, NULL, NULL, '2018-01-06 06:53:22', '2018-01-06 06:53:22'),
(6, 1, 'supplier', 'Univer Suppliers', 'Jackson Hill', NULL, '5459000655', 'Phoenix', 'Arizona', 'USA', 'Linking Street', '(378) 400-1234', NULL, NULL, 45, 'days', 1, 0, NULL, NULL, '2018-01-06 06:55:09', '2018-01-06 06:55:09'),
(7, 2, 'customer', NULL, 'Walk-In Customer', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 4, 1, NULL, NULL, '2018-04-10 08:12:40', '2018-04-10 08:12:40'),
(8, 2, 'supplier', 'Jones Pharma', 'Micheal Larson', '522500003', NULL, 'Phoenix', 'Arizona', 'USA', NULL, '(378) 400-1234', NULL, NULL, 30, 'days', 4, 0, NULL, NULL, '2018-04-10 10:02:52', '2018-04-10 10:02:52'),
(9, 2, 'supplier', 'Axolotl Biologix', 'Phillip Jenner', '4585220005', NULL, 'Phoenix', 'Arizona', 'USA', NULL, '(378) 400-1234', NULL, NULL, 30, 'days', 4, 0, NULL, NULL, '2018-04-10 10:04:20', '2018-04-10 10:04:20'),
(10, 3, 'customer', NULL, 'Walk-In Customer', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 5, 1, NULL, NULL, '2018-04-10 10:46:16', '2018-04-10 10:46:16'),
(11, 3, 'supplier', 'Digital Ocean', 'Micheal Krick', '12500079', NULL, 'Phoenix', 'Arizona', 'USA', NULL, '(378) 400-1234', NULL, NULL, 30, 'days', 5, 0, NULL, NULL, '2018-04-10 11:36:21', '2018-04-10 11:36:21'),
(12, 3, 'supplier', 'Neon Electronics', 'Samuel Williams', '525800083', NULL, 'Phoenix', 'Arizona', 'USA', NULL, '(378) 400-1234', NULL, NULL, 30, 'days', 5, 0, NULL, NULL, '2018-04-10 11:38:33', '2018-04-10 11:38:33'),
(13, 4, 'customer', NULL, 'Walk-In Customer', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 6, 1, NULL, NULL, '2018-04-10 12:20:43', '2018-04-10 12:20:43')");

        DB::insert("INSERT INTO tax_rates (id, business_id, name, amount, is_tax_group, created_by, deleted_at, created_at, updated_at) VALUES
					(1, 1, 'VAT@10%', 10.00, 0, 1, NULL, '2018-01-04 02:40:07', '2018-01-04 02:40:07'),
(2, 1, 'CGST@10%', 10.00, 0, 1, NULL, '2018-01-04 02:40:55', '2018-01-04 02:40:55'),
(3, 1, 'SGST@8%', 8.00, 0, 1, NULL, '2018-01-04 02:41:13', '2018-01-04 02:41:13'),
(4, 1, 'GST@18%', 18.00, 1, 1, NULL, '2018-01-04 02:42:19', '2018-01-04 02:42:19')");

        DB::insert("INSERT INTO group_sub_taxes (group_tax_id, tax_id) VALUES
					(4, 2),
					(4, 3)");

        DB::insert("INSERT INTO invoice_schemes (id, business_id, name, scheme_type, prefix, start_number, invoice_count, total_digits, is_default, created_at, updated_at) VALUES
					(1, 1, 'Default', 'blank', 'AS', 1, 5, 4, 1, '2018-01-04 02:15:20', '2018-01-04 02:45:16'),
(2, 2, 'Default', 'blank', 'AP', 1, 3, 4, 1, '2018-04-10 08:12:40', '2018-04-10 10:26:12'),
(3, 3, 'Default', 'blank', 'AE', 1, 5, 4, 1, '2018-04-10 10:46:16', '2018-04-10 11:54:16'),
(4, 4, 'Default', 'blank', '', 1, 8, 4, 1, '2018-04-10 12:20:43', '2018-04-10 13:08:49')");

        DB::insert("INSERT INTO invoice_layouts (id, name, header_text, invoice_no_prefix, invoice_heading, sub_heading_line1, sub_heading_line2, sub_heading_line3, sub_heading_line4, sub_heading_line5, invoice_heading_not_paid, invoice_heading_paid, sub_total_label, discount_label, tax_label, total_label, total_due_label, paid_label, show_client_id, client_id_label, date_label, show_time, show_brand, show_sku, show_cat_code, show_sale_description, table_product_label, table_qty_label, table_unit_price_label, table_subtotal_label, logo, show_logo, show_business_name, show_location_name, show_landmark, show_city, show_state, show_zip_code, show_country, show_mobile_number, show_alternate_number, show_email, show_tax_1, show_tax_2, show_barcode, show_payments, show_customer, customer_label, highlight_color, footer_text, is_default, business_id, created_at, updated_at) VALUES
        	(1, 'Default', NULL, 'Invoice No.', 'Invoice', NULL, NULL, NULL, NULL, NULL, '', '', 'Subtotal', 'Discount', 'Tax', 'Total', 'Total Due', 'Total Paid', 0, NULL, 'Date', 1, 0, 1, 1, 0, 'Product', 'Quantity', 'Unit Price', 'Subtotal', NULL, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 'Customer', '#000000', '', 1, 1, '2018-04-03 23:35:32', '2018-04-03 23:35:32'),
(2, 'Default', NULL, 'Invoice No.', 'Invoice', NULL, NULL, NULL, NULL, NULL, '', '', 'Subtotal', 'Discount', 'Tax', 'Total', 'Total Due', 'Total Paid', 0, NULL, 'Date', 1, 0, 1, 1, 0, 'Product', 'Quantity', 'Unit Price', 'Subtotal', NULL, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 'Customer', '#000000', '', 1, 2, '2018-04-10 08:12:40', '2018-04-10 08:12:40'),
(3, 'Default', NULL, 'Invoice No.', 'Invoice', NULL, NULL, NULL, NULL, NULL, '', '', 'Subtotal', 'Discount', 'Tax', 'Total', 'Total Due', 'Total Paid', 0, NULL, 'Date', 1, 0, 1, 1, 0, 'Product', 'Quantity', 'Unit Price', 'Subtotal', NULL, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 'Customer', '#000000', '', 1, 3, '2018-04-10 10:46:16', '2018-04-10 10:46:16'),
(4, 'Default', NULL, 'Invoice No.', 'Invoice', NULL, NULL, NULL, NULL, NULL, '', '', 'Subtotal', 'Discount', 'Tax', 'Total', 'Total Due', 'Total Paid', 0, NULL, 'Date', 1, 0, 1, 1, 0, 'Product', 'Quantity', 'Unit Price', 'Subtotal', NULL, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 'Customer', '#000000', '', 1, 4, '2018-04-10 12:20:43', '2018-04-10 12:20:43')");

        DB::insert("INSERT INTO units (id, business_id, actual_name, short_name, allow_decimal, created_by, deleted_at, created_at, updated_at) VALUES
					(1, 1, 'Pieces', 'Pc(s)', 0, 1, NULL, '2018-01-03 20:45:20', '2018-01-03 20:45:20'),
(2, 1, 'Packets', 'packets', 0, 1, NULL, '2018-01-06 06:37:01', '2018-01-06 06:38:36'),
(3, 1, 'Grams', 'g', 1, 1, NULL, '2018-01-06 06:40:34', '2018-01-06 06:40:34'),
(4, 2, 'Pieces', 'Pc(s)', 0, 4, NULL, '2018-04-10 08:12:40', '2018-04-10 08:12:40'),
(5, 3, 'Units', 'units', 0, 5, NULL, '2018-04-10 10:46:16', '2018-04-10 10:59:19'),
(6, 4, 'Units', 'units', 0, 6, NULL, '2018-04-10 12:20:43', '2018-04-10 12:32:04')");

        DB::insert("INSERT INTO products (id, name, business_id, type, unit_id, brand_id, category_id, sub_category_id, tax, tax_type, enable_stock, alert_quantity, sku, barcode_type, expiry_period, expiry_period_type, enable_sr_no, created_by, created_at, updated_at) VALUES
					(1, 'Men''s Reverse Fleece Crew', 1, 'single', 1, 1, 1, 5, 1, 'exclusive', 1, 5, 'AS0001', 'C128', NULL, NULL, 0, 1, '2018-01-03 21:29:08', '2018-01-06 05:51:33'),
(2, 'Levis Men''s Slimmy Fit Jeans', 1, 'variable', 1, 1, 1, 4, 1, 'exclusive', 1, 10, 'AS0002', 'C128', NULL, NULL, 0, 1, '2018-01-03 21:30:35', '2018-01-06 05:51:16'),
(3, 'Men''s Cozy Hoodie Sweater', 1, 'variable', 1, 2, 1, 5, 1, 'exclusive', 1, 10, 'AS0003', 'C128', NULL, NULL, 0, 1, '2018-01-03 22:51:52', '2018-01-06 05:50:51'),
(4, 'Puma Brown Sneaker', 1, 'variable', 1, 5, 3, 8, 1, 'exclusive', 1, 5, 'AS0004', 'C128', NULL, NULL, 0, 1, '2018-01-03 22:54:33', '2018-01-03 22:54:33'),
(8, 'Nike Fashion Sneaker', 1, 'variable', 1, 4, 3, 8, 1, 'exclusive', 1, 10, 'AS0008', 'C128', NULL, NULL, 0, 1, '2018-01-03 23:10:10', '2018-01-03 23:10:10'),
(9, 'PUMA Men''s Black Sneaker', 1, 'variable', 1, 5, 3, 8, 1, 'exclusive', 1, 10, 'AS0009', 'C128', NULL, NULL, 0, 1, '2018-01-03 23:11:57', '2018-01-03 23:11:57'),
(10, 'NIKE Men''s Running Shoe', 1, 'variable', 1, 4, 3, 8, 1, 'exclusive', 1, 10, 'AS0010', 'C128', NULL, NULL, 0, 1, '2018-01-03 23:13:02', '2018-01-03 23:13:02'),
(11, 'U.S. Polo Men''s Leather Belt', 1, 'single', 1, 3, 3, 6, 1, 'exclusive', 1, 15, 'AS0011', 'C128', NULL, NULL, 0, 1, '2018-01-03 23:14:35', '2018-01-03 23:14:35'),
(12, 'Unisex Brown Leather Wallet', 1, 'single', 1, 1, 3, 11, 1, 'exclusive', 1, 10, 'AS0012', 'C128', NULL, NULL, 0, 1, '2018-01-03 23:15:50', '2018-01-06 05:51:49'),
(13, 'Men Full sleeve T Shirt', 1, 'variable', 1, 2, 1, 5, 1, 'exclusive', 1, 15, 'AS0013', 'C128', NULL, NULL, 0, 1, '2018-01-03 23:17:59', '2018-01-03 23:17:59'),
(14, 'Samsung Galaxy S8', 1, 'variable', 1, 7, 12, 13, 1, 'exclusive', 1, 100, 'AS0014', 'C128', NULL, NULL, 0, 1, '2018-01-06 05:42:19', '2018-01-06 05:42:19'),
(15, 'Apple iPhone 8', 1, 'variable', 1, 8, 12, 13, 1, 'exclusive', 1, 100, 'AS0015', 'C128', NULL, NULL, 0, 1, '2018-01-06 05:49:51', '2018-01-06 05:49:51'),
(16, 'Samsung Galaxy J7 Pro', 1, 'variable', 1, 7, 12, 13, NULL, 'exclusive', 1, 100, 'AS0016', 'C128', NULL, NULL, 0, 1, '2018-01-06 05:54:48', '2018-01-06 05:54:48'),
(17, 'Acer Aspire E 15', 1, 'variable', 1, 9, 12, 14, NULL, 'exclusive', 1, 70, 'AS0017', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:05:01', '2018-01-06 06:05:01'),
(18, 'Apple MacBook Air', 1, 'variable', 1, 8, 12, 14, NULL, 'exclusive', 1, 30, 'AS0018', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:07:30', '2018-01-06 06:07:30'),
(19, 'Cushion Crew Socks', 1, 'single', 1, 4, 15, 16, NULL, 'exclusive', 1, 100, 'AS0019', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:10:28', '2018-01-06 06:11:01'),
(20, 'Sports Tights Pants', 1, 'variable', 1, 6, 15, 16, 1, 'exclusive', 1, 60, 'AS0020', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:13:00', '2018-01-06 06:13:00'),
(21, 'Pair Of Dumbbells', 1, 'single', 1, 10, 15, 17, NULL, 'exclusive', 1, 45, 'AS0021', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:16:35', '2018-01-06 06:16:35'),
(22, 'Diary of a Wimpy Kid', 1, 'single', 1, NULL, 18, 20, 1, 'exclusive', 1, 20, 'AS0022', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:25:09', '2018-01-06 06:25:09'),
(23, 'Sneezy the Snowman', 1, 'single', 1, NULL, 18, 20, NULL, 'exclusive', 1, 20, 'AS0023', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:26:27', '2018-01-06 06:26:27'),
(24, 'Etched in Sand Autobiography', 1, 'single', 1, NULL, 18, 19, 1, 'exclusive', 1, 30, 'AS0024', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:31:22', '2018-01-06 06:31:22'),
(25, 'Five Presidents', 1, 'single', 1, NULL, 18, 19, NULL, 'exclusive', 1, 30, 'AS0025', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:32:22', '2018-01-06 06:32:22'),
(26, 'Oreo Cookies', 1, 'single', 2, 11, 21, NULL, NULL, 'exclusive', 1, 500, 'AS0026', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:35:51', '2018-01-06 06:38:55'),
(27, 'Butter Cookies', 1, 'single', 2, 12, 21, NULL, 1, 'exclusive', 1, 100, 'AS0027', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:43:16', '2018-01-06 06:43:16'),
(28, 'Barilla Pasta', 1, 'single', 2, 13, 21, NULL, 1, 'exclusive', 1, 50, 'AS0028', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:45:47', '2018-01-06 06:45:47'),
(29, 'Thin Spaghetti', 1, 'single', 2, 13, 21, NULL, NULL, 'exclusive', 1, 100, 'AS0029', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:46:53', '2018-01-06 06:46:53'),
(30, 'Lipton Black Tea Bags', 1, 'single', 2, 14, 21, NULL, 1, 'exclusive', 1, 50, 'AS0030', 'C128', NULL, NULL, 0, 1, '2018-01-06 06:48:59', '2018-01-06 06:48:59'),
(31, 'Dolocare 1g paracetol', 2, 'single', 4, 16, 27, NULL, NULL, 'exclusive', 1, 50, 'AP0031', 'C128', '24.00', 'months', 0, 4, '2018-04-10 10:06:29', '2018-04-10 10:06:29'),
(32, 'Lexin 500mg capsule', 2, 'single', 4, 16, 22, NULL, NULL, 'exclusive', 1, 30, 'AP0032', 'C128', '24.00', 'months', 0, 4, '2018-04-10 10:07:52', '2018-04-10 10:07:52'),
(33, 'Oflen-75', 2, 'single', 4, 15, 22, NULL, NULL, 'exclusive', 1, 30, 'AP0033', 'C128', '36.00', 'months', 0, 4, '2018-04-10 10:09:45', '2018-04-10 10:09:45'),
(34, 'Cistiben Forte', 2, 'single', 4, 16, 22, NULL, NULL, 'exclusive', 1, 25, 'AP0034', 'C128', '12.00', 'months', 0, 4, '2018-04-10 10:10:59', '2018-04-10 10:10:59'),
(35, 'Disflatyl drop 30ml', 2, 'single', 4, 17, 25, NULL, NULL, 'exclusive', 1, 20, 'AP0035', 'C128', '12.00', 'months', 0, 4, '2018-04-10 10:12:53', '2018-04-10 10:12:53'),
(36, 'Mycoheal 40', 2, 'single', 4, 17, 26, NULL, NULL, 'exclusive', 1, 30, 'AP0036', 'C128', '6.00', 'months', 0, 4, '2018-04-10 10:14:18', '2018-04-10 10:14:18'),
(37, 'Laboxyl', 2, 'single', 4, 16, 24, NULL, NULL, 'exclusive', 1, 20, 'AP0037', 'C128', '12.00', 'months', 0, 4, '2018-04-10 10:31:29', '2018-04-10 10:31:29'),
(38, 'Fertilex plus men', 2, 'single', 4, 15, 22, NULL, NULL, 'exclusive', 1, 30, 'AP0038', 'C128', '12.00', 'months', 0, 4, '2018-04-10 10:32:35', '2018-04-10 10:32:35'),
(39, 'vitamin E AIWA', 2, 'single', 4, 15, 22, NULL, NULL, 'exclusive', 1, 20, 'AP0039', 'C128', '12.00', 'months', 0, 4, '2018-04-10 10:33:26', '2018-04-10 10:33:26'),
(40, 'Glycerol 4g', 2, 'single', 4, 16, 22, NULL, NULL, 'exclusive', 1, 20, 'AP0040', 'C128', '12.00', 'months', 0, 4, '2018-04-10 10:34:32', '2018-04-10 10:34:49'),
(41, 'HP 15-AY020TU', 3, 'single', 5, 23, 30, NULL, NULL, 'inclusive', 1, 10, 'AE0041', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:08:27', '2018-04-10 11:08:27'),
(42, 'HP Pavilion 15-AU624TX', 3, 'single', 5, 23, NULL, NULL, NULL, 'exclusive', 1, 10, 'AE0042', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:15:52', '2018-04-10 11:51:21'),
(43, 'iPhone 6s plus', 3, 'single', 5, 20, 28, NULL, NULL, 'exclusive', 1, 20, 'AE0043', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:18:01', '2018-04-10 11:18:01'),
(44, 'Samsung J7 Pro', 3, 'single', 5, 18, 28, NULL, NULL, 'exclusive', 1, 20, 'AE0044', 'C128', NULL, NULL, 0, 5, '2018-04-10 11:19:10', '2018-04-10 11:19:10'),
(45, 'Samsung Galaxy S7 Edge', 3, 'single', 5, 18, 28, NULL, NULL, 'exclusive', 1, 20, 'AE0045', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:20:21', '2018-04-10 11:20:21'),
(46, 'LG G6 64 GB', 3, 'single', 5, 19, 28, NULL, NULL, 'exclusive', 1, 10, 'AE0046', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:22:04', '2018-04-10 11:22:04'),
(47, 'Panasonic TH-58D300DX', 3, 'single', 5, 22, 31, NULL, NULL, 'exclusive', 1, 20, 'AE0047', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:23:45', '2018-04-10 11:23:45'),
(48, 'Samsung 50MU6100', 3, 'single', 5, 18, NULL, NULL, NULL, 'exclusive', 1, 7, 'AE0048', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:24:42', '2018-04-10 11:52:07'),
(49, 'LG 55E7T', 3, 'single', 5, 19, 31, NULL, NULL, 'exclusive', 1, 5, 'AE0049', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:25:55', '2018-04-10 11:25:55'),
(50, 'SONY ILCE-6000L/B', 3, 'single', 5, 21, NULL, NULL, NULL, 'exclusive', 1, 10, 'AE0050', 'C128', NULL, NULL, 1, 5, '2018-04-10 11:34:32', '2018-04-10 11:34:32'),
(51, 'Oil and filter change', 4, 'single', 6, NULL, 34, NULL, NULL, 'exclusive', 0, 0, 'AS0051', 'C128', NULL, NULL, 0, 6, '2018-04-10 12:34:57', '2018-04-10 12:34:57'),
(52, 'Removal of wheels and brakes checked', 4, 'single', 6, NULL, 34, NULL, NULL, 'exclusive', 0, 0, 'AS0052', 'C128', NULL, NULL, 0, 6, '2018-04-10 12:35:55', '2018-04-10 12:35:55'),
(53, 'Full body wash', 4, 'single', 6, NULL, 34, NULL, NULL, 'exclusive', 0, 0, 'AS0053', 'C128', NULL, NULL, 0, 6, '2018-04-10 12:39:15', '2018-04-10 12:39:15'),
(54, 'Hair Cut', 4, 'single', 6, NULL, 35, NULL, NULL, 'exclusive', 0, 0, 'AS0054', 'C128', NULL, NULL, 0, 6, '2018-04-10 12:54:16', '2018-04-10 12:54:16'),
(55, 'Wash And Blow Dry', 4, 'single', 6, NULL, 35, NULL, NULL, 'exclusive', 0, 0, 'AS0055', 'C128', NULL, NULL, 0, 6, '2018-04-10 12:56:18', '2018-04-10 12:56:18'),
(56, 'Thai massage', 4, 'single', 6, NULL, 38, NULL, NULL, 'exclusive', 0, 0, 'AS0056', 'C128', NULL, NULL, 0, 6, '2018-04-10 13:01:59', '2018-04-10 13:01:59'),
(57, 'Toilet Repair', 4, 'single', 6, NULL, 36, NULL, NULL, 'exclusive', 0, 0, 'AS0057', 'C128', NULL, NULL, 0, 6, '2018-04-10 13:03:01', '2018-04-10 13:03:01'),
(58, 'Sewer Repair', 4, 'single', 6, NULL, 36, NULL, NULL, 'exclusive', 0, 0, 'AS0058', 'C128', NULL, NULL, 0, 6, '2018-04-10 13:03:37', '2018-04-10 13:03:37'),
(59, 'Refrigerator Repair', 4, 'single', 6, NULL, NULL, NULL, NULL, 'exclusive', 0, 0, 'AS0059', 'C128', NULL, NULL, 0, 6, '2018-04-10 13:06:45', '2018-04-10 13:06:45'),
(60, 'AC Repair', 4, 'single', 6, NULL, NULL, NULL, NULL, 'exclusive', 0, 0, 'AS0060', 'C128', NULL, NULL, 0, 6, '2018-04-10 13:07:08', '2018-04-10 13:07:08')");

        DB::insert("INSERT INTO product_variations (id, name, product_id, is_dummy, created_at, updated_at) VALUES
					(1, 'DUMMY', 1, 1, '2018-01-03 21:29:08', '2018-01-03 21:29:08'),
(2, 'Waist Size', 2, 0, '2018-01-03 21:30:35', '2018-01-06 05:14:12'),
(3, 'Size', 3, 0, '2018-01-03 22:51:52', '2018-01-06 05:13:48'),
(4, 'Size', 4, 0, '2018-01-03 22:54:34', '2018-01-06 05:19:36'),
(8, 'Size', 8, 0, '2018-01-03 23:10:10', '2018-01-06 05:18:46'),
(9, 'Size', 9, 0, '2018-01-03 23:11:57', '2018-01-06 05:20:01'),
(10, 'Size', 10, 0, '2018-01-03 23:13:02', '2018-01-06 05:19:20'),
(11, 'DUMMY', 11, 1, '2018-01-03 23:14:35', '2018-01-03 23:14:35'),
(12, 'DUMMY', 12, 1, '2018-01-03 23:15:50', '2018-01-03 23:15:50'),
(13, 'Size', 13, 0, '2018-01-03 23:17:59', '2018-01-06 05:14:48'),
(14, 'Color', 14, 0, '2018-01-06 05:42:19', '2018-01-06 05:42:19'),
(15, 'Internal Memory', 14, 0, '2018-01-06 05:44:14', '2018-01-06 05:44:14'),
(16, 'Color', 15, 0, '2018-01-06 05:49:51', '2018-01-06 05:49:51'),
(17, 'Internal Memory', 15, 0, '2018-01-06 05:49:51', '2018-01-06 05:49:51'),
(18, 'Color', 16, 0, '2018-01-06 05:54:48', '2018-01-06 05:54:48'),
(19, 'Color', 17, 0, '2018-01-06 06:05:01', '2018-01-06 06:05:01'),
(20, 'Storage', 18, 0, '2018-01-06 06:07:30', '2018-01-06 06:07:30'),
(21, 'DUMMY', 19, 1, '2018-01-06 06:10:28', '2018-01-06 06:10:28'),
(22, 'Color', 20, 0, '2018-01-06 06:13:00', '2018-01-06 06:13:00'),
(23, 'DUMMY', 21, 1, '2018-01-06 06:16:35', '2018-01-06 06:16:35'),
(24, 'DUMMY', 22, 1, '2018-01-06 06:25:09', '2018-01-06 06:25:09'),
(25, 'DUMMY', 23, 1, '2018-01-06 06:26:27', '2018-01-06 06:26:27'),
(26, 'DUMMY', 24, 1, '2018-01-06 06:31:22', '2018-01-06 06:31:22'),
(27, 'DUMMY', 25, 1, '2018-01-06 06:32:23', '2018-01-06 06:32:23'),
(28, 'DUMMY', 26, 1, '2018-01-06 06:35:51', '2018-01-06 06:35:51'),
(29, 'DUMMY', 27, 1, '2018-01-06 06:43:16', '2018-01-06 06:43:16'),
(30, 'DUMMY', 28, 1, '2018-01-06 06:45:47', '2018-01-06 06:45:47'),
(31, 'DUMMY', 29, 1, '2018-01-06 06:46:53', '2018-01-06 06:46:53'),
(32, 'DUMMY', 30, 1, '2018-01-06 06:48:59', '2018-01-06 06:48:59'),
(33, 'DUMMY', 31, 1, '2018-04-10 10:06:29', '2018-04-10 10:06:29'),
(34, 'DUMMY', 32, 1, '2018-04-10 10:07:52', '2018-04-10 10:07:52'),
(35, 'DUMMY', 33, 1, '2018-04-10 10:09:45', '2018-04-10 10:09:45'),
(36, 'DUMMY', 34, 1, '2018-04-10 10:10:59', '2018-04-10 10:10:59'),
(37, 'DUMMY', 35, 1, '2018-04-10 10:12:53', '2018-04-10 10:12:53'),
(38, 'DUMMY', 36, 1, '2018-04-10 10:14:18', '2018-04-10 10:14:18'),
(39, 'DUMMY', 37, 1, '2018-04-10 10:31:29', '2018-04-10 10:31:29'),
(40, 'DUMMY', 38, 1, '2018-04-10 10:32:35', '2018-04-10 10:32:35'),
(41, 'DUMMY', 39, 1, '2018-04-10 10:33:26', '2018-04-10 10:33:26'),
(42, 'DUMMY', 40, 1, '2018-04-10 10:34:32', '2018-04-10 10:34:32'),
(43, 'DUMMY', 41, 1, '2018-04-10 11:08:27', '2018-04-10 11:08:27'),
(44, 'DUMMY', 42, 1, '2018-04-10 11:15:52', '2018-04-10 11:15:52'),
(45, 'DUMMY', 43, 1, '2018-04-10 11:18:01', '2018-04-10 11:18:01'),
(46, 'DUMMY', 44, 1, '2018-04-10 11:19:10', '2018-04-10 11:19:10'),
(47, 'DUMMY', 45, 1, '2018-04-10 11:20:22', '2018-04-10 11:20:22'),
(48, 'DUMMY', 46, 1, '2018-04-10 11:22:04', '2018-04-10 11:22:04'),
(49, 'DUMMY', 47, 1, '2018-04-10 11:23:45', '2018-04-10 11:23:45'),
(50, 'DUMMY', 48, 1, '2018-04-10 11:24:42', '2018-04-10 11:24:42'),
(51, 'DUMMY', 49, 1, '2018-04-10 11:25:55', '2018-04-10 11:25:55'),
(52, 'DUMMY', 50, 1, '2018-04-10 11:34:32', '2018-04-10 11:34:32'),
(53, 'DUMMY', 51, 1, '2018-04-10 12:34:57', '2018-04-10 12:34:57'),
(54, 'DUMMY', 52, 1, '2018-04-10 12:35:55', '2018-04-10 12:35:55'),
(55, 'DUMMY', 53, 1, '2018-04-10 12:39:15', '2018-04-10 12:39:15'),
(56, 'DUMMY', 54, 1, '2018-04-10 12:54:16', '2018-04-10 12:54:16'),
(57, 'DUMMY', 55, 1, '2018-04-10 12:56:18', '2018-04-10 12:56:18'),
(58, 'DUMMY', 56, 1, '2018-04-10 13:01:59', '2018-04-10 13:01:59'),
(59, 'DUMMY', 57, 1, '2018-04-10 13:03:01', '2018-04-10 13:03:01'),
(60, 'DUMMY', 58, 1, '2018-04-10 13:03:37', '2018-04-10 13:03:37'),
(61, 'DUMMY', 59, 1, '2018-04-10 13:06:45', '2018-04-10 13:06:45'),
(62, 'DUMMY', 60, 1, '2018-04-10 13:07:08', '2018-04-10 13:07:08')");

        DB::insert("INSERT INTO variations (id, name, product_id, sub_sku, product_variation_id, default_purchase_price, dpp_inc_tax, profit_percent, default_sell_price, sell_price_inc_tax, created_at, updated_at, deleted_at) VALUES
			(1, 'DUMMY', 1, 'AS0001', 1, '130.00', '143.00', '0.00', '130.00', '143.00', '2018-01-03 21:29:08', '2018-01-03 21:29:08', NULL),
(2, '28', 2, 'AS0002-1', 2, '70.00', '77.00', '0.00', '70.00', '77.00', '2018-01-03 21:30:35', '2018-01-06 05:51:16', NULL),
(3, '30', 2, 'AS0002-2', 2, '70.00', '77.00', '0.00', '70.00', '77.00', '2018-01-03 21:30:35', '2018-01-06 05:51:16', NULL),
(4, '32', 2, 'AS0002-3', 2, '70.00', '77.00', '0.00', '70.00', '77.00', '2018-01-03 21:30:35', '2018-01-06 05:51:16', NULL),
(5, '34', 2, 'AS0002-4', 2, '72.00', '79.20', '0.00', '72.00', '79.20', '2018-01-03 21:30:35', '2018-01-06 05:51:16', NULL),
(6, '36', 2, 'AS0002-5', 2, '72.00', '79.20', '0.00', '72.00', '79.20', '2018-01-03 21:30:35', '2018-01-06 05:51:16', NULL),
(7, 'S', 3, 'AS0003-1', 3, '190.00', '209.00', '0.00', '190.00', '209.00', '2018-01-03 22:51:52', '2018-01-06 05:50:51', NULL),
(8, 'M', 3, 'AS0003-2', 3, '190.00', '209.00', '0.00', '190.00', '209.00', '2018-01-03 22:51:52', '2018-01-06 05:50:51', NULL),
(9, 'L', 3, 'AS0003-3', 3, '190.00', '209.00', '0.00', '190.00', '209.00', '2018-01-03 22:51:52', '2018-01-06 05:50:51', NULL),
(10, 'XL', 3, 'AS0003-4', 3, '191.00', '210.10', '0.00', '191.00', '210.10', '2018-01-03 22:51:52', '2018-01-06 05:50:51', NULL),
(11, '6', 4, 'AS0004-1', 4, '165.00', '181.50', '0.00', '165.00', '181.50', '2018-01-03 22:54:34', '2018-01-06 05:19:36', NULL),
(12, '7', 4, 'AS0004-2', 4, '165.00', '181.50', '0.00', '165.00', '181.50', '2018-01-03 22:54:34', '2018-01-06 05:19:36', NULL),
(13, '8', 4, 'AS0004-3', 4, '165.00', '181.50', '0.00', '165.00', '181.50', '2018-01-03 22:54:34', '2018-01-06 05:19:36', NULL),
(14, '9', 4, 'AS0004-4', 4, '166.00', '182.60', '0.00', '166.00', '182.60', '2018-01-03 22:54:34', '2018-01-06 05:19:36', NULL),
(27, '6', 8, 'AS0008-1', 8, '110.00', '121.00', '0.00', '110.00', '121.00', '2018-01-03 23:10:10', '2018-01-06 05:18:46', NULL),
(28, '7', 8, 'AS0008-2', 8, '110.00', '121.00', '0.00', '110.00', '121.00', '2018-01-03 23:10:10', '2018-01-06 05:18:46', NULL),
(29, '8', 8, 'AS0008-3', 8, '110.00', '121.00', '0.00', '110.00', '121.00', '2018-01-03 23:10:10', '2018-01-06 05:18:46', NULL),
(30, '9', 8, 'AS0008-4', 8, '110.00', '121.00', '0.00', '110.00', '121.00', '2018-01-03 23:10:10', '2018-01-06 05:18:46', NULL),
(31, '6', 9, 'AS0009-1', 9, '135.00', '148.50', '0.00', '135.00', '148.50', '2018-01-03 23:11:57', '2018-01-06 05:20:01', NULL),
(32, '7', 9, 'AS0009-2', 9, '135.00', '148.50', '0.00', '135.00', '148.50', '2018-01-03 23:11:57', '2018-01-06 05:20:01', NULL),
(33, '8', 9, 'AS0009-3', 9, '135.00', '148.50', '0.00', '135.00', '148.50', '2018-01-03 23:11:57', '2018-01-06 05:20:01', NULL),
(34, '9', 9, 'AS0009-4', 9, '135.00', '148.50', '0.00', '135.00', '148.50', '2018-01-03 23:11:57', '2018-01-06 05:20:01', NULL),
(35, '5', 10, 'AS0010-1', 10, '150.00', '165.00', '0.00', '150.00', '165.00', '2018-01-03 23:13:02', '2018-01-06 05:19:20', NULL),
(36, '6', 10, 'AS0010-2', 10, '150.00', '165.00', '0.00', '150.00', '165.00', '2018-01-03 23:13:02', '2018-01-06 05:19:20', NULL),
(37, '7', 10, 'AS0010-3', 10, '150.00', '165.00', '0.00', '150.00', '165.00', '2018-01-03 23:13:02', '2018-01-06 05:19:20', NULL),
(38, '8', 10, 'AS0010-4', 10, '150.00', '165.00', '0.00', '150.00', '165.00', '2018-01-03 23:13:02', '2018-01-06 05:19:20', NULL),
(39, '9', 10, 'AS0010-5', 10, '150.00', '165.00', '0.00', '150.00', '165.00', '2018-01-03 23:13:02', '2018-01-06 05:19:20', NULL),
(40, 'DUMMY', 11, 'AS0011', 11, '30.00', '33.00', '0.00', '30.00', '33.00', '2018-01-03 23:14:35', '2018-01-03 23:14:35', NULL),
(41, 'DUMMY', 12, 'AS0012', 12, '25.00', '27.50', '0.00', '25.00', '27.50', '2018-01-03 23:15:50', '2018-01-03 23:15:50', NULL),
(42, 'M', 13, 'AS0013-1', 13, '60.00', '66.00', '0.00', '60.00', '66.00', '2018-01-03 23:17:59', '2018-01-06 05:14:48', NULL),
(43, 'L', 13, 'AS0013-2', 13, '60.00', '66.00', '0.00', '60.00', '66.00', '2018-01-03 23:17:59', '2018-01-06 05:14:48', NULL),
(44, 'XL', 13, 'AS0013-3', 13, '60.00', '66.00', '0.00', '60.00', '66.00', '2018-01-03 23:17:59', '2018-01-06 05:14:48', NULL),
(45, 'Gray', 14, 'AS0014-1', 14, '700.00', '770.00', '25.00', '875.00', '962.50', '2018-01-06 05:42:19', '2018-01-06 05:44:14', NULL),
(46, 'Black', 14, 'AS0014-2', 14, '700.00', '770.00', '25.00', '875.00', '962.50', '2018-01-06 05:42:19', '2018-01-06 05:44:14', NULL),
(47, '64 GB', 14, 'AS0014-1', 15, '700.00', '770.00', '25.00', '875.00', '962.50', '2018-01-06 05:44:14', '2018-01-06 05:44:14', NULL),
(48, '128 GB', 14, 'AS0014-2', 15, '800.00', '880.00', '25.00', '1000.00', '1100.00', '2018-01-06 05:44:14', '2018-01-06 05:44:14', NULL),
(49, 'White', 15, 'AS0015-1', 16, '950.00', '1045.00', '25.00', '1187.50', '1306.25', '2018-01-06 05:49:51', '2018-01-06 05:49:51', NULL),
(50, 'Gray', 15, 'AS0015-2', 16, '950.00', '1045.00', '25.00', '1187.50', '1306.25', '2018-01-06 05:49:51', '2018-01-06 05:49:51', NULL),
(51, 'Black', 15, 'AS0015-3', 16, '950.00', '1045.00', '25.00', '1187.50', '1306.25', '2018-01-06 05:49:51', '2018-01-06 05:49:51', NULL),
(52, '32 GB', 15, 'AS0015-1', 17, '950.00', '1045.00', '25.00', '1187.50', '1306.25', '2018-01-06 05:49:51', '2018-01-06 05:49:51', NULL),
(53, '64 GB', 15, 'AS0015-2', 17, '1010.00', '1111.00', '25.00', '1262.50', '1388.75', '2018-01-06 05:49:51', '2018-01-06 05:49:51', NULL),
(54, 'Gold', 16, 'AS0016-1', 18, '350.00', '350.00', '25.00', '437.50', '437.50', '2018-01-06 05:54:48', '2018-01-06 05:54:48', NULL),
(55, 'White', 16, 'AS0016-2', 18, '350.00', '350.00', '25.00', '437.50', '437.50', '2018-01-06 05:54:48', '2018-01-06 05:54:48', NULL),
(56, 'Black', 16, 'AS0016-3', 18, '350.00', '350.00', '25.00', '437.50', '437.50', '2018-01-06 05:54:48', '2018-01-06 05:54:48', NULL),
(57, 'Black', 17, 'AS0017-1', 19, '350.00', '350.00', '25.00', '437.50', '437.50', '2018-01-06 06:05:01', '2018-01-06 06:05:01', NULL),
(58, 'White', 17, 'AS0017-2', 19, '350.00', '350.00', '25.00', '437.50', '437.50', '2018-01-06 06:05:01', '2018-01-06 06:05:01', NULL),
(59, '256 GB', 18, 'AS0018-1', 20, '1350.00', '1350.00', '25.00', '1687.50', '1687.50', '2018-01-06 06:07:30', '2018-01-06 06:07:30', NULL),
(60, '500 GB', 18, 'AS0018-2', 20, '1450.00', '1450.00', '25.00', '1812.50', '1812.50', '2018-01-06 06:07:30', '2018-01-06 06:07:30', NULL),
(61, 'DUMMY', 19, 'AS0019', 21, '8.00', '8.00', '25.00', '10.00', '10.00', '2018-01-06 06:10:28', '2018-01-06 06:10:28', NULL),
(62, 'Gray', 20, 'AS0020-1', 22, '25.00', '27.50', '25.00', '31.25', '34.38', '2018-01-06 06:13:00', '2018-01-06 06:13:00', NULL),
(63, 'Black', 20, 'AS0020-2', 22, '25.00', '27.50', '25.00', '31.25', '34.38', '2018-01-06 06:13:00', '2018-01-06 06:13:00', NULL),
(64, 'DUMMY', 21, 'AS0021', 23, '10.00', '10.00', '25.00', '12.50', '12.50', '2018-01-06 06:16:35', '2018-01-06 06:16:35', NULL),
(65, 'DUMMY', 22, 'AS0022', 24, '8.00', '8.80', '25.00', '10.00', '11.00', '2018-01-06 06:25:09', '2018-01-06 06:25:09', NULL),
(66, 'DUMMY', 23, 'AS0023', 25, '10.00', '10.00', '25.00', '12.50', '12.50', '2018-01-06 06:26:27', '2018-01-06 06:26:27', NULL),
(67, 'DUMMY', 24, 'AS0024', 26, '8.00', '8.80', '25.00', '10.00', '11.00', '2018-01-06 06:31:22', '2018-01-06 06:31:22', NULL),
(68, 'DUMMY', 25, 'AS0025', 27, '15.00', '15.00', '25.00', '18.75', '18.75', '2018-01-06 06:32:23', '2018-01-06 06:32:23', NULL),
(69, 'DUMMY', 26, 'AS0026', 28, '5.00', '5.00', '25.00', '6.25', '6.25', '2018-01-06 06:35:51', '2018-01-06 06:35:51', NULL),
(70, 'DUMMY', 27, 'AS0027', 29, '20.00', '22.00', '25.00', '25.00', '27.50', '2018-01-06 06:43:16', '2018-01-06 06:43:16', NULL),
(71, 'DUMMY', 28, 'AS0028', 30, '10.00', '11.00', '25.00', '12.50', '13.75', '2018-01-06 06:45:47', '2018-01-06 06:45:47', NULL),
(72, 'DUMMY', 29, 'AS0029', 31, '12.00', '12.00', '25.00', '15.00', '15.00', '2018-01-06 06:46:53', '2018-01-06 06:46:53', NULL),
(73, 'DUMMY', 30, 'AS0030', 32, '40.00', '44.00', '25.00', '50.00', '55.00', '2018-01-06 06:48:59', '2018-01-06 06:48:59', NULL),
(74, 'DUMMY', 31, 'AP0031', 33, '7.00', '7.00', '25.00', '8.75', '8.75', '2018-04-10 10:06:29', '2018-04-10 10:06:29', NULL),
(75, 'DUMMY', 32, 'AP0032', 34, '12.00', '12.00', '25.00', '15.00', '15.00', '2018-04-10 10:07:52', '2018-04-10 10:07:52', NULL),
(76, 'DUMMY', 33, 'AP0033', 35, '12.00', '12.00', '25.00', '15.00', '15.00', '2018-04-10 10:09:45', '2018-04-10 10:09:45', NULL),
(77, 'DUMMY', 34, 'AP0034', 36, '6.00', '6.00', '25.00', '7.50', '7.50', '2018-04-10 10:10:59', '2018-04-10 10:10:59', NULL),
(78, 'DUMMY', 35, 'AP0035', 37, '7.00', '7.00', '25.00', '8.75', '8.75', '2018-04-10 10:12:53', '2018-04-10 10:12:53', NULL),
(79, 'DUMMY', 36, 'AP0036', 38, '9.00', '9.00', '25.00', '11.25', '11.25', '2018-04-10 10:14:18', '2018-04-10 10:14:18', NULL),
(80, 'DUMMY', 37, 'AP0037', 39, '12.00', '12.00', '25.00', '15.00', '15.00', '2018-04-10 10:31:29', '2018-04-10 10:31:29', NULL),
(81, 'DUMMY', 38, 'AP0038', 40, '15.00', '15.00', '25.00', '18.75', '18.75', '2018-04-10 10:32:35', '2018-04-10 10:32:35', NULL),
(82, 'DUMMY', 39, 'AP0039', 41, '12.00', '12.00', '25.00', '15.00', '15.00', '2018-04-10 10:33:26', '2018-04-10 10:33:26', NULL),
(83, 'DUMMY', 40, 'AP0040', 42, '8.00', '8.00', '25.00', '10.00', '10.00', '2018-04-10 10:34:32', '2018-04-10 10:34:49', NULL),
(84, 'DUMMY', 41, 'AE0041', 43, '500.00', '500.00', '25.00', '625.00', '625.00', '2018-04-10 11:08:27', '2018-04-10 11:08:27', NULL),
(85, 'DUMMY', 42, 'AE0042', 44, '520.00', '520.00', '25.00', '650.00', '650.00', '2018-04-10 11:15:52', '2018-04-10 11:51:21', NULL),
(86, 'DUMMY', 43, 'AE0043', 45, '400.00', '400.00', '25.00', '500.00', '500.00', '2018-04-10 11:18:01', '2018-04-10 11:18:01', NULL),
(87, 'DUMMY', 44, 'AE0044', 46, '195.00', '195.00', '25.00', '243.75', '243.75', '2018-04-10 11:19:10', '2018-04-10 11:19:10', NULL),
(88, 'DUMMY', 45, 'AE0045', 47, '300.00', '300.00', '25.00', '375.00', '375.00', '2018-04-10 11:20:22', '2018-04-10 11:20:22', NULL),
(89, 'DUMMY', 46, 'AE0046', 48, '321.00', '321.00', '25.00', '401.25', '401.25', '2018-04-10 11:22:04', '2018-04-10 11:22:04', NULL),
(90, 'DUMMY', 47, 'AE0047', 49, '255.00', '255.00', '25.00', '318.75', '318.75', '2018-04-10 11:23:45', '2018-04-10 11:23:45', NULL),
(91, 'DUMMY', 48, 'AE0048', 50, '850.00', '850.00', '25.00', '1062.50', '1062.50', '2018-04-10 11:24:42', '2018-04-10 11:52:07', NULL),
(92, 'DUMMY', 49, 'AE0049', 51, '1500.00', '1500.00', '25.00', '1875.00', '1875.00', '2018-04-10 11:25:55', '2018-04-10 11:25:55', NULL),
(93, 'DUMMY', 50, 'AE0050', 52, '630.00', '630.00', '25.00', '787.50', '787.50', '2018-04-10 11:34:32', '2018-04-10 11:34:32', NULL),
(94, 'DUMMY', 51, 'AS0051', 53, '100.00', '100.00', '25.00', '125.00', '125.00', '2018-04-10 12:34:57', '2018-04-10 12:34:57', NULL),
(95, 'DUMMY', 52, 'AS0052', 54, '80.00', '80.00', '25.00', '100.00', '100.00', '2018-04-10 12:35:55', '2018-04-10 12:35:55', NULL),
(96, 'DUMMY', 53, 'AS0053', 55, '105.00', '105.00', '25.00', '131.25', '131.25', '2018-04-10 12:39:15', '2018-04-10 12:39:15', NULL),
(97, 'DUMMY', 54, 'AS0054', 56, '10.00', '10.00', '25.00', '12.50', '12.50', '2018-04-10 12:54:16', '2018-04-10 12:54:16', NULL),
(98, 'DUMMY', 55, 'AS0055', 57, '8.00', '8.00', '25.00', '10.00', '10.00', '2018-04-10 12:56:18', '2018-04-10 12:56:18', NULL),
(99, 'DUMMY', 56, 'AS0056', 58, '150.00', '150.00', '25.00', '187.50', '187.50', '2018-04-10 13:01:59', '2018-04-10 13:01:59', NULL),
(100, 'DUMMY', 57, 'AS0057', 59, '20.00', '20.00', '25.00', '25.00', '25.00', '2018-04-10 13:03:01', '2018-04-10 13:03:01', NULL),
(101, 'DUMMY', 58, 'AS0058', 60, '20.00', '20.00', '25.00', '25.00', '25.00', '2018-04-10 13:03:37', '2018-04-10 13:03:37', NULL),
(102, 'DUMMY', 59, 'AS0059', 61, '15.00', '15.00', '25.00', '18.75', '18.75', '2018-04-10 13:06:45', '2018-04-10 13:06:45', NULL),
(103, 'DUMMY', 60, 'AS0060', 62, '15.00', '15.00', '25.00', '18.75', '18.75', '2018-04-10 13:07:08', '2018-04-10 13:07:08', NULL)");

        DB::insert("INSERT INTO variation_templates (id, name, business_id, 
        			created_at, updated_at) VALUES
					(1, 'Size (Tshirts)', 1, '2018-01-04 02:52:13', '2018-01-04 02:52:13'),
					(2, 'Size (Shoes)', 1, '2018-01-04 02:53:21', '2018-01-04 02:53:21'),
					(3, 'Waist Size (Jeans)', 1, '2018-01-04 02:54:34', '2018-01-04 02:54:34'),
					(4, 'Color', 1, '2018-01-06 12:42:52', '2018-01-06 12:42:52')");

        DB::insert("INSERT INTO variation_value_templates (id, name, variation_template_id, 
        			created_at, updated_at) VALUES
					(1, 'S', 1, '2018-01-04 02:52:13', '2018-01-04 02:52:13'),
					(2, 'M', 1, '2018-01-04 02:52:13', '2018-01-04 02:52:13'),
					(3, 'L', 1, '2018-01-04 02:52:13', '2018-01-04 02:52:13'),
					(4, 'XL', 1, '2018-01-04 02:52:13', '2018-01-04 02:52:13'),
					(5, '5', 2, '2018-01-04 02:53:21', '2018-01-04 02:53:21'),
					(6, '6', 2, '2018-01-04 02:53:21', '2018-01-04 02:53:21'),
					(7, '7', 2, '2018-01-04 02:53:21', '2018-01-04 02:53:21'),
					(8, '8', 2, '2018-01-04 02:53:21', '2018-01-04 02:53:21'),
					(9, '9', 2, '2018-01-04 02:53:21', '2018-01-04 02:53:21'),
					(10, '28', 3, '2018-01-04 02:54:34', '2018-01-04 02:54:34'),
					(11, '30', 3, '2018-01-04 02:54:34', '2018-01-04 02:54:34'),
					(12, '32', 3, '2018-01-04 02:54:34', '2018-01-04 02:54:34'),
					(13, '34', 3, '2018-01-04 02:54:35', '2018-01-04 02:54:35'),
					(14, '36', 3, '2018-01-04 02:54:35', '2018-01-04 02:54:35'),
					(16, 'Black', 4, '2018-01-06 12:43:17', '2018-01-06 12:43:17'),
					(17, 'Blue', 4, '2018-01-06 12:43:17', '2018-01-06 12:43:17'),
					(18, 'Brown', 4, '2018-01-06 12:43:17', '2018-01-06 12:43:17'),
					(19, 'Grey', 4, '2018-01-06 12:43:17', '2018-01-06 12:43:17'),
					(20, 'Gold', 4, '2018-01-06 12:43:17', '2018-01-06 12:43:17')");

        DB::insert("INSERT INTO purchase_lines (id, transaction_id, product_id, variation_id, quantity, pp_without_discount, discount_percent, purchase_price, purchase_price_inc_tax, item_tax, tax_id, quantity_sold, quantity_adjusted, mfg_date, exp_date, created_at, updated_at) VALUES
					(1, 1, 2, 2, 100, '70.00', '0.00', '70.00', '77.00', '7.00', 1, '50.00', '0.00', NULL, NULL, '2018-01-06 06:57:11', '2018-04-10 07:53:25'),
(2, 1, 2, 3, 150, '70.00', '0.00', '70.00', '77.00', '7.00', 1, '60.00', '0.00', NULL, NULL, '2018-01-06 06:57:11', '2018-04-10 07:53:25'),
(3, 1, 2, 4, 150, '70.00', '0.00', '70.00', '77.00', '7.00', 1, '0.00', '0.00', NULL, NULL, '2018-01-06 06:57:11', '2018-04-10 07:53:24'),
(4, 1, 2, 5, 150, '72.00', '0.00', '72.00', '79.20', '7.20', 1, '0.00', '0.00', NULL, NULL, '2018-01-06 06:57:11', '2018-04-10 07:53:24'),
(5, 1, 2, 6, 100, '72.00', '0.00', '72.00', '79.20', '7.20', 1, '0.00', '0.00', NULL, NULL, '2018-01-06 06:57:11', '2018-04-10 07:53:24'),
(6, 2, 14, 47, 100, '700.00', '0.00', '700.00', '770.00', '70.00', 1, '0.00', '0.00', NULL, NULL, '2018-01-06 06:58:10', '2018-04-10 07:53:24'),
(7, 3, 28, 71, 500, '10.00', '0.00', '10.00', '11.00', '1.00', 1, '30.00', '0.00', NULL, NULL, '2018-01-06 07:02:22', '2018-04-10 07:53:25'),
(8, 4, 21, 64, 200, '10.00', '0.00', '10.00', '10.00', '0.00', NULL, '60.00', '0.00', NULL, NULL, '2018-01-06 07:03:12', '2018-04-10 07:53:25'),
(9, 5, 27, 70, 500, '20.00', '0.00', '20.00', '22.00', '2.00', 1, '30.00', '0.00', NULL, NULL, '2018-01-06 07:05:26', '2018-04-10 07:53:24'),
(10, 11, 34, 77, 50, '6.00', '0.00', '6.00', '6.00', '0.00', NULL, '44.00', '0.00', '2018-04-10', 
	'$next_12_month', '2018-04-10 10:18:16', '2018-04-10 10:24:21'),
(11, 12, 32, 75, 100, '12.00', '0.00', '12.00', '12.00', '0.00', NULL, '0.00', '0.00', '2018-04-12', '$next_6_month', '2018-04-10 10:19:40', '2018-04-10 10:19:40'),
(12, 13, 36, 79, 150, '9.00', '0.00', '9.00', '9.00', '0.00', NULL, '0.00', '0.00', '2018-03-30', 
	'$next_12_month', '2018-04-10 10:20:41', '2018-04-10 10:20:41'),
(13, 14, 33, 76, 180, '12.00', '0.00', '12.00', '12.00', '0.00', NULL, '0.00', '0.00', '2018-04-10', '$yesterday', '2018-04-10 10:21:38', '2018-04-10 10:21:38'),
(14, 18, 46, 89, 30, '321.00', '0.00', '321.00', '321.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '2018-04-10 11:39:54', '2018-04-10 11:39:54'),
(15, 19, 41, 84, 40, '500.00', '0.00', '500.00', '500.00', '0.00', NULL, '26.00', '0.00', NULL, NULL, '2018-04-10 11:40:51', '2018-04-10 11:48:48'),
(16, 20, 45, 88, 45, '300.00', '0.00', '300.00', '300.00', '0.00', NULL, '0.00', '0.00', NULL, NULL, '2018-04-10 11:41:45', '2018-04-10 11:41:45'),
(17, 21, 44, 87, 100, '195.00', '0.00', '195.00', '195.00', '0.00', NULL, '20.00', '0.00', NULL, NULL, '2018-04-10 11:42:34', '2018-04-10 11:45:06'),
(18, 22, 43, 86, 30, '400.00', '0.00', '400.00', '400.00', '0.00', NULL, '5.00', '0.00', NULL, NULL, '2018-04-10 11:43:12', '2018-04-10 11:44:47'),
(19, 27, 42, 85, 50, '520.00', '0.00', '520.00', '520.00', '0.00', NULL, '20.00', '0.00', NULL, NULL, '2018-04-10 11:53:36', '2018-04-10 11:54:16')");
        DB::insert("INSERT INTO transactions (id, business_id, location_id, type, status, payment_status, adjustment_type, contact_id, customer_group_id, invoice_no, ref_no, transaction_date, total_before_tax, tax_id, tax_amount, discount_type, discount_amount, shipping_details, shipping_charges, additional_notes, staff_note, final_total, expense_category_id, expense_for, commission_agent, document, is_direct_sale, exchange_rate, total_amount_recovered, transfer_parent_id, opening_stock_product_id, created_by, created_at, updated_at) VALUES
(1, 1, 1, 'purchase', 'received', 'paid', NULL, 2, NULL, NULL, '35001BCVX', '$last_15th_day', '50600.00', 1, '5060.00', NULL, '0', NULL, '0.00', NULL, NULL, '55660.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 06:57:11', '2018-01-06 06:57:11'),
(2, 1, 1, 'purchase', 'received', 'paid', NULL, 5, NULL, NULL, '35001BJGN', '$last_15th_day', '77000.00', 1, '7700.00', NULL, '0', NULL, '0.00', NULL, NULL, '84700.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 06:58:10', '2018-01-06 06:58:10'),
(3, 1, 1, 'purchase', 'received', 'partial', NULL, 6, NULL, NULL, '35001BCVJ', '$last_month', '5500.00', 1, '550.00', NULL, '0', NULL, '0.00', NULL, NULL, '6050.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:02:22', '2018-01-06 07:02:22'),
(4, 1, 1, 'purchase', 'received', 'paid', NULL, 6, NULL, NULL, '35001BCVK', '$last_month', '2000.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '2000.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:03:12', '2018-01-06 07:03:12'),
(5, 1, 1, 'purchase', 'received', 'due', NULL, 6, NULL, NULL, '35001BCVD', '$last_week', '11000.00', 1, '1100.00', NULL, '0', NULL, '0.00', NULL, NULL, '12100.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:05:26', '2018-01-06 07:05:26'),
(6, 1, 1, 'sell', 'final', 'paid', NULL, 4, NULL, 'AS0001', '', '2018-04-10 13:23:21', '770.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '770.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:06:11', '2018-01-06 07:06:11'),
(7, 1, 1, 'sell', 'final', 'paid', NULL, 1, NULL, 'AS0002', '', '$yesterday', '825.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '825.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:06:31', '2018-01-06 07:06:31'),
(8, 1, 1, 'sell', 'final', 'paid', NULL, 4, NULL, 'AS0003', '', '$yesterday', '7700.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '7700.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:07:22', '2018-01-06 07:07:22'),
(9, 1, 1, 'sell', 'final', 'paid', NULL, 1, NULL, 'AS0004', '', '$today', '750.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '750.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:07:45', '2018-01-06 07:07:45'),
(10, 1, 1, 'sell', 'final', 'paid', NULL, 1, NULL, 'AS0005', '', '$today', '412.50', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '412.50', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 1, '2018-01-06 07:08:03', '2018-01-06 07:08:03'),
(11, 2, 2, 'purchase', 'received', 'paid', NULL, 8, NULL, NULL, '56247065', '$last_week', '300.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '300.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:18:16', '2018-04-10 10:18:47'),
(12, 2, 2, 'purchase', 'received', 'paid', NULL, 9, NULL, NULL, '547887025', '$last_week', '1200.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '1200.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:19:40', '2018-04-10 10:19:49'),
(13, 2, 2, 'purchase', 'received', 'paid', NULL, 9, NULL, NULL, '45470025', '$last_month', '1350.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '1350.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:20:41', '2018-04-10 10:20:55'),
(14, 2, 2, 'purchase', 'received', 'partial', NULL, 9, NULL, NULL, '65589898', '$last_month', '2160.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '2160.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:21:38', '2018-04-10 10:22:10'),
(15, 2, 2, 'sell', 'final', 'paid', NULL, 7, NULL, '0001', '', '$yesterday', '75.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '75.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:23:35', '2018-04-10 10:23:35'),
(16, 2, 2, 'sell', 'final', 'paid', NULL, 7, NULL, '0002', '', '$yesterday', '105.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '105.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:23:58', '2018-04-10 10:23:58'),
(17, 2, 2, 'sell', 'final', 'paid', NULL, 7, NULL, '0003', '', '$today', '405.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '405.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 4, '2018-04-10 10:24:21', '2018-04-10 10:26:26'),
(18, 3, 3, 'purchase', 'received', 'paid', NULL, 11, NULL, NULL, '548471117', '$last_month', '9630.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '9630.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:39:54', '2018-04-10 11:40:02'),
(19, 3, 3, 'purchase', 'received', 'paid', NULL, 12, NULL, NULL, '548222220', '$last_week', '20000.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '20000.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:40:51', '2018-04-10 11:40:58'),
(20, 3, 3, 'purchase', 'received', 'paid', NULL, 12, NULL, NULL, '878445524', '$last_15th_day', '13500.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '13500.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:41:45', '2018-04-10 11:43:19'),
(21, 3, 3, 'purchase', 'received', 'paid', NULL, 12, NULL, NULL, '582500058', '$last_15th_day', '19500.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '19500.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:42:34', '2018-04-10 11:43:24'),
(22, 3, 3, 'purchase', 'received', 'partial', NULL, 11, NULL, NULL, '848485552', '$last_week', '12000.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '12000.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:43:12', '2018-04-10 11:43:35'),
(23, 3, 3, 'sell', 'final', 'paid', NULL, 10, NULL, 'AE0001', '', '$today', '2500.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '2500.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:44:47', '2018-04-10 11:47:10'),
(24, 3, 3, 'sell', 'final', 'paid', NULL, 10, NULL, 'AE0002', '', '$yesterday', '4875.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '4875.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:45:06', '2018-04-10 11:46:43'),
(25, 3, 3, 'sell', 'final', 'paid', NULL, 10, NULL, 'AE0003', '', '$yesterday', '625.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '625.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:46:02', '2018-04-10 11:46:02'),
(26, 3, 3, 'sell', 'final', 'paid', NULL, 10, NULL, 'AE0004', '', '$today', '15625.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '15625.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:48:48', '2018-04-10 11:48:48'),
(27, 3, 3, 'purchase', 'received', 'due', NULL, 12, NULL, NULL, '1545477882', '$last_15th_day', '26000.00', NULL, '0.00', NULL, '0', NULL, '0.00', NULL, NULL, '26000.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:53:36', '2018-04-10 11:53:36'),
(28, 3, 3, 'sell', 'final', 'paid', NULL, 10, NULL, 'AE0005', '', '$yesterday', '13000.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '13000.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 5, '2018-04-10 11:54:16', '2018-04-10 11:54:16'),
(29, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0001', '', '$today', '656.25', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '656.25', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:04:40', '2018-04-10 13:04:40'),
(30, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0002', '', '$yesterday', '250.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '250.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:04:54', '2018-04-10 13:04:54'),
(31, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0003', '', '$today', '75.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '75.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:05:19', '2018-04-10 13:05:19'),
(32, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0004', '', '$today', '37.50', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '37.50', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:07:50', '2018-04-10 13:07:50'),
(33, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0005', '', '$yesterday', '375.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '375.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:08:01', '2018-04-10 13:08:01'),
(34, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0006', '', '$yesterday', '250.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '250.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:08:15', '2018-04-10 13:08:15'),
(35, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0007', '', '$today', '100.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '100.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:08:27', '2018-04-10 13:08:27'),
(36, 4, 4, 'sell', 'final', 'paid', NULL, 13, NULL, '0008', '', '$yesterday', '125.00', NULL, '0.00', 'percentage', '0', NULL, '0.00', NULL, NULL, '125.00', NULL, NULL, NULL, NULL, 0, '1.000', NULL, NULL, NULL, 6, '2018-04-10 13:08:49', '2018-04-10 13:08:49')");

        DB::insert("INSERT INTO transaction_payments (id, transaction_id, amount, method, card_transaction_number, card_number, card_type, card_holder_name, card_month, card_year, card_security, cheque_number, bank_account_number, paid_on, created_by, payment_for, parent_id, note, created_at, updated_at) VALUES
					(1, 6, '770.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-09 17:30:35', 1, NULL, NULL, NULL, '2018-01-06 01:36:11', '2018-01-06 01:36:11'),
(2, 7, '825.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-09 17:30:35', 1, NULL, NULL, NULL, '2018-01-06 01:36:31', '2018-01-06 01:36:31'),
(3, 8, '7700.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-09 17:30:35', 1, NULL, NULL, NULL, '2018-01-06 01:37:23', '2018-01-06 01:37:23'),
(4, 9, '750.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-09 17:30:35', 1, NULL, NULL, NULL, '2018-01-06 01:37:45', '2018-01-06 01:37:45'),
(5, 10, '412.50', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-09 17:30:35', 1, NULL, NULL, NULL, '2018-01-06 01:38:03', '2018-01-06 01:38:03'),
(6, 4, '2000.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-11 17:32:56', 1, NULL, NULL, 'Cash Payment', '2018-01-11 06:32:56', '2018-01-11 06:32:56'),
(7, 3, '3000.00', 'bank_transfer', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, '502110000631', '2018-01-11 17:34:10', 1, NULL, NULL, '3000 Paid Via Bank Transfer', '2018-01-11 06:34:10', '2018-01-11 06:34:10'),
(8, 2, '84700.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-11 17:34:36', 1, NULL, NULL, NULL, '2018-01-11 06:34:36', '2018-01-11 06:34:36'),
(9, 1, '50000.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-11 17:35:04', 1, NULL, NULL, NULL, '2018-01-11 06:35:04', '2018-01-11 06:35:04'),
(10, 1, '5660.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-11 17:35:17', 1, NULL, NULL, NULL, '2018-01-11 06:35:17', '2018-01-11 06:35:17'),
(11, 11, '300.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:48:47', 4, 8, NULL, NULL, '2018-04-10 10:18:47', '2018-04-10 10:18:47'),
(12, 12, '1200.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:49:49', 4, 9, NULL, NULL, '2018-04-10 10:19:49', '2018-04-10 10:19:49'),
(13, 13, '1350.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:50:55', 4, 9, NULL, NULL, '2018-04-10 10:20:55', '2018-04-10 10:20:55'),
(14, 14, '1500.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:52:10', 4, 9, NULL, NULL, '2018-04-10 10:22:10', '2018-04-10 10:22:10'),
(15, 15, '75.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:53:35', 4, 7, NULL, NULL, '2018-04-10 10:23:35', '2018-04-10 10:23:35'),
(16, 16, '105.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:53:58', 4, 7, NULL, NULL, '2018-04-10 10:23:58', '2018-04-10 10:23:58'),
(17, 17, '405.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 15:54:21', 4, 7, NULL, NULL, '2018-04-10 10:24:21', '2018-04-10 10:26:26'),
(18, 18, '9630.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:10:02', 5, 11, NULL, NULL, '2018-04-10 11:40:02', '2018-04-10 11:40:02'),
(19, 19, '20000.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:10:58', 5, 12, NULL, NULL, '2018-04-10 11:40:58', '2018-04-10 11:40:58'),
(20, 20, '13500.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:13:19', 5, 12, NULL, NULL, '2018-04-10 11:43:19', '2018-04-10 11:43:19'),
(21, 21, '19500.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:13:24', 5, 12, NULL, NULL, '2018-04-10 11:43:24', '2018-04-10 11:43:24'),
(22, 22, '5000.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:13:35', 5, 11, NULL, NULL, '2018-04-10 11:43:35', '2018-04-10 11:43:35'),
(23, 23, '2500.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:14:47', 5, 10, NULL, NULL, '2018-04-10 11:44:47', '2018-04-10 11:47:10'),
(24, 24, '4875.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:15:06', 5, 10, NULL, NULL, '2018-04-10 11:45:06', '2018-04-10 11:46:43'),
(25, 25, '625.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:16:02', 5, 10, NULL, NULL, '2018-04-10 11:46:02', '2018-04-10 11:46:02'),
(26, 26, '15625.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:18:48', 5, 10, NULL, NULL, '2018-04-10 11:48:48', '2018-04-10 11:48:48'),
(27, 28, '13000.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 17:24:16', 5, 10, NULL, NULL, '2018-04-10 11:54:16', '2018-04-10 11:54:16'),
(28, 29, '656.25', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:34:40', 6, 13, NULL, NULL, '2018-04-10 13:04:40', '2018-04-10 13:04:40'),
(29, 30, '250.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:34:54', 6, 13, NULL, NULL, '2018-04-10 13:04:54', '2018-04-10 13:04:54'),
(30, 31, '75.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:35:19', 6, 13, NULL, NULL, '2018-04-10 13:05:19', '2018-04-10 13:05:19'),
(31, 32, '37.50', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:37:50', 6, 13, NULL, NULL, '2018-04-10 13:07:50', '2018-04-10 13:07:50'),
(32, 33, '375.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:38:01', 6, 13, NULL, NULL, '2018-04-10 13:08:01', '2018-04-10 13:08:01'),
(33, 34, '250.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:38:15', 6, 13, NULL, NULL, '2018-04-10 13:08:15', '2018-04-10 13:08:15'),
(34, 35, '100.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:38:27', 6, 13, NULL, NULL, '2018-04-10 13:08:27', '2018-04-10 13:08:27'),
(35, 36, '125.00', 'cash', NULL, NULL, 'visa', NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-10 18:38:49', 6, 13, NULL, NULL, '2018-04-10 13:08:49', '2018-04-10 13:08:49')");

        DB::insert("INSERT INTO transaction_sell_lines (id, transaction_id, product_id, variation_id, quantity, unit_price, unit_price_inc_tax, item_tax, tax_id, sell_line_note, created_at, updated_at) VALUES
					(1, 6, 2, 3, 10, '70.00', '77.00', '7.00', 1, NULL, '2018-01-06 07:06:11', '2018-01-06 07:06:11'),
(2, 7, 27, 70, 30, '25.00', '27.50', '2.50', 1, NULL, '2018-01-06 07:06:31', '2018-01-06 07:06:31'),
(3, 8, 2, 3, 50, '70.00', '77.00', '7.00', 1, NULL, '2018-01-06 07:07:23', '2018-01-06 07:07:23'),
(4, 8, 2, 2, 50, '70.00', '77.00', '7.00', 1, NULL, '2018-01-06 07:07:23', '2018-01-06 07:07:23'),
(5, 9, 21, 64, 60, '12.50', '12.50', '0.00', NULL, NULL, '2018-01-06 07:07:45', '2018-01-06 07:07:45'),
(6, 10, 28, 71, 30, '12.50', '13.75', '1.25', 1, NULL, '2018-01-06 07:08:03', '2018-01-06 07:08:03'),
(7, 15, 34, 77, 10, '7.50', '7.50', '0.00', NULL, '', '2018-04-10 10:23:35', '2018-04-10 10:23:35'),
(8, 16, 32, 75, 7, '15.00', '15.00', '0.00', NULL, '', '2018-04-10 10:23:58', '2018-04-10 10:23:58'),
(9, 17, 33, 76, 27, '15.00', '15.00', '0.00', NULL, '', '2018-04-10 10:24:21', '2018-04-10 10:26:26'),
(10, 23, 43, 86, 5, '500.00', '500.00', '0.00', NULL, 'IHN45822225007', '2018-04-10 11:44:47', '2018-04-10 11:47:10'),
(11, 24, 44, 87, 20, '243.75', '243.75', '0.00', NULL, 'SMJ7558455524', '2018-04-10 11:45:06', '2018-04-10 11:46:43'),
(12, 25, 41, 84, 1, '625.00', '625.00', '0.00', NULL, 'EXSD1225778855', '2018-04-10 11:46:02', '2018-04-10 11:46:02'),
(13, 26, 41, 84, 25, '625.00', '625.00', '0.00', NULL, 'HP020555548444', '2018-04-10 11:48:48', '2018-04-10 11:48:48'),
(14, 28, 42, 85, 20, '650.00', '650.00', '0.00', NULL, 'HP68400258F', '2018-04-10 11:54:16', '2018-04-10 11:54:16'),
(15, 29, 53, 96, 5, '131.25', '131.25', '0.00', NULL, '', '2018-04-10 13:04:40', '2018-04-10 13:04:40'),
(16, 30, 51, 94, 2, '125.00', '125.00', '0.00', NULL, '', '2018-04-10 13:04:54', '2018-04-10 13:04:54'),
(17, 31, 57, 100, 3, '25.00', '25.00', '0.00', NULL, '', '2018-04-10 13:05:19', '2018-04-10 13:05:19'),
(18, 32, 60, 103, 2, '18.75', '18.75', '0.00', NULL, '', '2018-04-10 13:07:50', '2018-04-10 13:07:50'),
(19, 33, 56, 99, 2, '187.50', '187.50', '0.00', NULL, '', '2018-04-10 13:08:01', '2018-04-10 13:08:01'),
(20, 34, 54, 97, 20, '12.50', '12.50', '0.00', NULL, '', '2018-04-10 13:08:15', '2018-04-10 13:08:15'),
(21, 35, 55, 98, 10, '10.00', '10.00', '0.00', NULL, '', '2018-04-10 13:08:27', '2018-04-10 13:08:27'),
(22, 36, 57, 100, 5, '25.00', '25.00', '0.00', NULL, '', '2018-04-10 13:08:49', '2018-04-10 13:08:49')");

        DB::insert("INSERT INTO variation_location_details (id, product_id, product_variation_id, variation_id, location_id, qty_available, created_at, updated_at) VALUES
					(1, 2, 2, 2, 1, '50.00', '2018-01-06 06:57:11', '2018-01-06 07:07:23'),
(2, 2, 2, 3, 1, '90.00', '2018-01-06 06:57:11', '2018-01-06 07:07:23'),
(3, 2, 2, 4, 1, '150.00', '2018-01-06 06:57:11', '2018-01-06 06:57:11'),
(4, 2, 2, 5, 1, '150.00', '2018-01-06 06:57:11', '2018-01-06 06:57:11'),
(5, 2, 2, 6, 1, '100.00', '2018-01-06 06:57:11', '2018-01-06 06:57:11'),
(6, 14, 15, 47, 1, '100.00', '2018-01-06 06:58:10', '2018-01-06 06:58:10'),
(7, 28, 30, 71, 1, '470.00', '2018-01-06 07:02:22', '2018-01-06 07:08:03'),
(8, 21, 23, 64, 1, '140.00', '2018-01-06 07:03:12', '2018-01-06 07:07:45'),
(9, 27, 29, 70, 1, '470.00', '2018-01-06 07:05:26', '2018-01-06 07:06:32'),
(10, 34, 36, 77, 2, '40.00', '2018-04-10 10:18:16', '2018-04-10 10:23:35'),
(11, 32, 34, 75, 2, '93.00', '2018-04-10 10:19:40', '2018-04-10 10:23:58'),
(12, 36, 38, 79, 2, '150.00', '2018-04-10 10:20:41', '2018-04-10 10:20:41'),
(13, 33, 35, 76, 2, '153.00', '2018-04-10 10:21:38', '2018-04-10 10:24:21'),
(14, 46, 48, 89, 3, '30.00', '2018-04-10 11:39:54', '2018-04-10 11:39:54'),
(15, 41, 43, 84, 3, '14.00', '2018-04-10 11:40:51', '2018-04-10 11:48:48'),
(16, 45, 47, 88, 3, '45.00', '2018-04-10 11:41:45', '2018-04-10 11:41:45'),
(17, 44, 46, 87, 3, '80.00', '2018-04-10 11:42:34', '2018-04-10 11:45:06'),
(18, 43, 45, 86, 3, '25.00', '2018-04-10 11:43:12', '2018-04-10 11:44:47'),
(19, 42, 44, 85, 3, '30.00', '2018-04-10 11:53:36', '2018-04-10 11:54:16')");

        //Roles and permissions for business 1
        $admin_role1 = Role::create( [ 'name' => 'Admin#1', 
                                'business_id' => 1, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        $cashier_role1 = Role::create( [ 'name' => 'Cashier#1', 
                                'business_id' => 1, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        

        $cashier_role1->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 
        	'access_all_locations', 'dashboard.data']);

        $admin1 = User::findOrFail(1);
        $cashier1 = User::findOrFail(2);
        $demo_user1 = User::findOrFail(3);

        $admin1->assignRole('Admin#1');
        $cashier1->assignRole('Cashier#1');
        $demo_user1->assignRole('Admin#1');
        Permission::insert(['name' => 'location.1', 'guard_name' => 'web', 'created_at' => \Carbon::now()->toDateTimeString()]);

        //Roles and permissions for business 2
        $admin_role2 = Role::create( [ 'name' => 'Admin#2', 
                                'business_id' => 2, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        $cashier_role2 = Role::create( [ 'name' => 'Cashier#2', 
                                'business_id' => 2, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        

        $cashier_role2->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 
        	'access_all_locations', 'dashboard.data']);

        $admin2 = User::findOrFail(4);

        $admin2->assignRole('Admin#2');
        Permission::insert(['name' => 'location.2', 'guard_name' => 'web', 'created_at' => \Carbon::now()->toDateTimeString()]);

        //Roles and permissions for business 3
        $admin_role3 = Role::create( [ 'name' => 'Admin#3', 
                                'business_id' => 3, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        $cashier_role3 = Role::create( [ 'name' => 'Cashier#3', 
                                'business_id' => 3, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        

        $cashier_role3->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 
        	'access_all_locations', 'dashboard.data']);

        $admin3 = User::findOrFail(5);

        $admin3->assignRole('Admin#3');
        Permission::insert(['name' => 'location.3', 'guard_name' => 'web', 'created_at' => \Carbon::now()->toDateTimeString()]);

        //Roles and permissions for business 4
        $admin_role4 = Role::create( [ 'name' => 'Admin#4', 
                                'business_id' => 4, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        $cashier_role4 = Role::create( [ 'name' => 'Cashier#4', 
                                'business_id' => 4, 
                                'guard_name' => 'web', 
                                'is_default' => 1
                            ]);
        

        $cashier_role4->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 
        	'access_all_locations', 'dashboard.data']);

        $admin4 = User::findOrFail(6);

        $admin4->assignRole('Admin#4');
        Permission::insert(['name' => 'location.4', 'guard_name' => 'web', 'created_at' => \Carbon::now()->toDateTimeString()]);

        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        DB::commit();
    }
}

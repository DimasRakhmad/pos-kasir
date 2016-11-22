<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use App\Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use App\Mike42\Escpos\Printer;
use App\Mike42\item;
use App\Models\AccountingTransaction;
use App\Models\Bank;
use App\Models\Category;
use App\Models\TransactionDetails;
use App\Models\Member;
use App\Models\Table;
use App\Models\Recipe;
use App\Models\Stock;
use App\Models\Transactions;
use App\User;
use Auth;
use Hash;
use DB;
use App\Models\EDC;
use App\Models\Menu;
use App\Models\Account;
use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel(Request $request)
    {
        $trans = Transactions::find($request->get('id'));
        $trans->delete();

        return back();
    }

    public function printSave($trans, $from)
    {
         try {
            // $connector = new WindowsPrintConnector("EPSON");
            // $connector = new CupsPrintConnector("Generic-ESC-P-Dot-Matrix");
            $connector = new NetworkPrintConnector("192.168.1.140", 9100);
            /* Information for the receipt */

            $printer = new Printer($connector);

            $items = [];

            if ($from == "dapur") 
                $detail = TransactionDetails::whereIn('id', session('detail_id_dapur'))->get();
            else
                $detail = TransactionDetails::whereIn('id', session('detail_id_bar'))->get();

            foreach ($detail as $key => $value) {
                $items[] = new item($value->item->name, $value->qty);
            }

            $order_type = new item('Order Type', $trans->sales->order_type);

            $table = new item('Meja', $trans->sales ? $trans->sales->table_id : "");
            $waiters = new item('Waiter', $trans->sales->waiter->name);
            /* Date is kept the same for testing */
            // $date = date('l jS \of F Y h:i:s A');

            $date = date("l d F Y h:i:s A");

            /* Print top logo */
            $printer->setJustification(Printer::JUSTIFY_CENTER);

            /* Name of shop */
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("GEMI\n");
            $printer->selectPrintMode();
            $printer->text("Daftar Pesanan\n");
            $printer->feed();

            /* Title of receipt */
            $printer->setEmphasis(true);
            $printer->text($trans->code . "\n");
            $printer->setEmphasis(false);

            /* Items */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            // $printer->text(new item('', 'Rp.'));
            $printer->setEmphasis(false);
            foreach ($items as $item) {
                $printer->text($item);
            }
            $printer->setEmphasis(true);
            $printer->setEmphasis(false);
            $printer->feed();

            /* Tax and total */
            $printer->text($waiters);
            $printer->text($order_type);
            $printer->text($table);


            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);

            $printer->selectPrintMode();

            /* Footer */
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            // $printer->text("Thank you for shopping at Pelangi\n");
            // $printer -> text("For trading hours, please visit example.com\n");
            $printer->feed(2);
            $printer->text($date . "\n");

            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();

            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }

        if ($from == "dapur")
            session()->forget('detail_id_dapur');
        else
            session()->forget('detail_id_bar');

    }

    public function prints($trans)
    {
        try {
            // $connector = new WindowsPrintConnector("EPSON");
            $connector = new CupsPrintConnector("Generic-ESC-P-Dot-Matrix");
            /* Information for the receipt */

            $printer = new Printer($connector);


            $items = [];

            foreach ($trans->detail as $key => $value) {
                $items[] = new item($value->item->name . " " . $value->subtotal . "x" . $value->qty, $value->total);
            }

            $order_type = new item('Order  type', $trans->sales->order_type);
            $pay_type = new item('Payment Type', $trans->sales->pay_type);
            $pay = new item('Pay', $trans->pay);
            $back = new item('Back', $trans->back);
            $subtotal = new item('Subtotal', $trans->total + $trans->discount);
            $tax = new item('Disount', $trans->discount);
            $total = new item('Total', $trans->total, true);
            /* Date is kept the same for testing */
            // $date = date('l jS \of F Y h:i:s A');

            $date = date("l d F Y h:i:s A");

            /* Print top logo */
            $printer->setJustification(Printer::JUSTIFY_CENTER);

            /* Name of shop */
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("Pelangi\n");
            $printer->selectPrintMode();
            $printer->text("Wastukencana\n");
            $printer->feed();

            /* Title of receipt */
            $printer->setEmphasis(true);
            $printer->text($trans->code . "\n");
            $printer->setEmphasis(false);

            /* Items */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->text(new item('', 'Rp.'));
            $printer->setEmphasis(false);
            foreach ($items as $item) {
                $printer->text($item);
            }
            $printer->setEmphasis(true);
            if ($trans->total > 0)
                $printer->text($subtotal);

            $printer->setEmphasis(false);
            $printer->feed();

            /* Tax and total */
            $printer->text($order_type);
            if ($trans->total > 0)
                $printer->text($pay_type);

            if ($trans->sales->pay_type == 'cash') {
                if ($trans->total > 0)
                    $printer->text($pay);
                $printer->text($back);
            }

            if ($trans->total > 0) {
                $printer->text($tax);
                $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                $printer->text($total);
            }

            $printer->selectPrintMode();

            /* Footer */
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for shopping at Pelangi\n");
            // $printer -> text("For trading hours, please visit example.com\n");
            $printer->feed(2);
            $printer->text($date . "\n");

            /* Cut the receipt and open the cash drawer */
            $printer->cut();
            $printer->pulse();

            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function checkout(Request $request)
    {
        $sales = Sale::where('transaction_id', $request->input('id'))->first();
        $sales->status = "checkout";
        $sales->save();

        $trans = Transactions::find($request->get('id'));

        $this->prints($trans);

        return redirect()->back();
    }

    public function index()
    {
        $Transactions = Transactions::with('accounting')->where('type', 'Jurnal')->get();
        // return $Transactions;
        return view('account.index-journal', ['items' => $Transactions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.create-jurnal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $detail = $request->input('detail');
        $Transactions = new Transactions();
        $Transactions->code = $request->input('Transactions_code');
        $Transactions->name = $request->input('name');
        $Transactions->date = $request->input('date');
        $Transactions->type = "Jurnal";
        $Transactions->total = 0;
        $Transactions->inputer = Auth::user()->id;

        if ($Transactions->save()) {
            foreach ($detail as $key) {
                if ($key['debit'] != '') {
                    $amount = $key['debit'];
                } else {
                    $amount = $key['kredit'] * -1;
                }
                $akun2 = new AccountingTransaction();
                $akun2->account_id = $key['selectedAccount']['id'];
                $akun2->transaction_id = $Transactions->id;
                $akun2->amount = $amount;
                $akun2->save();
                // $Transactions->account()->attach(['account_id'=>$key['selectedAccount']['id']],['amount'=>$amount,'item_name'=>$key['notes']]);
            }
            // Config::set('database.default', $default);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Transactions::with('accounting.account')->find($id);
        // return $item;
        return view('account.show-jurnal', ['items' => $item]);
    }

    public function showPayPiutang($id){
        $account = Account::with('accounting')->find($id);
        // return $account;
        return view('account.pay',['item'=>$account]);
    }

    public function storePayPiutang(Request $request){
        $date = $request->input('tanggal');
        $account = Account::find($request->input('account_id'));
        $transaction          = new Transactions();
        $transaction->name    = "Pembayaran ".$account->name." [".$date."]";
        // set belum dibayar
        $transaction->code    = $request->input('no_resi');
        $transaction->type    = "Piutang";
        $transaction->inputer = Auth::user()->id;
        $transaction->date    = date("Y-m-d", strtotime($date));
        $transaction->total   = $request->input('amount');
        $transaction->save();
        $accounting                 = new AccountingTransaction();
        $accounting->account_id     = $request->input('account_id');
        $accounting->amount         = -1 * $request->input('amount');
        $accounting->transaction_id = $transaction->id;
        if($accounting->save()){
            return redirect()->to(url('piutang-karyawan'))->with('hijau','Pembayaran berhasil');
        }else{
            return redirect()->back()->with('merah','Opps. Silahkan coba lagi');
        }
    }

    public function showPayPiutangPOS($id){
        $account = Account::with('accounting')->find($id);
        // return $account;
        return view('account.pay-pos',['item'=>$account]);
    }

    public function storePayPiutangPOS(Request $request){
        $date = $request->input('tanggal');
        $account = Account::find($request->input('account_id'));
        $transaction          = new Transactions();
        $transaction->name    = "Pembayaran ".$account->name." [".$date."]";
        // set belum dibayar
        $transaction->code    = $request->input('no_resi');
        $transaction->type    = "Piutang";
        $transaction->inputer = Auth::user()->id;
        $transaction->date    = date("Y-m-d", strtotime($date));
        $transaction->total   = $request->input('amount');
        $transaction->save();
        $accounting                 = new AccountingTransaction();
        $accounting->account_id     = $request->input('account_id');
        $accounting->amount         = -1 * $request->input('amount');
        $accounting->transaction_id = $transaction->id;
        if($accounting->save()){
            return redirect()->to(url('piutang-karyawan-pos'))->with('hijau','Pembayaran berhasil');
        }else{
            return redirect()->back()->with('merah','Opps. Silahkan coba lagi');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Transactions::destroy($id)) {
            return redirect()->back()->with('hijau', 'Succeed');
        } else {
            return redirect()->back()->with('merah', 'Oops! Something error');
        }
    }

    public function managerCode(Request $request)
    {
        $password = $request->get('auth');
        $user_id = $request->get('manager');

        $user = User::find($user_id);

        if (Hash::check($password, $user->password)) {
            return "match";
        } else {
            return "unmatch";
        }
    }

    public function transactionPay(Request $request)
    {
        // return $request->all();
        $tran = Transactions::find($request->get('id'));
        $tipe = $request->input('type');
        $trans = Transactions::find($request->get('id'));
        $trans->total = $request->input('ttl');

        $sales = Sale::where('transaction_id', $request->get('id'))->first();
        $sales->discount = $request->input('discount');
        $sales->status = "finish";
        $sales->pay_type = $request->input('type');
        $sales->subtotal = $request->input('ttl') + $request->input('discount');


        if ($request->input('type') == "compliment") {
            $sales->memo = $request->get('memo');
        }elseif (($request->input('type') == "debet") || ($request->input('type') == "credit")) {
            if ($request->input('bank_id')) {
                $sales->edc_id = $request->input('bank_id');
            }
        }elseif ($request->input('type') == "postpone") {
            if ($request->input('bank_id')) {
                $sales->edc_id = $request->input('bank_id');
            }
        }

        $sales->save();

        if ($trans->sales->order_type == 'Dine In') {
                   ///save table
            $table = Table::find($sales->table_id);
            $table->status = "Available";
            $table->save();
        } elseif ($trans->sales->order_type == 'Delivery') {
            $tran = new TransactionDetails;
            $tran->transaction_id = $trans->id;
            $tran->notes = "Delivery Cost";
            $tran->total = $request->input('deliv');
            $tran->save();

            /*
            Proses Akuntantsi
             */
            $akun = new AccountingTransaction();
            $akun->account_id = 7;
            $akun->transaction_id = $trans->id;
            $akun->amount = $request->input('deliv');
            $akun->save();
            
        } elseif ($trans->sales->order_type == 'Take Away') {

        }

        if ($trans->save()) {

            //update stock
            foreach ($trans->detail as $key => $value) {
                $recipe = Recipe::where('menu_id', $value->menu_id)->get();
                foreach ($recipe as $key1 => $value1) {
                    $stock = new Stock;
                    $stock->item_id = $value1->item_id;
                    $stock->type = "out";
                    $stock->date = date("Y-m-d");
                    $stock->amount = $value1->amount * $value->qty;
                    $stock->note = "recipe";
                    $stock->save();
                }
            }

            if (($request->input('type') == "debet") || ($request->input('type') == "credit")) {
                $tran = new TransactionDetails;
                $tran->transaction_id = $trans->id;
                $tran->notes = "Admin Cost";
                $tran->total = $request->input('admin');
                $tran->save();

            }
            /*
            Proses AKuntansi
             */
            if ($tipe == 'cash') {
                /*
                Akun kas
                 */
                $akun = new AccountingTransaction();
                $akun->account_id = 1;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('ttl');
                $akun->save();
                /*
                Akun Penjualan
                 */
                $akun2 = new AccountingTransaction();
                $akun2->account_id = 3;
                $akun2->transaction_id = $trans->id;
                $akun2->amount = -1 * ($request->input('ttl'));
                $akun2->save();
            } elseif ($tipe == 'credit') {
                /*
                Akun Bank
                 */
                $edc = EDC::find($request->input('bank_id'));
                $akun = new AccountingTransaction();
                $akun->account_id = $edc->account_kredit_id;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('ttl');
                $akun->save();
                /*
                Admin cost
                 */
                $akun = new AccountingTransaction();
                $akun->account_id = 6;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('admin');;
                $akun->save();
                /*
                Akun Penjualan
                 */
                $akun2 = new AccountingTransaction();
                $akun2->account_id = 3;
                $akun2->transaction_id = $trans->id;
                $akun2->amount = -1 * ($request->input('ttl'));
                $akun2->save();
            } elseif ($tipe == 'debet') {
                /*
                Akun Bank
                 */
                $edc = EDC::find($request->input('bank_id'));
                $akun = new AccountingTransaction();
                $akun->account_id = $edc->account_kredit_id;;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('ttl');
                $akun->save();
                 /*
                Admin cost
                 */
                $akun = new AccountingTransaction();
                $akun->account_id = 6;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('admin');;
                $akun->save();
                /*
                Akun Penjualan
                 */
                $akun2 = new AccountingTransaction();
                $akun2->account_id = 3;
                $akun2->transaction_id = $trans->id;
                $akun2->amount = -1 * ($request->input('ttl'));
                $akun2->save();
            } elseif ($tipe == 'postpone') {
                /*
                Akun Member
                 */
                $employee = Member::find($request->input('employee'));
                $akun = new AccountingTransaction();
                $akun->account_id = $employee->account_id;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('ttl');
                $akun->save();
                /*
                Akun Penjualan
                 */
                $akun2 = new AccountingTransaction();
                $akun2->account_id = 3;
                $akun2->transaction_id = $trans->id;
                $akun2->amount = -1 * ($request->input('ttl'));
                $akun2->save();
            } elseif ($tipe == 'compliment') {
                /*
                Akun Compliment
                 */
                $akun = new AccountingTransaction();
                $akun->account_id = 4;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('ttl');
                $akun->save();
                /*
                Akun Penjualan
                 */
                $akun2 = new AccountingTransaction();
                $akun2->account_id = 3;
                $akun2->transaction_id = $trans->id;
                $akun2->amount = -1 * ($request->input('ttl'));
                $akun2->save();
            } elseif ($tipe == 'void') {
                /*
                Akun Void
                 */
                $akun = new AccountingTransaction();
                $akun->account_id = 5;
                $akun->transaction_id = $trans->id;
                $akun->amount = $request->input('ttl');
                $akun->save();
                /*
                Akun Penjualan
                 */
                $akun2 = new AccountingTransaction();
                $akun2->account_id = 3;
                $akun2->transaction_id = $trans->id;
                $akun2->amount = -1 * ($request->input('ttl'));
                $akun2->save();
            } 
            $trans->pay = $request->get('bayar');
            $trans->back = $request->get('kembali');

            $this->prints($trans);
            return redirect('pilih');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat pembayaran, silahkan ulangi');
        }
    }

    public function waiters($id)
    {
        $table = Table::find($id);
        $cats = Category::all();
        $items = Menu::all();
        $bank = EDC::all();
        $emp = Member::all();
        $manager = User::join('role_user', 'users.id', '=', 'user_id');
        if ($table->status == 'Terisi') {
            $trans = Transactions::where('meja_id', $id)->where('status', 0)->first();
            $menus = DetailTransaksi::where('transaction_id', $trans->id)->get();
            return view('waiter.create', ['table' => $table, 'cats' => $cats, 'items' => $items, 'trans' => $trans, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
        } else {
            $table->status = 'Terisi';
            $table->save();

            $jum = Transactions::where('date', date('Y-m-d'))
                ->count();

            if ($jum == 0) {
                $code = 'TR' . date('Ymd') . date('his') . '1';
            } else {
                $code = 'TR' . date('Ymd') . date('his') . ($jum + 1);
            }
            $tran = new Transactions();
            $tran->code = $code;
            $tran->note = ['user_id' => session('id'), 'user_name' => session('nama')];
            $tran->meja_id = $id;
            $tran->date = date('Y-m-d');
            $tran->status_order = 'Dine In';

            $menus = [];
            if ($tran->save()) {
                $trans = Transactions::where('meja_id', $id)->where('status', 0)->first();
                return view('waiter.create', ['table' => $table, 'cats' => $cats, 'items' => $items, 'trans' => $trans, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
            } else {
                return redirect()->route('tables');
            }
        }
    }



    public function cart_total($meja, $total)
    {
//        session('meja'.$meja);
        if (session('meja' . $meja) == null) {
            $jum = $total;
        } else {
            $jum = session('meja' . $meja) + $total;
        }
        session()->put('meja' . $meja, $jum);

        return session('meja' . $meja);
    }

    public function cart_min($meja, $total)
    {
        $jum = session('meja' . $meja) - $total;
        session()->put('meja' . $meja, $jum);

        return session('meja' . $meja);
    }

    public function order(Request $request)
    {
        // return json_encode($request->all());
        $index = $request->get('index');
        $length = $request->get('length');
        $meja = Transactions::find($request->input('transaction_id'));
        $tran = new TransactionDetails();
        $tran->transaction_id = $request->input('transaction_id');
        $tran->menu_id = $request->input('items_id');
        $tran->subtotal = Menu::find($request->input('items_id'))->price;
        $tran->discount = $request->input('discon');
        $tran->total = $request->input('amount');
        if ($request->input('qty') > 0) {
            $tran->qty = $request->input('qty');
        } else {
            $tran->qty = 1;
        }
        if ($tran->save()) {

            if($tran->item->category->print_location == "Dapur"){
                if (session()->has('detail_id_dapur')) {
                    $id = session('detail_id_dapur');
                }else
                    $id = [];

                $id[] = $tran->id;

                session()->put('detail_id_dapur', $id);

            }else{
                if (session()->has('detail_id_bar')) {
                    $id_bar = session('detail_id_bar');
                }else
                    $id_bar = [];

                $id_bar[] = $tran->id;

                session()->put('detail_id_bar', $id_bar);
            }
               
            if ($index == $length) {
                if (session()->has('detail_id_dapur'))
                    $this->printSave($meja, "dapur");

                if (session()->has('detail_id_bar'))
                    $this->printSave($meja, "bar");
            }
//            return redirect('poskasir/' . $meja->meja_id);
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat penambahan data, silahkan ulangi');
        }
    }

    public function subtotal($transaksi)
    {
        return TransactionDetails::where('transaction_id', $transaksi)->sum('total');
    }

    public function bayar($id, Request $request)
    {
        $trans = Transactions::find($id);
        $trans->discon = $request->input('discon');
        $trans->amount = $request->input('amount');
        $trans->status = 1;

        $table = Table::find($trans->meja_id);
        $table->status = '';
        $table->save();

        if ($trans->save()) {
//            return redirect('kasir');
        } else {
            return redirect()->back()->with('merah', 'Oops! Ada masalah saat pembayaran, silahkan ulangi');
        }
    }

    public function kasir($id, Request $request)
    {
        $bank = EDC::all();
        $table = Table::find($id);
        $cats = Category::all();
        $items = Menu::all();
        $emp = Member::all();
        $manager = User::join('role_user', 'users.id', '=', 'user_id')
            ->where('role_id', 5)->get();


        if ($table->status == "Terisi") {
            $trans = Transactions::whereHas('sales', function($query) use ($id){
                                $query->where(['table_id'=> $id, 'pay_type' => '']);
                            })->first();

            if (!$trans) {
                $table->status = "Available";
                $table->save();

                return redirect($request->path());
            }

            $menus = TransactionDetails::where('transaction_id', $trans->id)->get();
            return view('pos.create', ['table' => $table, 'cats' => $cats, 'items' => $items, 'trans' => $trans, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
        } else {
            $menus = [];
            $table->status = 'Terisi';
            $table->save();

            $jum = Transactions::where('date', date('Y-m-d'))
                ->count();

            if ($jum == 0) {
                $code = 'TR' . date('Ymd') . date('his') . '1';
            } else {
                $code = 'TR' . date('Ymd') . date('his') . ($jum + 1);
            }
            $tran = new Transactions;
            $tran->code = $code;
            $tran->inputer = Auth::user()->id;
            $tran->name = "Penjualan " . date('Y-m-d') . " " . $jum;
            $tran->date = date('Y-m-d');
            $tran->type = "Sales";

            if ($tran->save()) {
                $sales = new Sale;
                $sales->table_id = $id;
                $sales->transaction_id = $tran->id;
                $sales->order_type = 'Dine In';
                $sales->status = "ordered";
                $sales->waiters_id = Auth::user()->id;
                $sales->save();

                return view('pos.create', ['table' => $table, 'cats' => $cats, 'items' => $items, 'trans' => $tran, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
            } else {
                return redirect()->route('tables');
            }
        }
    }

    public function delivery()
    {
        $cats = Category::all();
        $bank = EDC::all();
        $emp = Member::all();
        $manager = User::join('role_user', 'users.id', '=', 'user_id')
            ->where('role_id', 5)->get();
        $items = Menu::all();

        $trans = Transactions::whereHas('sales', function($query){
                    $query->where(['order_type' => 'Delivery' , 'pay_type' => '']);
                })->first();

        if (!$trans) {
            $menus = [];
            $jum = Transactions::where('date', date('Y-m-d'))
                ->count();

            if ($jum == 0) {
                $code = 'TR' . date('Ymd') . date('his') . '1';
            } else {
                $code = 'TR' . date('Ymd') . date('his') . ($jum + 1);
            }

            $tran = new Transactions;
            $tran->code = $code;
            $tran->inputer = Auth::user()->id;
            $tran->name = "Penjualan " . date('Y-m-d') . " " . $jum;
            $tran->date = date('Y-m-d');
            $tran->type = "Sales";

            if ($tran->save()) {
                $sales = new Sale;
                $sales->transaction_id = $tran->id;
                $sales->order_type = 'Delivery';
                $sales->status = "ordered";
                $sales->waiters_id = Auth::user()->id;
                $sales->save();

                return view('pos.create', ['deliv' => 1,'cats' => $cats, 'items' => $items, 'trans' => $tran, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
            } else {
                return redirect()->route('pilih');
            }
        } else {
            $menus = TransactionDetails::where('transaction_id', $trans->id)->get();
            return view('pos.create', ['deliv' => 1,'cats' => $cats, 'items' => $items, 'trans' => $trans, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
        }
    }

    public function take(Request $request)
    {
        $cats = Category::all();
        $bank = EDC::all();
        $emp = Member::all();
        $manager = User::join('role_user', 'users.id', '=', 'user_id')
            ->where('role_id', 5)->get();
        $items = Menu::all();

       $trans = Transactions::whereHas('sales', function($query){
                    $query->where(['order_type' => 'Take Away' , 'pay_type' => '']);
                })->first();

        if (!$trans) {
            $menus = [];
            $jum = Transactions::where('date', date('Y-m-d'))
                ->count();

            if ($jum == 0) {
                $code = 'TR' . date('Ymd') . date('his') . '1';
            } else {
                $code = 'TR' . date('Ymd') . date('his') . ($jum + 1);
            }
            $tran = new Transactions;
            $tran->code = $code;
            $tran->inputer = Auth::user()->id;
            $tran->name = "Penjualan " . date('Y-m-d') . " " . $jum;
            $tran->date = date('Y-m-d');
            $tran->type = "Sales";

            if ($tran->save()) {
                $sales = new Sale;
                $sales->transaction_id = $tran->id;
                $sales->order_type = 'Take Away';
                $sales->status = "ordered";
                $sales->waiters_id = Auth::user()->id;
                $sales->save();

                return view('pos.create', ['cats' => $cats, 'items' => $items, 'trans' => $tran, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
            } else {
                return redirect()->route('pilih');
            }
        } else {
            $menus = TransactionDetails::where('transaction_id', $trans->id)->get();
            return view('pos.create', ['cats' => $cats, 'items' => $items, 'trans' => $trans, 'menus' => $menus, 'emp' => $emp, 'manager' => $manager, 'bank' => $bank]);
        }
    }

    public function income()
    {
        $data = Transactions::whereHas('sales', function($query){
                                $query->where('status', 'finish');
                            })->sum('total');

        return view('report.pemasukkan', ['data' => $data]);
    }

    public function filterIncome($begin, $end)
    {
        $data = Transactions::whereIn('paytype', ['cash', 'credit', 'debet'])
            ->whereBetween('date', [$begin, $end])
            ->where('status', '1')
            ->sum('amount');
        return $data;
    }

    public function rTrans()
    {
        $trans = Transactions::where('date', date('Y-m-d'))
                              ->whereHas('sales', function($q){
                                $q->where('status', 'finish');
                              })->get();

        $count = Sale::whereHas('transaction', function($q){
                                $q->where('date', date('Y-m-d'));
                             })
                             ->select(DB::raw('count(*) as count, order_type'))
                             ->groupBy('order_type')
                             ->get();

        return view('report.trans', compact('trans', 'count'));
    }

    public function filterTrans($begin,$end)
    {
        $trans = Transactions::whereBetween('date', [$begin, $end])
                              ->whereHas('sales', function($q){
                                $q->where('status', 'finish');
                              })->get();

        $count = Sale::whereHas('transaction', function($q) use ($begin, $end) {
                                $q->whereBetween('date', [$begin, $end]);
                             })
                             ->select(DB::raw('count(*) as count, order_type'))
                             ->groupBy('order_type')
                             ->get();

        return view('report.trans', compact('trans', 'count'));
    }

    public function filterMenu($begin, $end)
    {
        $data = TransactionDetails::whereHas('transaction', function($q) use ($begin,$end){
                                        $q->whereBetween('date', [$begin, $end])
                                          ->whereHas('sales', function($q2){
                                            $q2->where('status' ,'finish');
                                        });
                                    })->whereNotNull('menu_id')
                                      ->select(DB::raw('sum(qty) as qty, sum(total) as total'), 'menu_id')
                                      ->groupBy('menu_id')
                                      ->get();

        return view('report.penjualan', ['data' => $data]);
    }


    public function filterrTrans($begin, $end)
    {
        $qty_dine = Transactions::where('status_order', 'Dine In')
            ->whereBetween('date', [$begin, $end])
            ->where('status', '1')
            ->count();
        $qty_take = Transactions::where('status_order', 'Take Away')
            ->whereBetween('date', [$begin, $end])
            ->where('status', '1')
            ->count();
        $qty_deliv = Transactions::where('status_order', 'Delivery')
            ->whereBetween('date', [$begin, $end])
            ->where('status', '1')
            ->count();

        return (['dine' => $qty_dine, 'take' => $qty_take, 'deliv' => $qty_deliv]);
    }

    public function rMenu()
    {
        $data = TransactionDetails::whereHas('transaction', function($q){
                                        $q->where('date', date('Y-m-d'))
                                          ->whereHas('sales', function($q2){
                                            $q2->where('status' ,'finish');
                                        });
                                    })->whereNotNull('menu_id')
                                      ->select(DB::raw('sum(qty) as qty, sum(total) as total'), 'menu_id')
                                      ->groupBy('menu_id')
                                      ->get();
        

        return view('report.penjualan', ['data' => $data]);
    }

    // public function filterMenu($begin, $end)
    // {
    //     $data = \DB::table('detail_Transactions')
    //         ->join('items', 'detail_Transactions.items_id', '=', 'items.id')
    //         ->whereIn('detail_Transactions.transaction_id', function ($q) use ($begin, $end) {
    //             $q->select('id')->where('Transactions.status', 1)
    //                 ->whereBetween('Transactions.date', [$begin, $end])
    //                 ->from('Transactions');
    //         })
    //         ->select('items.name', 'detail_Transactions.*')
    //         ->get();

    //     $menu = [];
    //     $arr = [];
    //     foreach ($data as $row) {
    //         $menu[$row->name][] = $row;
    //     }
    //     foreach ($menu as $key => $row2) {
    //         $jumlah = 0;
    //         foreach ($row2 as $key2 => $val) {
    //             $jumlah += $val->qty;
    //         }
    //         $qty = $jumlah;
    //         array_push($arr, ['menu' => $key, 'qty' => $qty]);
    //     }
    //     return $arr;
    // }

    public function detailTtrans($id)
    {
        $trans = Transactions::find($id);
        return view('report.detail_transaction', compact('trans'));
    }
    public function exportExel ()
    {
        $trans = Transactions::where('date', date('Y-m-d'))
            ->whereHas('sales', function($q){
                $q->where('status', 'finish');
            })->get();
        $qty_dine = Sale::where('order_type', 'Dine In')
            ->where('status', 'finish')
            ->count();
        $qty_take = Sale::where('order_type', 'Take Away')
            ->where('status', 'finish')
            ->count();
        $qty_deliv = Sale::where('order_type', 'Delivery')
            ->where('status', 'finish')
            ->count();
        Excel::create('Laporan Transaksi ', function($excel) use($trans,$qty_dine,$qty_take,$qty_deliv) {
            $excel->sheet('1', function($sheet) use($trans,$qty_dine,$qty_take,$qty_deliv) {
                $sheet->loadView('excel.laporanTrans',['trans'=>$trans,'dine' => $qty_dine, 'take' => $qty_take, 'deliv' => $qty_deliv]);
            });
        })->download('xls');
    }
    public function exportExelMenu ()
    {
        $data = TransactionDetails::whereHas('transaction', function($q){
            $q->where('date', date('Y-m-d'))
                ->whereHas('sales', function($q2){
                    $q2->where('status' ,'finish');
                });
        })->whereNotNull('menu_id')
            ->select(DB::raw('sum(qty) as qty, sum(total) as total'), 'menu_id')
            ->groupBy('menu_id')
            ->get();
        Excel::create('Laporan Penjualan Menu ', function($excel) use($data) {
            $excel->sheet('1', function($sheet) use($data) {
                $sheet->loadView('excel.laporanTransMenu',['data'=>$data,]);
            });
        })->download('xls');
    }

}

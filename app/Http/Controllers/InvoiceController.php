<?php

namespace App\Http\Controllers;

use App\Jobs\InvoiceEmailjob;
use App\Mail\InvoiceEmail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class InvoiceController extends Controller
{

    /**
    *Function Index
    *Display invoices
    */

    public function index(Request $request)
    {
        $invoices=Invoice::with('client')->latest();

        if(!empty($request->client_id) ){
            $invoices = $invoices->where('client_id',$request->client_id);
        }
        if(!empty($request->status) ){
            $invoices = $invoices->where('status',$request->status);
        }
        if(!empty($request->emailsent) ){
            $invoices = $invoices->where('email_sent',$request->emailsent);
        }

        $invoices = $invoices->paginate(10);
        return view('invoice.index')->with([
            'clients'  =>Client::where('user_id', Auth::user()->id)->get(),
            'invoices' =>$invoices,
        ]);
    }

       /**
    *Function create
    * @param request
    *Method Get
    * search Query
    */
    public function create( Request $request)
    {

        $tasks = false;

        //if client id and status is not empty
        if(!empty($request->client_id) && !empty($request->status)){
            $request->validate([
                'client_id' =>['required', 'not_in:none'],
                'status'    =>['required', 'not_in:none'],
            ]);

            $tasks=$this->getInvoiceData($request);
        }
        // Return
        return view ('invoice.create')->with([
            'clients' => Client::where('user_id',Auth::user()->id)-> get(),
            'tasks'   =>$tasks
        ]);
    }

     /**
    *Function Update
    *@param Request Invoice
    *update invoice status to paid
    */

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update([
         'status' =>'paid'
        ]);

        return redirect()->route('invoice.index')->with('success', 'Invoice Payment Mark As Paid');
    }

       /**
    *Function Destroy
    *Delete Invoice info
    */
      public function destroy(Invoice $invoice)
    {
        Storage::delete('public/invoices/'.$invoice->download_url);
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success' , 'Invoice deleted successful');
    }

    /**
    *Function getInvoiceData
    *return tasks
    */

    public function getInvoiceData(Request $request)
    {
        $tasks =Task::latest();

        if(!empty($request->client_id) ){
            $tasks = $tasks->where('client_id', '=' , $request->client_id);
        }
        if(!empty($request->status) ){
            $tasks = $tasks->where('status', '=' , $request->status);
        }
        if(!empty($request->formDate) ){
          $tasks = $tasks->whereDate('created_at', '>=' , $request->formDate);
         }
        if(!empty($request->endDate) ){
         $tasks = $tasks->whereDate('created_at', '<=' , $request->endDate);
         }

         return $tasks->get();
    }

    /**
     *Method invoice
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */

//invoice generate function preview
    public function invoice(Request $request)
    {

        if(!empty($request->generate)&& $request->generate == 'yes'){
            $this->generate($request);

            return redirect()->route('invoice.index')->with('success', 'invoice Created');
        }
        if(!empty($request->preview)&& $request->preview == 'yes'){

            if(!empty($request->discount) && !empty($request->discount_type) ){
                $discount = $request->discount;
                $discount_type = $request->discount_type;
            }else{
                $discount = 0;
                $discount_type = '';
            }


            $tasks = Task::whereIn('id',$request->invoice_ids)->get();
        return view('invoice.preview')->with([
            'invoice_no' => 'INVO_'.rand(25855263525,25655554566),
            'user'       => Auth::user(),
            'tasks'      =>$tasks,
            'discount'      =>$discount,
            'discount_type'      =>$discount_type,
        ]);
        }
    }

      /**
    *Function generate
    *PDF Generation
    *Invoice Insert
    */

    public function generate(Request $request)
    {



            if(!empty($request->discount) && !empty($request->discount_type) ){
                $discount = $request->discount;
                $discount_type = $request->discount_type;
            }else{
                $discount = 0;
                $discount_type = '';
            }


        $invo_no ='INVO_'.rand(25855263525,25655554566);

        $tasks = Task::whereIn('id',$request->invoice_ids)->get();
        $data=[
            'invoice_no' =>$invo_no ,
            'user'       => Auth::user(),
            'tasks'      =>$tasks,
            'discount'      =>$discount,
            'discount_type'      =>$discount_type,
        ];
        //generation PDF
        $pdf = PDF::loadView('invoice.pdf', $data);
        // store pdf in storage
        Storage::put('public/invoices/'.$invo_no.'.pdf',$pdf->output());
        //insert invoice data
        Invoice::create([
            'invoice_id' => $invo_no,
            'client_id'  => $tasks->first()->client->id,
            'user_id'    => Auth::user()->id,
            'status'     =>'unpaid',
            'amount'     =>$tasks->sum('price'),
            'download_url'=>$invo_no.'.pdf',


        ]);


    }


     public function sendEmail(Invoice $invoice)
    {

        $data =[
            'user'        => Auth::user(),
            'invoice_id'  => $invoice->invoice_id,
            'invoice'     => $invoice,
        ];

       // InvoiceEmailjob::dispatch($data);
       dispatch(new InvoiceEmailjob($data));

        $invoice->update([
            'email_sent'  =>'yes'
        ]);

        return redirect()->route('invoice.index')->with('success','Email Send');
    }





}

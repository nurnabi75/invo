<?php

namespace App\Http\Controllers;

use App\Events\ActivityEvent;
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
        // Get latest Invoice
        $invoices=Invoice::with('client')->where('user_id', Auth::id())->latest();

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
        // event(new ActivityEvent('Invoice '.$task->id.' Create','Invoice'));
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
     try {
        $invoice->update([
            // update status
            'status' =>$invoice->status == 'unpaid' ? 'paid' : 'unpaid'
           ]);
           //Event fire
           event(new ActivityEvent('Invoice '.$invoice->id.' Updated','Invoice',Auth::id()));
           // return response
           return redirect()->route('invoice.index')->with('success', 'Invoice Payment Mark As Paid');
     } catch (\Throwable $th) {
         //throw $th;
         return redirect()->route('invoice.index')->with('error', $th->getMessage());
     }
    }

       /**
    *Function Destroy
    *Delete Invoice info
    */
      public function destroy(Invoice $invoice)
    {
      try {
           // delete pdf file
        Storage::delete('public/invoices/'.$invoice->download_url);
         // delete data from database
        $invoice->delete();
        // Event Fire
        event(new ActivityEvent('Invoice '.$invoice->id.' Deleted','Invoice',Auth::id()));
         // return response
        return redirect()->route('invoice.index')->with('success' , 'Invoice deleted successful');
      } catch (\Throwable $th) {
          //throw $th;
          return redirect()->route('invoice.index')->with('error', $th->getMessage());
      }
    }

    /**
    *Function getInvoiceData
    *return tasks
    */

    public function getInvoiceData(Request $request)
    {
      try {
          // Get latest tasks
        $tasks =Task::latest();
        // filter by clients
        if(!empty($request->client_id) ){
            $tasks = $tasks->where('client_id', '=' , $request->client_id);
        }
         // filter by status
        if(!empty($request->status) ){
            $tasks = $tasks->where('status', '=' , $request->status);
        }
        // filter by from date
        if(!empty($request->formDate) ){
          $tasks = $tasks->whereDate('created_at', '>=' , $request->formDate);
         }
         // filter by end date
        if(!empty($request->endDate) ){
         $tasks = $tasks->whereDate('created_at', '<=' , $request->endDate);
         }
         // return tasks
         return $tasks->get();
      } catch (\Throwable $th) {
          //throw $th;
          return false;
      }
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
         // if rewuest is generate
        if(!empty($request->generate)&& $request->generate == 'yes'){
            try {
                 // generate invoice pdf
                $this->generate($request);
                 // return resposne
                return redirect()->route('invoice.index')->with('success', 'invoice Created');
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('invoice.index')->with('error', $th->getMessage());
            }
        }
        // if request is preview invoice
        if(!empty($request->preview)&& $request->preview == 'yes'){
            // check discount and discount type
            if(!empty($request->discount) && !empty($request->discount_type) ){
                $discount = $request->discount;
                $discount_type = $request->discount_type;
            }else{
                $discount = 0;
                $discount_type = '';
            }
             // get tasks from request ids
            $tasks = Task::whereIn('id',$request->invoice_ids)->get();
             // return view with invoice
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
            // check discount and discount type
            if(!empty($request->discount) && !empty($request->discount_type) ){
                $discount = $request->discount;
                $discount_type = $request->discount_type;
            }else{
                $discount = 0;
                $discount_type = '';
            }
            // generate invoice random id
           $invo_no ='INVO_'.rand(25855263525,25655554566);
            // get tasks from request ids
            $tasks = Task::whereIn('id',$request->invoice_ids)->get();
            // get all data into an array
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
        // Event fire
        event(new ActivityEvent('Invoice '.$invo_no.' Generate','Invoice',Auth::id()));
    }

     public function sendEmail(Invoice $invoice)
    {
       try {
           // get all data into an array
        $data =[
            'user'        => Auth::user(),
            'invoice_id'  => $invoice->invoice_id,
            'invoice'     => $invoice,
            'pdf'     =>public_path('storage/invoices/'.$invoice->download_url),
        ];

         // Email initialize with Mailable and Queue
       Mail::to($invoice->client)->send(new InvoiceEmail($data));
        // update invoice email sent status
        $invoice->update([
            'email_sent'  =>'yes'
        ]);
        //Event Fire
        event(new ActivityEvent('Invoice '.$invoice->id.' Send Email','Invoice',Auth::id()));
        // return response
        return redirect()->route('invoice.index')->with('success','Email Send');
       } catch (\Throwable $th) {
           //throw $th;
           return redirect()->route('invoice.index')->with('error', $th->getMessage());
       }
    }

}

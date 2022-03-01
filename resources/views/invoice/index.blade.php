<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }}
            </h2>
            <a href="{{route('invoice.create')}}" class="border  border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" mb-6 bg-white py-10 rounded-md {{request('client_id') || request('status')
             ||request('emailsent') ? '' : 'hidden'}}" id="task_filter">
                <h2 class="text-center font-bold text-orange-500 mb-6 text-4xl">Filter Invoice</h2>
                <form action="{{ route('invoice.index')}}" method="GET">

                        <div class=" flex space-x-3  items-end justify-center">
                            <div class="">
                                @error('client_id')
                                  <p class=" text-red-700 text-sm">{{$message}}</p>
                                @enderror
                                <label for="client_id" class="formlabel">Client</label>
                                <select name="client_id" id="client_id" class="forminput">
                                    <option value="">Select Client</option>

                                    @foreach ($clients as $client )
                                    <option value="{{$client->id}}" {{$client->id == old('client_id') ||
                                     $client->id == request('client_id')  ? "selected"  : "" }}>{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="">
                                @error('status')
                                  <p class=" text-red-700 text-sm">{{$message}}</p>
                                @enderror
                                <label for="status" class="formlabel">Status</label>
                                <select name="status" id="status" class="forminput">
                                    <option value="">Select Status</option>
                                    <option value="paid" {{old('status') == 'paid' || request('status') ==
                                    'paid' ? 'selected' : ''}}>Paid</option>
                                    <option value="unpaid"  {{old('status') == 'unpaid' || request('status') ==
                                    'unpaid' ? 'selected' : ''}}>Unpaid</option>
                                </select>
                            </div>
                            <div class="">

                                @error('emailsent')
                                <p class=" text-red-700 text-sm">{{$message}}</p>
                               @enderror
                                <label for="emailsent" class="formDate" class="formlabel">Send Email</label>
                                <select name="emailsent" id="emailsent" class="forminput">
                                    <option value="">Select Status</option>
                                    <option value="yes" {{old('emailsent') == 'yes' || request('emailsent') ==
                                    'yes' ? 'selected' : ''}}>Yes</option>
                                    <option value="no"  {{old('emailsent') == 'no' || request('emailsent') ==
                                    'no' ? 'selected' : ''}}>No</option>
                                </select>
                            </div>

                            <div class="">
                                <button type="submit" class="bg-purple-600 text-white px-3 py-2 ">Filter</button>
                            </div>
                        </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <div class="text-center">
                          <button id="task_filter_btn" type="button" class="px-3 py-1
                           bg-green-400 text-black mb-6 ">{{request('client_id') || request('status')
                            ||request('emailsent')  ? 'Close Filtering' : 'Task Filtering'}}</button>
                        </div>
                    <table class="w-full tab border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-56">Id</th>
                                <th class="border py-2">Client</th>
                                <th class="border py-2 w-24">status</th>
                                <th class="border py-2 w-28">Email Send</th>
                                <th class="border py-2 w-52">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($invoices as $invoice )

                                <tr>

                                    <td class="border py-2 text-center  ">
                                        <a target="_blank" class="hover:text-emerald-600"
                                          href="{{ asset('storage/invoices/'.$invoice->download_url) }}">
                                            {{$invoice->invoice_id}}
                                        </a>
                                    </td>
                                    <td class="border py-2 text-center px-2 ">
                                        <a class="hover:text-pink-700"
                                           href="{{ route('invoice.index')}}?client_id={{$invoice->client['id']}}">
                                            {{$invoice->client['name']}}
                                        </a>
                                    </td>
                                    <td class="border py-2 text-center capitalize ">{{$invoice->status}}
                                        @if ($invoice->status == 'unpaid')
                                        <form action="{{ route('invoice.update' , $invoice->id) }}" method="POST" onsubmit="return
                                        confirm('Did You Get Paid?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class=" bg-lime-600 hover:bg-indigo-500 text-white px-3
                                            py-0 text-sm w-24">Paid</button>
                                        </form>
                                        @endif
                                    </td>

                                    <td class="border py-2 text-center capitalize flex flex-col w-28">
                                        {{$invoice->email_sent}}
                                        <a href="{{route('invoice.sendEmail', $invoice)}}" class="border-2 hover:bg-teal-400
                                        hover:text-black transition-all duration-300 bg-sky-400
                                        px-3 py-0 text-sm w-full ">Send Email</a>
                                    </td>


                                    <td class="border py-2 text-center w-52 ">
                                        <div class=" flex justify-center space-x-3 items-center">


                                            <a target="_blank" href="{{ asset('storage/invoices/'.$invoice->download_url) }}"
                                                class="bg-blue-800 text-white px-3 text-sm py-1 mr-2">Preview</a>
                                            <form action="{{ route('invoice.destroy' , $invoice->id) }}" method="POST"
                                                onsubmit="return confirm('Do You Really Want To Delete?');">
                                                @csrf
                                                @method('DELETE')



                                                <button type="submit" class="bg-red-800 text-white px-3 py-1 text-sm">Delete</button>

                                            </form>

                                        </div>



                                    </td>
                                </tr>

                                @empty

                                <tr>
                                    <td class="text-center border py-2 text-red-600" colspan="5">
                                        No Invoice Found
                                    </td>
                                </tr>

                            @endforelse


                        </tbody>
                    </table>


                    <div class="mt-5">
                        {{$invoices->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

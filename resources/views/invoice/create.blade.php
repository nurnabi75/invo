<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Invoice') }}
            </h2>
            <a href="{{route('invoice.index')}}" class="border  border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                <form action="{{ route('invoice.create')}}" method="GET">
                    @csrf

                        <div class=" flex space-x-3  items-end justify-center">
                            <div class="">
                                @error('client_id')
                                  <p class=" text-red-700 text-sm">{{$message}}</p>
                                @enderror
                                <label for="client_id" class="formlabel">Select Client</label>
                                <select name="client_id" id="client_id" class="forminput">
                                    <option value="none">Select Client</option>

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
                                <label for="status" class="formlabel">Select Status</label>
                                <select name="status" id="status" class="forminput">
                                    <option value="none">Select Status</option>
                                    <option value="pending" {{old('status') == 'pending' || request('status') ==
                                    'pending' ? 'selected' : ''}}>Pending</option>
                                    <option value="complete"  {{old('status') == 'complete' || request('status') ==
                                    'complete' ? 'selected' : ''}}>Completed</option>


                                </select>



                            </div>

                            <div class="">

                                @error('formDate')
                                <p class=" text-red-700 text-sm">{{$message}}</p>
                               @enderror
                                <label for="formDate" class="formDate">Start Date</label>
                                <input type="date" class="forminput" name="formDate" id="formDate"
                                max="{{now()->format('Y-m-d') }}" value="{{request('formDate')}}">


                            </div>
                            <div class="">
                                @error('endDate')
                                <p class=" text-red-700 text-sm">{{$message}}</p>
                               @enderror
                                <label for="endDate" class="endDate">End Date</label>
                                <input type="date" class="forminput" name="endDate" id="endDate"
                                 value="{{ request('endDate') != '' ? request('endDate') : now()->format('Y-m-d')}}"
                                max="{{ now()->format('Y-m-d') }}" >

                            </div>

                            <div class="">
                                <button type="submit" class="bg-purple-600 text-white px-3 py-2 ">Search</button>
                            </div>
                        </div>
                </form>

                    @if ($tasks)
                     <div class=" mt-10">
                     <tbody>
                    <form action="{{route('invoice')}}" method="GET" id="taskInvoiceFrom">
                            @csrf
                        <table class="w-full tab border-collapse">
                            <thead>
                                <tr>
                                    <th class="border py-2">Select</th>
                                    <th class="border py-2">Name</th>
                                    <th class="border py-2">status</th>
                                    <th class="border py-2">Price</th>
                                </tr>
                            </thead>

                                @foreach ($tasks as $task)
                                <tr>
                                    <td class="border py-2 text-left px-3 text-center">
                                        <input type="checkbox" name="invoice_ids[]" value="{{ $task->id }}" checked>
                                    </td>
                                    <td class="border py-2 text-center  ">{{$task->name}}</td>
                                    <td class="border py-2 text-center ">{{$task->status}}</td>
                                    <td class="border py-2 text-center ">{{$task->price}}</td>
                                </tr>
                                 @endforeach


                            </tbody>
                        </table>
                        <div class="mt-6 flex justify-between">
                          <div class=" flex space-x-3 ">
                            <div class="">
                                <label for="discount">Discount</label>
                                <input type="number" name="discount" id="discount"  placeholder="Type discount">
                            </div>
                            <div class="">
                                {{-- <label for="discount_type">Discount Type: </label> --}}
                                <select name="discount_type" id="discount_type">
                                    <option value="%">%</option>
                                    <option value="$">$</option>
                                </select>
                            </div>
                          </div>

                            <div class=" space-x-4">
                                <button type="submit" name="preview" value="yes" form="taskInvoiceFrom"
                                class=" bg-red-400 text-white py-2 px-6 rounded">Preview</button>

                                <button type="submit" name="generate" value="yes" form="taskInvoiceFrom"
                                class=" bg-red-400 text-white py-2 px-6 rounded">Generate</button>
                             </div>
                        </div>
                    </form>
                     </div>



                    @endif

                </div>
            </div>
        </div>
    </div>



</x-app-layout>

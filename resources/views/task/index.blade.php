<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{route('task.create')}}" class="border  border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" mb-6 bg-white py-10 rounded-md {{request('client_id') || request('status')
             ||request('formDate') || request('endDate') ||request('price') ? '' : 'hidden'}}" id="task_filter">
                <h2 class="text-center font-bold text-orange-500 mb-6 text-4xl">Filter Tasks</h2>
                <form action="{{ route('task.index')}}" method="GET">

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
                                <label for="formDate" class="formDate" class="formlabel">Start Date</label>
                                <input type="date" class="forminput" name="formDate" id="formDate"
                                max="{{now()->format('Y-m-d') }}" value="{{request('formDate')}}">


                            </div>
                            <div class="">
                                @error('endDate')
                                <p class=" text-red-700 text-sm">{{$message}}</p>
                               @enderror
                                <label for="endDate" class="formlabel" >End Date</label>
                                <input type="date" class="forminput" name="endDate" id="endDate"
                                 value="{{ request('endDate') != '' ? request('endDate') :''}}"
                                max="{{ now()->format('Y-m-d') }}" >
                            </div>

                            <div class="">
                                @error('price')
                                <p class=" text-red-700 text-sm">{{$message}}</p>
                               @enderror
                                <label for="price" class="formlabel">Max Price</label>
                                <input type="number" class="forminput" name="price" id="price" value="{{request('price')}}" >
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
                    <button id="task_filter_btn" type="button" class="px-3 py-1 bg-green-400 text-black mb-6 ">{{request('client_id') || request('status')
                        ||request('formDate') || request('endDate') ||request('price') ? 'Close Filtering' : 'Task Filtering'}}</button>
                   </div>

                    <table class="w-full tab border-collapse">
                        <thead>
                            <tr>
                                <th  class="border py-2">Name</th>
                                <th class="border py-2 w-20">Price</th>
                                <th class="border py-2 w-40">status</th>
                                <th class="border py-2">Client</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($tasks as $task)

                            <tr>

                                <td class="border py-2 text-left px-2 ">
                                    <a class="font-bold text-neutral-900 hover:text-orange-400 " href="{{route('task.show' , $task->slug)}}">{{$task->name}}</a>
                                    </td>
                                <td class="border py-2 text-center text-sm">{{$task->price}}</td>
                                <td class="border py-2 text-center capitalize text-sm">{{$task->status}}
                                    @if ($task->status == 'pending')



                                    <form action="{{ route('markAsComplete' ,$task)}}" method="POST" onsubmit="return confirm('Are You Sure?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-teal-400 hover:bg-red-800 text-black  hover:text-white  px-3 py-1 w-full">Done</button>
                                    </form>

                                @endif
                                </td>
                                <td class="border py-2 text-left px-3 text-sm">
                                    <a class="text-orange-500 hover:text-rose-900" href="{{route('task.index' )}}?client_id={{$task->client->id}}">{{$task->client->name}}</a>
                                </td>
                                <td class="border py-2 text-center ">
                                    <div class=" flex justify-center">



                                        <a href="{{route('task.edit' , $task->id)}}" class="bg-emerald-800 text-white px-3 py-1 mr-2 hover:bg-lime-500 ">Edit</a>

                                        <form action="{{ route('task.destroy' , $task->id) }}" method="POST" onsubmit="return confirm('Do You Really Want To Delete?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-400 hover:bg-red-800 text-black  hover:text-white  px-3 py-1">Delete</button>

                                        </form>

                                    </div>



                                </td>
                            </tr>

                            @endforeach


                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{$tasks->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

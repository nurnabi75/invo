<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="">
        <div class="container mx-auto py-10">
            <div class="grid grid-cols-4 gap-5">

                <x-card text="Clients" :route="route('client.index')" :count="count($user->clients)"
                     class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md"/>

                <x-card text="Pending Tasks" route="{{ route('task.index')}}?status=pending" :count="count($pending_tasks)"
                 class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md"/>

                 <x-card text="Completed Tasks" route="{{ route('task.index')}}?status=complete"
                 :count="count($user->tasks) - count($pending_tasks)"
                 class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md"/>

                <x-card text="Due Invoice" route="{{ route('invoice.index')}}?status=unpaid"
                    :count="count($unpaid_invoices)"
                     class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md"/>

            </div>
        </div>
    </div>
    <div class="">
        <div class="container mx-auto">
            <div class="flex space-x-10">
                <div class=" flex-1 max-w-none">
                    <h3 class="text-2xl mb-5 font-bold">Todo:</h3>

                    <ul class="bg-green-700 px-10 py-4 rounded-md">
                        @forelse ($pending_tasks->slice(0,5) as $task )

                          @php
                            $startdate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->setTimezone('Asia/Dhaka');

                                $enddate = $task->end_date;
                                // time left calcalution
                                if($enddate > $startdate){
                                    $days = $startdate
                                    ->diffInDays($enddate);
                                    $hours = $startdate
                                    ->copy()
                                    ->addDays($days)
                                    ->diffInHours($enddate);
                                    $minutes =$startdate
                                    ->copy()
                                    ->addDays($days)
                                    ->addHours($hours)
                                    ->diffInMinutes($enddate);
                                }else{
                                    $days = 0;
                                    $hours = 0;
                                    $minutes =0;
                                }
                            @endphp

                            <li class="flex justify-between items-center border-b py-2">
                              <a class="text-white hover:text-black transition-all duration-300 w-8/12" href=" {{ route('task.show', $task->slug)}}">{{ $task->name}}</a>
                              @if ($enddate > $startdate)
                              <span class="text-white text-xs w-3/12 " >{{ $days !=0 ? $days . 'Days,' : '' }} {{ $days !=0 && $hours !=0 ? $hours .'Hours' : '' }}
                                {{ $minutes. 'Minutes' }} Left</span>

                              @else
                              <span class="text-white text-xs w-3/12 " >Time Over!</span>
                              @endif

                            </li>
                          @empty
                          <li>No Tasks Found!</li>
                        @endforelse
                        <div class="text-center mt-5">
                            <a href="{{ route('task.index') }}" class="inline-block px-5 py-1 text-white bg-black uppercase"> View More</a>
                        </div>
                    </ul>

                </div>
                <div class=" flex-1 max-w-none">
                    <h3 class="text-2xl mb-5 font-bold">Activity Log:</h3>
                    <ul class="bg-green-600 px-5 py-4 text-white rounded-md list-none  ">

                        @forelse ($activity_logs->slice(0,5) as $activity )
                        <li class="flex justify-between items-center border-b py-1">
                            <span class=" text-white w-8/12 ">{{ $activity->message }}</span>
                            <span class="text-white text-xs w-3/12 text-right">{{ $activity->created_at->diffForHumans() }}</span>
                        </li>
                        @empty
                        <li class="flex justify-between items-center border-b py-1">
                            <span class=" text-white w-8/12 ">No Activity Found!</span>
                        </li>
                        @endforelse
                    </ul>
                    <h3 class="text-2xl mb-5 font-bold mt-5">Payment History:</h3>

                    <ul class="bg-green-600 px-5 py-4 rounded-md">
                        @forelse ( $paid_invoices->slice(0,5) as $invoice )
                         <li class="flex justify-between space-x-10 items-center">
                            <span class="text-sm">{{ $invoice->updated_at->format('d M, Y')}}</span><span>
                                {{ $invoice->client->name}}</span><span>${{$invoice->amount}}</span></li>
                                @empty
                                <li class="text-white">No Invoice Found!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

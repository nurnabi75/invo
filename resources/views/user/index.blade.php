<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <a href="{{route('user.create')}}" class="border  border-emerald-400 px-3 py-1">Add New</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="w-full tab border-collapse">
                        <thead>
                            <tr>
                                <th  class="border py-2">Image</th>
                                <th  class="border py-2">Name</th>
                                <th class="border py-2 w-20">Email</th>
                                <th class="border py-2 w-40">Company</th>
                                <th class="border py-2 w-32">Phone</th>
                                <th class="border py-2 w-32">Country</th>
                                <th class="border py-2 w-32">Role</th>
                                <th class="border py-2 w-32">Verified</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                          @php
                            function getImageUrl($image){
                                if(str_starts_with($image, 'http')){
                                    return $image;
                                }
                                return asset('storage/uploads') . '/' . $image;
                            }
                           @endphp

                            @forelse ($users as $user)
                            <tr>
                               <td class="border py-2 text-center text-sm">
                                   <img src="{{ getImageUrl( $user->thumbnail) }}" width="50" alt="" class="mx-auto">
                               </td>
                               <td class="border py-2 text-center text-sm">{{ $user->name }}</td>
                               <td class="border py-2 text-center text-sm">{{ $user->email }}</td>
                               <td class="border py-2 text-center text-sm">{{ $user->company }}</td>
                               <td class="border py-2 text-center text-sm">{{ $user->phone }}</td>
                               <td class="border py-2 text-center text-sm">{{ $user->country }}</td>
                               <td class="border py-2 text-center text-sm capitalize">{{ $user->role }}</td>
                               <td class="border py-2 text-center text-sm capitalize">{{ $user->hasVerifiedEmail() ? 'Yes' : 'No'}}</td>
                                <td class="border py-2 text-center ">
                                    <div class=" flex justify-center">
                                        <a href="{{route('user.edit' , $user)}}" class="bg-emerald-800 text-white px-3 py-1 mr-2 hover:bg-lime-500 ">Edit</a>

                                        <form action="{{ route('user.destroy' , $user) }}" method="POST" onsubmit="return confirm('Do You Really Want To Delete?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-400 hover:bg-red-800 text-black  hover:text-white  px-3 py-1">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="border py-2 text-center text-red-600" colspan="5">No Users Found!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

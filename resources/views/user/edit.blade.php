<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('user.index') }}" class="border  border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        @method('PUT')

                        <div class="mt-6 flex">
                            <div class=" flex-1 mr-4">
                                <label for="name" class="formlabel">Name</label>
                                <input type="text" name="name" id="name" class="forminput"
                                    value="{{ $user->name }}">

                                @error('name')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1 mr-4">
                                <label for="email" class="formlabel">Email</label>
                                <input type="text" name="email" id="email" class="forminput"
                                    value="{{ $user->email }}">
                                @error('email')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class=" flex-1 ml-4">
                                <label for="company" class="formlabel">Company</label>
                                <input type="text" name="company" id="company" class="forminput"
                                    value="{{ $user->company }}">
                                @error('phone')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="mt-6 flex">
                            <div class=" flex-1 mr-4">
                                <label for="phone" class="formlabel">Phone</label>
                                <input type="text" name="phone" id="phone" class="forminput"
                                    value="{{ $user->phone }}">
                                @error('phone')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label for="role" class="formLabel">Role</label>
                                <select name="role" id="role" class="forminput">
                                    <option value="none">Select Role</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>

                                </select>

                                @error('role')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 ml-4">
                                <label for="country" class="formLabel">Country</label>
                                <select name="country" id="country" class="forminput">
                                    <option value="none">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}"
                                            {{ $user->country == $country ? 'selected' : '' }}>{{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 text-base uppercase bg-emerald-400 text-white rounded-md">Updated</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    </div>



</x-app-layout>

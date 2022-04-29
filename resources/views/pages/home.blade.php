@extends('layouts.default')
@section('content')

    @if ($message = Session::get('fileUploaded'))
        <x-previewModal></x-previewModal>
    @endif

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 items-center py-4 sm:pt-0">
        <form action="{{route('saveFile')}}" method="post" enctype="multipart/form-data">
          <h2 class="text-center mb-5 font-bloder ">Upload excel file</h2>
            @csrf
            @if ($message = Session::get('success'))
            <div class="bg-green-400">
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @if (count($errors) > 0)
                <div class="bg-red-100">
                    <ul class="list-disc">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-center items-center">
                <div class="mb-3 w-96">
                    <input class="form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="file" type="file" id="formFile">
                    <button type="submit" name="submit" class="inline-block  bg-primary-red text-white w-full mt-2 py-2 hover:bg-red-700  focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">
                    Upload file
                    </button>
                </div>
            </div>
            
        </form>
    </div>

@stop


@extends('layouts.default')
@section('content')


@if(!$costs->isEmpty())

    <x-table-data :data="$tableData">

    </x-table-data>

@else

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <form action="{{route('saveFile')}}" method="post" enctype="multipart/form-data">
          <h3 class="text-center mb-5">Upload excel file</h3>
            @csrf
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
          @endif
          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Select file</label>
                <button type="submit" name="submit" class="button-7">
                    Upload file
                </button>
            </div>
            
        </form>
    </div>
@endif

@stop


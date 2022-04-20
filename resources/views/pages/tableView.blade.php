@extends('layouts.default')
@section('content')

@if(!$costs->isEmpty())

    <x-table-data :data="$tableData">

    </x-table-data>

@else

    <div>no data</div>

@endif


@stop
@extends('appTestDatatable')

@section('contents')
    {!! $dataTable->table(['class' => 'table table-bordered'], true) !!}
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

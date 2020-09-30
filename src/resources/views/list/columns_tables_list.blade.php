@extends(backpack_view('layouts.top_left'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'Moderate' => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
  <div class="container-fluid">
    <h2>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
    </h2>
  </div>
@endsection

@section('content')
<div class="row">
    @foreach ($tables as $tableid => $table)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $table }} // {{ $tableid }}</h3>
            </div>
            <div class="card-body">
                <a href="{{ url($crud->route.'/?tableId='.$tableid.'') }}">Редактировать</a>
            </div><!-- /.card-footer-->
          </div><!-- /.card -->
    </div>
    @endforeach
</div>
@endsection
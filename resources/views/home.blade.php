@extends('layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    {{-- <router-view></router-view>
    <vue-progress-bar></vue-progress-bar> --}}
    {{-- @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
    @endif --}}
    <master></master>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@extends('formtech::index')

@section('page-title', $page->title)

@section('content')

    @include('formtech::layouts.' . $page->getData('layout'))

@endsection
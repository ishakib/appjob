@extends('emails.layouts.master')

@section('body')

    @include('emails.components.message')

    @include('emails.components.button', [])

    @include('emails.components.message-bottom', [])

@endsection
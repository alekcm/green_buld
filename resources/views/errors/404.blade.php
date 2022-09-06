@extends('errors::minimal')

@section('title', __('error.not_found'))
@section('code', '404')
@section('message', __('error.not_found'))
@section('go_back', __('error.go_back_web'))

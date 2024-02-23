@extends('frontpage.layouts.main')

@section('content')
    @include('frontpage.home.part.head')

    <!-- <section> close ============================-->
    <!-- ============================================-->

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    @include('frontpage.home.part.best_deals')
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    @include('frontpage.home.part.exclusive')
    <!-- <section> close ============================-->
    <!-- ============================================-->



    @include('frontpage.home.part.checkout_new_arrivals')


    @include('frontpage.home.part.by_category')

    <!-- ============================================-->
    <!-- <section> begin ============================-->

    @include('frontpage.home.part.collection')
    <!-- <section> close ============================-->
    <!-- ============================================-->


    @include('frontpage.home.part.best_sellers')



    <!-- ============================================-->
    <!-- <section> begin ============================-->

    @include('frontpage.home.part.category')
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->

    @include('frontpage.home.part.explore')
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    @include('frontpage.home.part.post')

    <!-- <section> close ============================-->
    <!-- ============================================-->

    @include('frontpage.home.part.store')
@endsection
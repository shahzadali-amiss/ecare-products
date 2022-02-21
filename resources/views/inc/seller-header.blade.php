<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <title>MAHIR BHARAT | Online Store</title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="AtaaHai - Bootstrap E-commerce Template">
    <meta name="keywords" content="bootstrap, shop, e-commerce, market, modern, responsive,  business, mobile, bootstrap, html5, css3, js, gallery, slider, touch, creative, clean">
    <meta name="author" content="">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{asset('css/bootstrap.min.css')}}"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{asset('css/theme.min.css')}}">
    <link rel="stylesheet" media="screen" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" media="screen" href="{{asset('css/mystyle.css')}}">
    @stack('styles')
</head>
  <!-- Body-->
<body class="handheld-toolbar-enabled">
    <main class="page-wrapper">
      <!-- Navbar Electronics Store-->
      <header class="bg-light shadow-sm navbar-sticky">
        @include('inc.seller-navbar-sticky')
      </header>
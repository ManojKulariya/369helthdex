@extends('admin.layout.index')
@section('title')
{{__("message.News")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.News")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.News")}}</li>
         </ol>
      </nav>
   </div>
</div>

@if(Session::has('message'))
<div class="adm-toast-wrap">
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show adm-toast" role="alert">{{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
</div>
@endif

{{-- ============ Send News form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4Z"/></svg>
            {{__("message.News")}}
         </div>
      </div>
      <form id="admNewsForm" action="{{route('post-news')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <div class="row">
            <div class="col-12 adm-field">
               <label for="description">{{__("message.Description")}}<span class="reqfield">*</span></label>
               <textarea id="description" name="news" required class="ckeditor form-control"></textarea>
            </div>
            <div class="col-12 adm-form-actions">
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4Z"/></svg>
                  {{__('message.Send News')}}
               </button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4Z"/></svg>
                  {{__('message.Send News')}}
               </button>
               @endif
               <a href="{{route('admin-dashboard')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. Field name ("news"), the route,
      and the CKEditor-backed #description textarea are unchanged. Genuine
      bugs fixed: the Cancel link was `href="javascript:void0;"` (missing
      parens — parses as a bare, undefined identifier reference, so the
      browser no-ops instead of navigating; same class of bug already found
      on the Branch User/SampleBoy forms) — now goes to the dashboard, since
      this single-purpose send form has no list page of its own to return
      to. The Description label's `for="name"` didn't match the textarea's
      real id (`description`), so clicking the label never focused it —
      fixed. Also dropped a dead default-value expression that referenced
      an isset($data->description) check — show_news() never passes a
      $data variable, so this always evaluated to an empty string;
      harmless but vestigial, and this form has no "edit" mode to prefill
      anyway.
      Added (per user's explicit choice): a confirm step before sending,
      reusing the same admNotify.confirm() popup already used for every
      Delete button elsewhere — this composes an email to every subscriber
      in the News table with no undo, and previously had zero confirmation.
      ========================================================================== */
   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq && window.admNotify) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });

   function init(jq) {
      var form = document.getElementById('admNewsForm');
      var confirmed = false;
      form.addEventListener('submit', function (e) {
         if (confirmed) { return; }
         e.preventDefault();
         admNotify.confirm(
            'This will email every subscriber. This can\'t be undone. Send now?',
            {title: 'Send newsletter?', confirmText: 'Send', cancelText: 'Cancel', danger: true}
         ).then(function (ok) {
            if (ok) {
               confirmed = true;
               form.submit();
            }
         });
      });
   }
</script>
@endsection

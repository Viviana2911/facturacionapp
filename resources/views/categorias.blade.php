@extends('crudbooster::admin_template')





@section('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">

        var buscar_cliente_url = "{{ url('clientes/buscar?texto=') }}";
        var buscar_prodcto_url = "{{ url('productos/buscar?texto=') }}";
        var comprobante_vistaprevia_url = "{{ url('comprobantes/vistaPrevia') }}";
    </script>
    <script src="{{ asset('js/forms/comprobantes.js') }}"></script>

    <div>

        @if(CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
            @if(g('return_url'))
                <p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i>
                        &nbsp; {{cbLang("form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
            @else
                <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i>
                        &nbsp; {{cbLang("form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
            @endif
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {!! $page_title !!}</strong>
            </div>

            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <?php
                $action = (@$row) ? CRUDBooster::mainpath("edit-save/$row->id") : CRUDBooster::mainpath("add-save");
                $return_url = ($return_url) ?: g('return_url');
                ?>

                    <form class='form-horizontal' method='post' id="formNuevoComprobante" enctype="multipart/form-data" action='{{$action}}'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type='hidden' name='return_url' value='{{ @$return_url }}'/>
                        <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}'/>
                        <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}'/>
                        @if($hide_form)
                            <input type="hidden" name="hide_form" value='{!! serialize($hide_form) !!}'>
                        @endif
                        <div class="modal-body">
                            <div class="box-body" id="parent-form-area">


                                <div class="form-group header-group-0 col-sm-12" id="form-group-identificacion" style="">
                                    <label class="control-label col-sm-3">
                                        Nombre
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <input type="text" title="Nombre" required="" placeholder="Ingrese el nombre de la categorias" minlength="" class="form-control" name="nombre" id="nombre" value="" >
                                        <h5>Ej. Avatar</h5>
                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>

                                    </div>
                                </div>
                               </div>
                        </div>

                        <div class="box-footer" style="background: #F5F5F5">

<div class="form-group">
    <label class="control-label col-sm-2"></label>
    <div class="col-sm-10">
        @if($button_cancel && CRUDBooster::getCurrentMethod() != 'getDetail')
            @if(g('return_url'))
                <a href='{{g("return_url")}}' class='btn btn-default'><i
                        class='fa fa-chevron-circle-left'></i> {{cbLang("button_back")}}</a>
            @else
                <a href='{{CRUDBooster::mainpath("?".http_build_query(@$_GET)) }}' class='btn btn-default'><i
                        class='fa fa-chevron-circle-left'></i> {{cbLang("button_back")}}</a>
            @endif
        @endif
        @if(CRUDBooster::isCreate() || CRUDBooster::isUpdate())

            @if(CRUDBooster::isCreate() && $button_addmore==TRUE && $command == 'add')
                <input type="submit" name="submit" value='{{cbLang("button_save_more")}}' class='btn btn-success'>
            @endif

            @if($button_save && $command != 'detail')
                <input type="submit" name="submit" value='{{cbLang("button_save")}}' class='btn btn-success'>
            @endif

        @endif
    </div>
</div>


</div><!-- /.box-footer-->
                    </form>

            </div>


        </div>
    </div><!--END AUTO MARGIN-->

    <script type="text/javascript">
    $("#formNuevoComprobante").validate({

        rules:{
        
          nombre:{
            required:true
          }
        },
        messages:{
          
          nombre:{
            required:"Ingrese el  nombre de la categoria"
          }

        }
      });

        </script>



@endsection

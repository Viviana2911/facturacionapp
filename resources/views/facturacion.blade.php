@extends('crudbooster::admin_template')





@section('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<<<<<<< Updated upstream
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
=======
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js">
</script>
>>>>>>> Stashed changes
    <script type="text/javascript">

        var buscar_cliente_url = "{{ url('clientes/buscar?texto=') }}";
        var buscar_prodcto_url = "{{ url('productos/buscar?texto=') }}";
        var comprobante_vistaprevia_url = "{{ url('comprobantes/vistaPrevia') }}";
        var validador=1;

        var form = document.forms['formNuevoCliente'];
        form.click = function(e){
            e.preventDefault();
            btnRegistrarNuevoCliente();
            return false;
            //document.getElementById('print').innerHTML=select.toUpperCase();
        }


        function btnRegistrarNuevoCliente(e){
            e.preventDefault();

            var formObj = {};
            var inputs = $('#formNuevoCliente').serializeArray();
            $.each(inputs, function (i, input) {
                formObj[input.name] = input.value;
            });


            var identificacion2 = formObj['identificacion2'];
            var nombres = formObj['nombres'];
            var correo = formObj['correo'];
            var telefono = formObj['telefono'];
            var direccion = formObj['direccion'];
            var tipo = formObj['tipo'];
            var str = identificacion2 + '&nombres=' + nombres + '&correo=' + correo + '&telefono=' + telefono + '&direccion=' + direccion + '&tipo=' + tipo;
            var url = "{{ url('facturas/registrar/cliente?identificacion2=') }}" + str;
            //var url = buscar_cliente_url + str;
            $.get(url, function (data) {
                console.log(data["clientes"]["id"]);
                swal(data["cab"], data["message"], data["message_type"]);
                var clientes = data["clientes"];
                if (data["message_type"] == 'success') {
                    console.log(data["message_type"]);
                    $('#modalRegistrarCliente').modal('hide');
                    $('#modalAgregarCliente').modal('hide');
                    $('input#identificacion').val(identificacion2);
                    $('input#nombres').val(nombres);
                    $('input#telefono').val(telefono);
                    $('input#direccion').val(direccion);
                    $('input#correo').val(correo);
                    $('input#hiddenCliente').val(clientes['id']);
                } else {
                }
            });

        }
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

                    <div class="box-body" id="parent-form-area">

                        <div class="form-group form-datepicker header-group-0 " id="form-group-fecha_emision" style="">
                            <label class="control-label col-sm-2">Fecha Actual
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <div class="input-group">
                                    <span class="input-group-addon open-datetimepicker"><a><i class="fa fa-calendar "></i></a></span>
                                    <input type="date" title="Fecha Emisión" readonly="" required="" class="form-control notfocus input_date" name="fecha_emision" id="fecha_emision" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>

                            <label class="control-label col-sm-2">Hora Actual
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <div class="input-group">
                                    <span class="input-group-addon open-datetimepicker"><a><i class="fa fa-calendar "></i></a></span>
                                    <input type="time" title="Hora Emisión" readonly="" required="" class="form-control notfocus input_date" name="hora_emision" id="hora_emision" value="{{date('H:i')}}">
                                </div>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>

                            <label class="control-label col-sm-1">Factura #:
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="number" step="1" title="Secuencial" required="" class="form-control" name="secuencial" id="secuencial" value="{{$facturero->inicio_facturero}}" readonly>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <hr>

                        <!--Datos del cliente-->
                        <div class="input-group">

                        </div>


                        <div class="form-group header-group-0 " id="form-group-cliente_id" style="">
                            <label class="control-label col-sm-2">Buscar Cliente
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>


                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="hiddenCliente" type="hidden" name="cliente_id" value="">
                                    <input id="hiddenConsumidor" type="hidden" name="consumidor_final_id" value="{{$cliente ? $cliente->id : $consumidor_final->id}}">
                                    <input name="cliente" type="text" id="txtCliente" placeholder="Ingrese los Nombres, razón social, cédula o ruc" oninvalid="this.setCustomValidity('Debe ingresar el nombre o la razón social del cliente')" oninput="setCustomValidity('')" class="form-control" disabled>
                                    <div class="input-group-btn">
                                    <button id="btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente" class="btn btn-default" disabled>
                                        <i class="fa fa-search "></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="text-danger">
                                </div><!--end-text-danger-->
                            </div>

                            <label class="control-label col-sm-1">Consumidor Final
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-1">
                                <input onchange="check(this)" type="checkbox" name="consumidor" id="consumidor" value="S" {{$cliente ? '' : 'checked'}}>
                            </div>

                            <label class="control-label col-sm-2">Cédula/Ruc
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Identificacion" required="" class="form-control" name="identificacion" id="identificacion" value="{{$cliente ? $cliente->identificacion : $consumidor_final->identificacion}}" readonly>
                            </div>
                        </div>

                        <div class="form-group header-group-0 " id="form-group-total_sin_impuestos" style="">
                            <label class="control-label col-sm-2">Nombres
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-3">
                                <input type="text" title="Nombres" required="" class="form-control" name="nombres" id="nombres" value="{{$cliente ? $cliente->nombres : $consumidor_final->nombres}}" {{$cliente ? '' : 'readonly'}}>
                            </div>

                            <label class="control-label col-sm-1">Teléfono
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Teléfono" required=""  class="form-control" name="telefono" id="telefono" value="{{$cliente ? $cliente->telefono : $consumidor_final->telefono}}" {{$cliente ? '' : 'readonly'}}>
                            </div>

                            <label class="control-label col-sm-1">Correo
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Correo" required="" class="form-control" name="correo" id="correo" value="{{$cliente ? $cliente->correo : $consumidor_final->correo}}" {{$cliente ? '' : 'readonly'}}>
                            </div>
                        </div>

                        <div class="form-group header-group-0" id="form-group-total_sin_impuestos" style="">
                            <label class="control-label col-sm-2">Dirección
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-3">
                                <input type="text" title="Dirección" required="" class="form-control" name="direccion" id="direccion" value="{{$cliente ? $cliente->direccion : $consumidor_final->direcccion}}" {{$cliente ? '' : 'readonly'}}>
                            </div>
                        </div>
                        <!--Fin Datos del cliente-->
                        <hr>

                        <!--Detalle factura-->

                        <div class="row col-md-12 form_venta_contado form_factura_credito form_devolucion_contado form_compra_contado">
                            <div class="col-md-7">
                                <div class="input-group pull-right">
                                    <input type="text" class="form-control" id="txtAgregarArticulo" list="listaBusquedaProducto" placeholder="Agregar un artículo..." onkeydown="if (event.keyCode == 13) return false;" tabindex="1">
                                    <div class="input-group-btn">
                                        <button id="btnAgregarArticulo" class="btn btn-default">
                                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <datalist id="listaBusquedaProducto">
                                <!--
                                <option value="a"/>
                                <option value="b"/>
                                <option value="c"/>
                                -->
                            </datalist>
                        </div>

                        <div class="col-md-12 pre-scrollable div-detalle-comprobante form_venta_contado form_factura_credito form_devolucion_contado form_compra_contado">
                            <table width="100%" class="table-condensed table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center" width="100px">Código</th>
                                    <th class="text-center">Artículo</th>
                                    <th class="text-center" width="80px">Precio</th>
                                    <th class="text-center" width="75px">Cantidad</th>
                                    <th class="text-center" width="80px">Subtotal</th>
                                    <th class="text-center" width="80px">IVA</th>
                                    <th class="text-center" width="100px">Total</th>
                                    
                                </tr>
                                </thead>
                                <tbody id="tablaProductos">

                                </tbody>
                            </table>

                            <div class="col-md-6 form_venta_contado form_factura_credito form_devolucion_contado form_compra_contado">

                            </div>
                            <div class="col-md-6 form_venta_contado form_factura_credito form_devolucion_contado form_compra_contado">
                                <table class="table-condensed pull-right table-striped">
                                    <thead id="tablaResumen">

                                    </thead>
                                </table>
                            </div>

                        </div>


                        {{--
                        <div class="form-group header-group-0 " id="form-group-total_sin_impuestos" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Total Sin Impuestos
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Total Sin Impuestos" required="" class="form-control inputMoney" name="total_sin_impuestos" id="total_sin_impuestos" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-subtotal_12" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Subtotal 12
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Subtotal 12" required="" class="form-control inputMoney" name="subtotal_12" id="subtotal_12" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-subtotal_0" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Subtotal 0
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Subtotal 0" required="" class="form-control inputMoney" name="subtotal_0" id="subtotal_0" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-subtotal_no_iva" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Subtotal No Iva
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Subtotal No Iva" required="" class="form-control inputMoney" name="subtotal_no_iva" id="subtotal_no_iva" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-subtotal_extento_iva" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Subtotal Extento Iva
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Subtotal Extento Iva" required="" class="form-control inputMoney" name="subtotal_extento_iva" id="subtotal_extento_iva" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-total_ice" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Total Ice
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Total Ice" required="" class="form-control inputMoney" name="total_ice" id="total_ice" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-total_iva" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Total Iva
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Total Iva" required="" class="form-control inputMoney" name="total_iva" id="total_iva" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-total_descuento" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Total Descuento
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Total Descuento" required="" class="form-control inputMoney" name="total_descuento" id="total_descuento" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-total_propina" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Total Propina
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Total Propina" required="" class="form-control inputMoney" name="total_propina" id="total_propina" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-total_valor" style="">
                            <label class="control-label col-sm-offset-8 col-sm-2">Total Valor
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Total Valor" required="" class="form-control inputMoney" name="total_valor" id="total_valor" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        --}}
                        <input id="hiddenListado" type="hidden" name="listadoArticulos">
                        <div class="form-group header-group-0 " id="form-group-observacion" style="">
                            <label class="control-label col-sm-2">Observacion
                            </label>
                            <div class="col-sm-10">
                                <textarea name="observacion" id="observacion" maxlength="5000" class="form-control" rows="5"></textarea>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>

                        <div class="form-group header-group-0 " id="form-group-forma_pago_id" style="">
                            <label class="control-label col-sm-2">Forma Pago
                                <span class="text-danger" title="Este campo es requerido">*</span>
                            </label>

                            <div class="col-sm-10">
                                <select class="form-control select2-hidden-accessible" id="forma_pago_id" required="" name="forma_pago_id" tabindex="-1" aria-hidden="true">
                                    <option value="">** Selecciona una forma de pago</option>
                                    @foreach($formapagos as $k=>$v)
                                        @if ($loop->first)
                                            <option value="{{$k}}" selected>{{$v}}</option>
                                        @else
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="text-danger">

                                </div><!--end-text-danger-->
                                <p class="help-block"></p>

                            </div>

                            <label class="control-label col-sm-2">

                            </label>

                            <div class="col-sm-2">
                                <input type="text" title="Ingrese el valor" class="form-control" name="pago" id="pago"  placeholder="Ingrese el valor del pago" onkeyup="return devolucionfunc()" required>
                                <div class="text-danger">
                                </div><!--end-text-danger-->
                                <p class="help-block"></p>
                            </div>

                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" title="Devolución" required="" class="form-control" name="devolucion" id="devolucion" value="" placeholder="Valor devolución" disabled>
                                    <div class="input-group-btn">
                                        <div class="btn btn-default" onclick="devolucionfunc()">
                                            <i class="fa fa-refresh "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer" style="background: #F5F5F5">

                        <div class="form-group">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">

                                        <a href='{{CRUDBooster::mainpath("?".http_build_query(@$_GET)) }}' class='btn btn-default'><i
                                                class='fa fa-chevron-circle-left'></i> {{cbLang("button_back")}}</a>

                                        <input type="submit" name="submit" value='Guardar e Imprimir' class='btn btn-success'>

                            </div>
                        </div>


                    </div><!-- /.box-footer-->

                </form>

            </div>
        </div>
    </div><!--END AUTO MARGIN-->

    <div class="modal fade" id="modalAgregarCliente" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <b>Buscar cliente</b>
                        <span class="pull-right">
                        <button id="btnRegistrarCliente" data-toggle="modal" data-target="#modalRegistrarCliente" class="btn btn-success">
							<i class="fa fa-user-plus" aria-hidden="true"></i> Agregar nuevo cliente
                        </button>
					</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="sr-only">Buscar cliente</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <input id="txtBuscadorCliente" class="form-control" type="text" name="BuscadorCliente" placeholder="Buscar cliente...">
                                </div>
                                <div class="col-md-2">
                                    <button id="btnBuscarCliente" type="submit" class="btn btn-warning btn-block">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <hr/>
                            <table width="100%" class="table-condensed table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Nombre / Razón Social</th>
                                    <th width="20%">RUC</th>
                                    <th width="20%">Telefono</th>
                                    <th width="20%">Mail</th>
                                    <th width="20%">Dirección</th>
                                    <th width="5%"></th>
                                </tr>
                                </thead>
                                <tbody id="tablaClientes">

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button id="btnOkModalAgregarCliente" class="btn btn-success" data-dismiss="modal">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistrarCliente" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <b>Agregar nuevo cliente</b>
                        <span class="pull-right">
                            <button class="btn btn-success btn-sm text-center" data-dismiss="modal">
                                <i class="fa fa-close" aria-hidden="true"></i> <b>Cerrar</b>
                            </button>
					    </span>
                    </h4>
                </div>
                <form onsubmit="btnRegistrarNuevoCliente(event);" id="formNuevoCliente" name="formNuevoCliente" action="">
                    <div class="modal-body">
                        <div class="box-body" id="parent-form-area">

                                <div class="form-group header-group-0 col-sm-12" id="form-group-tipo" style="">
                                    <label class="control-label col-sm-3">Tipo
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <select class="form-control" id="tipo" data-value="" required=""  name="tipo" onchange="getIdentificacion(this)">
                                            <option value="">** Selecciona un Tipo</option>
                                            @foreach($tipo_documentos as $tipo)
                                                <option value="{{$tipo->id}}">{{$tipo->nombres}}</option>
                                            @endforeach
                                        </select>
                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="form-group header-group-0 col-sm-12" id="form-group-identificacion" style="">
                                    <label class="control-label col-sm-3">
                                        Identificación
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <input type="text" title="Identificación" required="" placeholder="Ingrese la identificación" maxlength="255" class="form-control" name="identificacion2" id="identificacion2" value="" onKeyPress="return soloNumeros(event)" >

                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>

                                    </div>
                                </div>
                                <div class="form-group header-group-0 col-sm-12" id="form-group-nombres" style="">
                                    <label class="control-label col-sm-3">
                                        Nombres
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <input type="text" title="Nombres" required="" placeholder="Ingrese la nombre" maxlength="255" class="form-control" name="nombres" id="nombres" value="">

                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>

                                    </div>
                                </div>
                                <div class="form-group header-group-0 col-sm-12" id="form-group-correo" style="">
                                    <label class="control-label col-sm-3">Correo
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input type="email" name="correo" style="display: none">
                                            <input type="email" title="Correo" required="" maxlength="255" class="form-control" name="correo" id="correo" value="">
                                        </div>
                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="form-group header-group-0 col-sm-12" id="form-group-telefono" style="">
                                    <label class="control-label col-sm-3">Teléfono
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>

                                    <div class="col-sm-8">
                                        <input type="number" step="1" title="Teléfono" required="" min="1" class="form-control" name="telefono" id="telefono" value="">
                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="form-group header-group-0 col-sm-12" id="form-group-direccion" style="">
                                    <label class="control-label col-sm-3">Dirección
                                        <span class="text-danger" title="Este campo es requerido">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea name="direccion" id="direccion" required="" maxlength="255" class="form-control" rows="2"></textarea>
                                        <div class="text-danger"></div>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-plus" aria-hidden="true"></i> Guardar
                        </button>
                    </div>
                </form>
<<<<<<< Updated upstream

=======
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary " onclick="btnRegistrarNuevoCliente()">
                        <i class="btn fa fa-save" aria-hidden="true"> <b>Guardar</b></i>
                    </button>
                 
                </div>
>>>>>>> Stashed changes
            </div>
        </div>
    </div>



    <script type="text/javascript">
    $("#formNuevoCliente").validate({

        rules:{
        
          nombres:{
            required:true
          }
        },
        messages:{
          
          nombres:{
            required:"Ingrese el  nombre"
          }

        }
      });

        </script>
@endsection

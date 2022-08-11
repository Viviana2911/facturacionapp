<?php namespace App\Http\Controllers;

	use App\Models\Clientes;
    use App\Models\ConsumidorFinal;
    use App\Models\Factura;
    use App\Models\FacturaDetalle;
    use App\Models\Facturero;
    use App\Models\FormasPago;
    use App\Models\Productos;
    use App\Models\TipoDocumento;
    use crocodicstudio\crudbooster\helpers\CB;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\Validator;
    use Session;
	use DB;
	use CRUDBooster;

	class AdminClientesController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "clientes";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Identificación","name"=>"identificacion"];
			$this->col[] = ["label"=>"Nombres","name"=>"nombres"];
			$this->col[] = ["label"=>"Correo","name"=>"correo"];
			$this->col[] = ["label"=>"Teléfono","name"=>"telefono"];
			$this->col[] = ["label"=>"Dirección","name"=>"direccion"];
			$this->col[] = ["label"=>"Tipo","name"=>"tipo_documento_id","join"=>"tipo_documento,nombres"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Tipo','name'=>'tipo_documento_id','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'tipo_documento,nombres'];
			$this->form[] = ['label'=>'Identificación','name'=>'identificacion','type'=>'text','validation'=>'required|min:1|max:255|unique:clientes','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nombres','name'=>'nombres','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Correo','name'=>'correo','type'=>'email','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Teléfono','name'=>'telefono','type'=>'number','validation'=>'required|min:10','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Dirección','name'=>'direccion','type'=>'textarea','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Tipo','name'=>'tipo','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'tipo_documento,nombres'];
			//$this->form[] = ['label'=>'Identificación','name'=>'identificacion','type'=>'text','validation'=>'required|min:1|max:255|unique:clientes','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nombres','name'=>'nombres','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Correo','name'=>'correo','type'=>'email','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Teléfono','name'=>'telefono','type'=>'number','validation'=>'required|min:1','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Dirección','name'=>'direccion','type'=>'textarea','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# OLD END FORM

			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        |
	        */
	        $this->sub_module = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        |
	        */
	        $this->addaction = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Button Selected
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button
	        | Then about the action, you should code at actionButtonSelected method
	        |
	        */
	        $this->button_selected = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------
	        | @message = Text of message
	        | @type    = warning,success,danger,info
	        |
	        */
	        $this->alert        = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add more button to header button
	        | ----------------------------------------------------------------------
	        | @label = Name of button
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        |
	        */
	        $this->index_button = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
	        |
	        */
	        $this->table_row_color = array();


	        /*
	        | ----------------------------------------------------------------------
	        | You may use this bellow array to add statistic at dashboard
	        | ----------------------------------------------------------------------
	        | @label, @count, @icon, @color
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add javascript at body
	        | ----------------------------------------------------------------------
	        | javascript code in the variable
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ----------------------------------------------------------------------
	        | Include HTML Code before index table
	        | ----------------------------------------------------------------------
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;



	        /*
	        | ----------------------------------------------------------------------
	        | Include HTML Code after index table
	        | ----------------------------------------------------------------------
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;



	        /*
	        | ----------------------------------------------------------------------
	        | Include Javascript File
	        | ----------------------------------------------------------------------
	        | URL of your javascript each array
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add css style at body
	        | ----------------------------------------------------------------------
	        | css code in the variable
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;



	        /*
	        | ----------------------------------------------------------------------
	        | Include css File
	        | ----------------------------------------------------------------------
	        | URL of your css each array
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();

	    }


        public function getAdd()
        {

            $this->cbLoader();
            if (! CRUDBooster::isCreate() && $this->global_privilege == false || $this->button_add == false) {
                CRUDBooster::insertLog(cbLang('log_try_add', ['module' => CRUDBooster::getCurrentModule()->name]));
                CRUDBooster::redirect(CRUDBooster::adminPath(), cbLang("denied_access"));
            }

            $page_title = cbLang("add_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name]);
            $page_menu = Route::getCurrentRoute()->getActionName();
            $command = 'add';

            $consumidor_final = ConsumidorFinal::first();
            $tipo_documentos = TipoDocumento::get();

            return view('clientes', compact('page_title', 'page_menu', 'command', 'consumidor_final', 'tipo_documentos'));
        }

        public function postAddSave() {
            $this->cbLoader();
            if (! CRUDBooster::isCreate() && $this->global_privilege == false) {
                CRUDBooster::insertLog(trans('crudbooster.log_try_add_save', [
                    'name' => \http\Client\Request::input($this->title_field),
                    'module' => CRUDBooster::getCurrentModule()->name,
                ]));
                CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
            }



            //Permite recibir toda la informacion ingresada en el formulario de facturacion
            $request=Request()->request->all();
            //dd( $request);
            //dd('entro aqui ');

            $row = Clientes::where('identificacion',$request['identificacion2'])->first();
            $this->validation($row->id);
            $this->input_assignment($row->id);

            //dd($this->validation($row->id));

            if (Schema::hasColumn($this->table, 'created_at')) {
                $this->arr['created_at'] = date('Y-m-d H:i:s');
            }

            $cliente = new Clientes();
            $cliente->identificacion = $request['identificacion2'];
            $cliente->tipo_documento_id = $request['tipo'];
            $cliente->nombres = $request['nombres'];
            $cliente->correo = $request['correo'];
            $cliente->telefono = $request['telefono'];
            $cliente->direccion = $request['direccion'];
            $cliente->save();

            $this->return_url = ($this->return_url) ? $this->return_url : request('return_url');
            //insert log
            CRUDBooster::insertLog(cbLang("log_add", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]));

            if ($this->return_url) {
                if (request('submit') == cbLang('button_save_more')) {
                    CRUDBooster::redirect(\Illuminate\Support\Facades\Request::server('HTTP_REFERER'), cbLang("alert_add_data_success"), 'success');
                } else {
                    CRUDBooster::redirect($this->return_url, cbLang("alert_add_data_success"), 'success');
                }
            } else {
                if (request('submit') == cbLang('button_save_more')) {
                    CRUDBooster::redirect(CRUDBooster::mainpath('add'), cbLang("alert_add_data_success"), 'success');
                } else {
                    CRUDBooster::redirect(CRUDBooster::mainpath(), cbLang("alert_add_data_success"), 'success');
                }
            }
        }

        public function getEdit($id)
        {
            $this->cbLoader();
            $row = \Illuminate\Support\Facades\DB::table($this->table)->where($this->primary_key, $id)->first();

            if (! CRUDBooster::isRead() && $this->global_privilege == false || $this->button_edit == false) {
                CRUDBooster::insertLog(cbLang("log_try_edit", [
                    'name' => $row->{$this->title_field},
                    'module' => CRUDBooster::getCurrentModule()->name,
                ]));
                CRUDBooster::redirect(CRUDBooster::adminPath(), cbLang('denied_access'));
            }


            $page_menu = Route::getCurrentRoute()->getActionName();
            $page_title = cbLang("edit_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name, 'name' => $row->{$this->title_field}]);
            $command = 'edit';
            \Illuminate\Support\Facades\Session::put('current_row_id', $id);
            $tipo_documentos = TipoDocumento::get();

            return view('clientesEdit', compact('id', 'row', 'page_menu', 'page_title', 'command','tipo_documentos'));
        }

        /*
        | ----------------------------------------------------------------------
        | Hook for button selected
        | ----------------------------------------------------------------------
        | @id_selected = the id selected
        | @button_name = the name of button
        |
        */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here

	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate query of index result
	    | ----------------------------------------------------------------------
	    | @query = current sql query
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	//Your code here
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before update data is execute
	    | ----------------------------------------------------------------------
	    | @postdata = input post data
	    | @id       = current id
	    |
	    */
	    public function hook_before_edit(&$postdata,$id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }


        public function buscar(Request $request){
            $texto = $request->texto;
            $clientes = Clientes::FiltrarPorNombres($texto)
                ->FiltrarPorIdentificacion($texto)
                ->paginate(25);
            return Response()->json([
                'clientes' => $clientes
            ]);
        }

        public function buscarConsumidorFinal(){
            $clientes = ConsumidorFinal::first();
            return Response()->json([
                'clientes' => $clientes
            ]);
        }

	    //By the way, you can still create your own method in here... :)

        public function validation($id = null)
        {

            $request_all = \Illuminate\Support\Facades\Request::all();
            $array_input = [];
            foreach ($this->data_inputan as $di) {
                $ai = [];
                $name = $di['name'];

                if (! isset($request_all[$name])) {
                    continue;
                }

                if ($di['type'] != 'upload') {
                    if (@$di['required']) {
                        $ai[] = 'required';
                    }
                }

                if ($di['type'] == 'upload') {
                    if ($id) {
                        $row = \Illuminate\Support\Facades\DB::table($this->table)->where($this->primary_key, $id)->first();
                        if ($row->{$di['name']} == '') {
                            $ai[] = 'required';
                        }
                    }
                }

                if (@$di['min']) {
                    $ai[] = 'min:'.$di['min'];
                }
                if (@$di['max']) {
                    $ai[] = 'max:'.$di['max'];
                }
                if (@$di['image']) {
                    $ai[] = 'image';
                }
                if (@$di['mimes']) {
                    $ai[] = 'mimes:'.$di['mimes'];
                }
                $name = $di['name'];
                if (! $name) {
                    continue;
                }

                if ($di['type'] == 'money') {
                    $request_all[$name] = preg_replace('/[^\d-]+/', '', $request_all[$name]);
                }

                if ($di['type'] == 'child') {
                    $slug_name = str_slug($di['label'], '');
                    foreach ($di['columns'] as $child_col) {
                        if (isset($child_col['validation'])) {
                            //https://laracasts.com/discuss/channels/general-discussion/array-validation-is-not-working/
                            if (strpos($child_col['validation'], 'required') !== false) {
                                $array_input[$slug_name.'-'.$child_col['name']] = 'required';

                                str_replace('required', '', $child_col['validation']);
                            }

                            $array_input[$slug_name.'-'.$child_col['name'].'.*'] = $child_col['validation'];
                        }
                    }
                }

                if (@$di['validation']) {

                    $exp = explode('|', $di['validation']);
                    if ($exp && count($exp)) {
                        foreach ($exp as &$validationItem) {
                            if (substr($validationItem, 0, 6) == 'unique') {
                                $parseUnique = explode(',', str_replace('unique:', '', $validationItem));
                                $uniqueTable = ($parseUnique[0]) ?: $this->table;
                                $uniqueColumn = ($parseUnique[1]) ?: $name;
                                $uniqueIgnoreId = ($parseUnique[2]) ?: (($id) ?: '');

                                //Make sure table name
                                $uniqueTable = CB::parseSqlTable($uniqueTable)['table'];

                                //Rebuild unique rule
                                $uniqueRebuild = [];
                                $uniqueRebuild[] = $uniqueTable;
                                $uniqueRebuild[] = $uniqueColumn;
                                if ($uniqueIgnoreId) {
                                    $uniqueRebuild[] = $uniqueIgnoreId;
                                } else {
                                    $uniqueRebuild[] = 'NULL';
                                }

                                //Check whether deleted_at exists or not
                                if (CB::isColumnExists($uniqueTable, 'deleted_at')) {
                                    $uniqueRebuild[] = CB::findPrimaryKey($uniqueTable);
                                    $uniqueRebuild[] = 'deleted_at';
                                    $uniqueRebuild[] = 'NULL';
                                }
                                $uniqueRebuild = array_filter($uniqueRebuild);
                                $validationItem = 'unique:'.implode(',', $uniqueRebuild);
                            }
                        }
                    } else {
                        $exp = [];
                    }

                    $validation = implode('|', $exp);

                    $array_input[$name] = $validation;
                } else {
                    $array_input[$name] = implode('|', $ai);
                }
            }

            $validator = Validator::make($request_all, $array_input);

            if ($validator->fails()) {
                $message = $validator->messages();
                $message_all = $message->all();

                if (Request::ajax()) {
                    $res = response()->json([
                        'message' => cbLang('alert_validation_error', ['error' => implode(', ', $message_all)]),
                        'message_type' => 'warning',
                    ])->send();
                    exit;
                } else {
                    $res = redirect()->back()->with("errors", $message)->with([
                        'message' => cbLang('alert_validation_error', ['error' => implode(', ', $message_all)]),
                        'message_type' => 'warning',
                    ])->withInput();
                    \Session::driver()->save();
                    $res->send();
                    exit;
                }
            }
        }



    }

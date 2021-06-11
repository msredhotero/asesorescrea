<?php

date_default_timezone_set('America/Mexico_City');

/*
* DEBO VERIFICAR EN LAS ALERTAS SI LA POLIZA ES DE LA PROMOTORIA O DE UN AGENTE
*
*
*/
class serviciosAsegurados
{

   function devolverFormPorProducto($idproducto,$cadRefEstadoCivil,$rIdCliente) {

        $formAsegurados	= '';
        $formBeneficiario	= '';
        $formReglasAsegurado = array();
        $formReglasBeneficiario = array();

        switch ($idproducto) {
            //vrim platinum
            case 41:
                $formReglasAsegurado = array('nombre','apellidopaterno','apellidomaterno','fechanacimiento','genero','refestadocivil','reftipoparentesco');
                $formReglasBeneficiario = array('nombre','apellidopaterno','apellidomaterno','fechanacimiento','genero','refestadocivil','reftipoparentesco');

                $formAsegurados	= '<form class="formulario frmNuevoASG" role="form" id="sign_in">
                <div class="modal fade" id="lgmNuevoASG" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xlg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="largeModalLabel">CARGAR NUEVO ASEGURADO</h4>
                            </div>
                            <div class="modal-body">
                                     <div class="row">
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContnombre" style="display:block">
                                             <label class="form-label">Nombre Completo <span style="color:red;">*</span> </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="nombreASG" name="nombre"  required />
         
                                                 </div>
                                             </div>
                                         </div>
         
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
                                             <label class="form-label">Apellido Paterno  <span style="color:red;">*</span> </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="apellidopaternoASG" name="apellidopaterno"  required />
         
                                                 </div>
                                             </div>
                                         </div>
         
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidomaterno" style="display:block">
                                             <label class="form-label">Apellido Materno  <span style="color:red;">*</span> </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="apellidomaternoASG" name="apellidomaterno"  required />
         
                                                 </div>
                                             </div>
                                         </div>
         
                                         
                                     </div>
                                     <div class="row" style="margin-top:15px;">
         
                                         <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContfechanacimiento" style="display:block">
                                             <label class="form-label">Fecha De Nacimiento <span style="color:red;">*</span>  </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="fechanacimientoASG" name="fechanacimiento" required READONLY/>
                                                 </div>
                                             </div>
                                         </div>
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContgenero" style="display:block">
                                             <label class="form-label">Genero <span style="color:red;">*</span>  </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <select class="form-control" id="generoASG" name="genero"  required >
                                                         <option value="">-- Seleccionar --</option>
                                                         <option value="Femenino">Femenino</option>
                                                         <option value="Masculino">Masculino</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrefestadocivil" style="display:block">
                                             <label class="form-label">Estado Civil <span style="color:red;">*</span>  </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <select class="form-control" id="refestadocivilASG" name="refestadocivil"  required >
                                                         <option value="">-- Seleccionar --</option>
                                                         '.$cadRefEstadoCivil.'
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
         
                                     </div>
         
         
                                     <div class="row" style="margin-top:15px;">
         
         
                                         <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
                                         <input type="hidden" id="refclientesASG" name="refclientes" value="'.$rIdCliente.'"/>
                                     </div>
         
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect nuevoAsegurado">GUARDAR</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                 <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
             </form>';
                $formBeneficiario	= '<form class="formulario frmNuevoBNF" role="form" id="sign_in2">
                <div class="modal fade" id="lgmNuevoBNF" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xlg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="largeModalLabel">CARGAR NUEVO BENEFICIARIO</h4>
                            </div>
                            <div class="modal-body">
                                     <div class="row">
         
                                         <div class="row" style="margin-top:15px;">
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContnombre" style="display:block">
                                                 <label class="form-label">Nombre Completo  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="nombreBNF" name="nombre"  required />
         
                                                     </div>
                                                 </div>
                                             </div>
         
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
                                                 <label class="form-label">Apellido Paterno  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="apellidopaternoBNF" name="apellidopaterno"  required />
         
                                                     </div>
                                                 </div>
                                             </div>
         
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidomaterno" style="display:block">
                                                 <label class="form-label">Apellido Materno  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="apellidomaternoBNF" name="apellidomaterno"  required />
         
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContreftipoparentesco" style="display:block">
                                                 <label for="reftipoparentesco" class="control-label" style="text-align:left">Parentesco  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group col-md-12">
                                                     <div class="form-line">
                                                         <select class="form-control" id="reftipoparentescoBNF" name="reftipoparentesco"  required >
                                                             <option value="">-- Seleccionar --</option>
                                                             <option value="1">Padres</option>
                                                             <option value="2">Conyuge</option>
                                                             <option value="3">Hijos</option>
                                                             <option value="4">Otro</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContparentescoBNF" style="display:block">
                                                 <label class="form-label">Ingrese el Parentesco  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="parentescoBNF" name="parentesco" />
                                                     </div>
                                                 </div>
                                             </div>
         
                                         </div>
                                         <div class="row" style="margin-top:15px;">
         
                                             <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContfechanacimiento" style="display:block">
                                                 <label class="form-label">Fecha De Nacimiento  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="fechanacimientoBNF" name="fechanacimiento" required READONLY/>
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContgenero" style="display:block">
                                                 <label class="form-label">Genero <span style="color:red;">*</span>  </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <select class="form-control" id="generoBNF" name="genero"  required >
                                                             <option value="">-- Seleccionar --</option>
                                                             <option value="Femenino">Femenino</option>
                                                             <option value="Masculino">Masculino</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrefestadocivil" style="display:block">
                                                 <label class="form-label">Estado Civil <span style="color:red;">*</span>  </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <select class="form-control" id="refestadocivilBNF" name="refestadocivil"  required >
                                                             <option value="">-- Seleccionar --</option>
                                                             '.$cadRefEstadoCivil.'
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
         
                                         </div>
         
                                         <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
                                         <input type="hidden" id="refclientesBNF" name="refclientes" value="'.$rIdCliente.'"/>
                                     </div>
         
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect nuevoBeneficiario">GUARDAR</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                 <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
             </form>';
            break;
            //sevi
            case 28:
                $formAsegurados	= '';
                $formBeneficiario	= '';
            break;
            //vida 500
            case 54:
                $formReglasAsegurado = array('nombre','apellidopaterno','apellidomaterno','fechanacimiento','genero','refestadocivil','reftipoparentesco');
                $formReglasBeneficiario = array('nombre','apellidopaterno','apellidomaterno','fechanacimiento','genero','refestadocivil','reftipoparentesco');

                $formAsegurados	= '<form class="formulario frmNuevoASG" role="form" id="sign_in">
                <div class="modal fade" id="lgmNuevoASG" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xlg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="largeModalLabel">CARGAR NUEVO ASEGURADO</h4>
                            </div>
                            <div class="modal-body">
                                     <div class="row">
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContnombre" style="display:block">
                                             <label class="form-label">Nombre Completo <span style="color:red;">*</span> </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="nombreASG" name="nombre"  required />
         
                                                 </div>
                                             </div>
                                         </div>
         
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
                                             <label class="form-label">Apellido Paterno  <span style="color:red;">*</span> </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="apellidopaternoASG" name="apellidopaterno"  required />
         
                                                 </div>
                                             </div>
                                         </div>
         
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidomaterno" style="display:block">
                                             <label class="form-label">Apellido Materno  <span style="color:red;">*</span> </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="apellidomaternoASG" name="apellidomaterno"  required />
         
                                                 </div>
                                             </div>
                                         </div>
         
                                         
                                     </div>
                                     <div class="row" style="margin-top:15px;">
         
                                         <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContfechanacimiento" style="display:block">
                                             <label class="form-label">Fecha De Nacimiento <span style="color:red;">*</span>  </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <input type="text" class="form-control" id="fechanacimientoASG" name="fechanacimiento" required READONLY/>
                                                 </div>
                                             </div>
                                         </div>
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContgenero" style="display:block">
                                             <label class="form-label">Genero <span style="color:red;">*</span>  </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <select class="form-control" id="generoASG" name="genero"  required >
                                                         <option value="">-- Seleccionar --</option>
                                                         <option value="Femenino">Femenino</option>
                                                         <option value="Masculino">Masculino</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
         
                                         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrefestadocivil" style="display:block">
                                             <label class="form-label">Estado Civil <span style="color:red;">*</span>  </label>
                                             <div class="form-group input-group">
                                                 <div class="form-line">
                                                     <select class="form-control" id="refestadocivilASG" name="refestadocivil"  required >
                                                         <option value="">-- Seleccionar --</option>
                                                         '.$cadRefEstadoCivil.'
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
         
                                     </div>
         
         
                                     <div class="row" style="margin-top:15px;">
         
         
                                         <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
                                         <input type="hidden" id="refclientesASG" name="refclientes" value="'.$rIdCliente.'"/>
                                     </div>
         
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect nuevoAsegurado">GUARDAR</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                 <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
             </form>';
                $formBeneficiario	= '<form class="formulario frmNuevoBNF" role="form" id="sign_in2">
                <div class="modal fade" id="lgmNuevoBNF" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xlg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="largeModalLabel">CARGAR NUEVO BENEFICIARIO</h4>
                            </div>
                            <div class="modal-body">
                                     <div class="row">
         
                                         <div class="row" style="margin-top:15px;">
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContnombre" style="display:block">
                                                 <label class="form-label">Nombre Completo  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="nombreBNF" name="nombre"  required />
         
                                                     </div>
                                                 </div>
                                             </div>
         
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
                                                 <label class="form-label">Apellido Paterno  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="apellidopaternoBNF" name="apellidopaterno"  required />
         
                                                     </div>
                                                 </div>
                                             </div>
         
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidomaterno" style="display:block">
                                                 <label class="form-label">Apellido Materno  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="apellidomaternoBNF" name="apellidomaterno"  required />
         
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContreftipoparentesco" style="display:block">
                                                 <label for="reftipoparentesco" class="control-label" style="text-align:left">Parentesco  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group col-md-12">
                                                     <div class="form-line">
                                                         <select class="form-control" id="reftipoparentescoBNF" name="reftipoparentesco"  required >
                                                             <option value="">-- Seleccionar --</option>
                                                             <option value="1">Padres</option>
                                                             <option value="2">Conyuge</option>
                                                             <option value="3">Hijos</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContparentescoBNF" style="display:block">
                                                 <label class="form-label">Ingrese el Parentesco  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="parentescoBNF" name="parentesco" />
                                                     </div>
                                                 </div>
                                             </div>
         
                                         </div>
                                         <div class="row" style="margin-top:15px;">
         
                                             <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContfechanacimiento" style="display:block">
                                                 <label class="form-label">Fecha De Nacimiento  <span style="color:red;">*</span> </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <input type="text" class="form-control" id="fechanacimientoBNF" name="fechanacimiento" required READONLY/>
                                                     </div>
                                                 </div>
                                             </div>
         
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContgenero" style="display:block">
                                                 <label class="form-label">Genero <span style="color:red;">*</span>  </label>
                                                 <div class="form-group input-group">
                                                     <div class="form-line">
                                                         <select class="form-control" id="generoBNF" name="genero"  required >
                                                             <option value="">-- Seleccionar --</option>
                                                             <option value="Femenino">Femenino</option>
                                                             <option value="Masculino">Masculino</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
         
                                             
         
                                         </div>
         
                                         <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
                                         <input type="hidden" id="refclientesBNF" name="refclientes" value="'.$rIdCliente.'"/>
                                     </div>
         
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect nuevoBeneficiario">GUARDAR</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                 <input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
             </form>';
            break;
            //rc medicos pf
            case 28:
                $formAsegurados	= '';
                $formBeneficiario	= '';
            break;
        }

        return array('asegurado'=>$formAsegurados, 'beneficiario'=>$formBeneficiario, 'reglasAsegurado'=>$formReglasAsegurado, 'reglasBeneficiario' =>$formReglasBeneficiario);
    }

}



?>

<?php

date_default_timezone_set('America/Mexico_City');

/*
* DEBO VERIFICAR EN LAS ALERTAS SI LA POLIZA ES DE LA PROMOTORIA O DE UN AGENTE
*
*
*/
class serviciosLabel
{

   function devolverLabelPorTabla($tabla) {
      $lblCambio = '';
      $lblreemplazo = '';

      switch ($tabla) {
         case 'dbcotizaciones':
            $lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor','cobertura','reasegurodirecto','fecharenovacion','fechapropuesta','tiponegocio','presentacotizacion','fechavencimiento','coberturaactual','bitacoracrea','bitacorainbursa','bitacoraagente','existeprimaobjetivo','primaobjetivo','primaobjetivototal','refestados','reftipomoneda','folioagente');
            $lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor','Cobertura Requiere Reaseguro','Reaseguro Directo con Inbursa o Broker','Fecha renovación o presentación de propueta al cliente','Fecha en que se entrega propuesta','Tipo de negocio para agente','Presenta Cotizacion o Poliza de competencia','Fecha Vencimiento póliza Actual','Aseguradora con quien esta suscrita la póliza','Bitacora','Bitacora Inbursa','Bitacora Agente','Existe Prima Objetivo','Prima Objetivo Neta','Prima Objetivo Total','Etapa','Tipo Moneda','Folio del Agente');
         break;
         case 'tbproductos':
            $lblCambio	 	= array('reftipoproductorama','reftipodocumentaciones','puntosporventa','puntosporpesopagado','refcuestionarios','puntosporventarenovado','puntosporpesopagadorenovado','reftipopersonas','ventaenlinea','cotizaenlinea','beneficiario','asegurado','reftipofirma','reftipoemision','esdomiciliado','consolicitud','leyendabeneficiario','refgestion');
            $lblreemplazo	= array('Ramo de Producto','Tipo de Documentaciones','Punto x Venta','Puntos x Peso Pagado','Cuestionario','Punto x Venta Renovacion','Puntos x Peso Pagado Renovacion','Tipo Personas','Es de venta en linea','Es para cotizar','Podría tener beneficiario ','Podría tener asegurado distinto al contratante','Firmas','Tipo de Emision','Es Domiciliado','Necesita Firmar Solicitud','Leyenda del Beneficiario','Gestion');
         break;
      }

      return array($lblCambio,$lblreemplazo);
   }

}



?>

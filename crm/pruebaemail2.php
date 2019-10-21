<?php


	function mailto($test = array(), $add = array(), $html = false)
   {
       //
       $test = array_merge(array(
               'to' => null,
               'from' => null,
               'reply' => null,
               'subject' => null,
               'content' => null
       ), $test);

       // en sus marcas!
       $head = array(
               "to: $test[to]",
               'X-Mailer: PHP/'.phpversion(),
               'MIME-version: 1.0'
       );

       $hash = md5(uniqid('PHP'));
       $mime = $html? 'html': 'plain';
       $content = !$html?  // limpiamos??
               strip_tags($test['content']): $test['content'];

       if (isset($test['from']))
       { // origen..
           $head[] = "from: $test[from]";
       }
       if (isset($test['reply']))
       {// respuesta?
           $head[] = "reply-to: $test[reply]";
       }

       // header mixto...
       $head[] = 'content-type: multipart/mixed; boundary="mix-'.$hash.'"';

       // body mixto...
       $body[] = "--mix-$hash";
       $body[] = 'content-Type: multipart/alternative; boundary="alt-'.$hash.'"';

       $body[] = "--alt-$hash";
       $body[] = 'content-type: text/'.$mime.'; charset="iso-8859-1"';
       $body[] = 'content-transfer-encoding: 7bit';

       $body[] = null; // xS
       $body[] = $content;
       $body[] = null;

       $body[] = "--alt-$hash--";

       if (!empty($add) && is_array($add))
       {
           foreach ($add as $key => $val)
           { // adjuntamos...!
               $file = is_numeric($key)? $val: $key;
               $key = !is_numeric($key)? $val: null;

               if (is_file($file))
               {
                   $name = is_file($file)? basename($file): urlencode($file);
                   $mime = // establecemos tipo MIME... ?
                           preg_match('/^[a-z]+\/[a-z0-9\+-]+$/i', $key)?
                           $key: 'application/octet-stream';

                   $body[]="--mix-$hash";
                   $body[] = 'content-type: '.$mime.'; name="'.$name.'"';
                   $body[] = 'content-transfer-encoding: base64';
                   $body[] = 'content-disposition: attachment';

                   $body[]= null;
                   $body[]= // agregamos correctamente?
                           chunk_split(base64_encode(file_get_contents($file)));
                   $body[]= null;
               }
           }
       }
       $body[] = "--mix-$hash--";

       if (mail($test['to'], $test['subject'], join("\n", $body), join("\n", $head)))
       { // ... ok!?
           return true;
       }
    }


	$ruta = "https://saupureinconsulting.com.ar/aifzndesarrollo/ajax/";
	$mi_archivo = '';
	$mi_nombre = "AIF";
	//$mi_email = $email;
	$mi_email = 'info@uvaestudio.com.ec';
	$email_to = 'generencia@flip.ec, msredhotero@gmail.com, msredhotero@msn.com';
	$mi_titulo = "Este es un correo con archivo adjunto";
	$mi_mensaje = "Esta es el cuerpo de mensaje.";

	$ruta_completa = '';

	//$mailer = new AttachMailer($mi_email, $email_to, "Presenta equipos", "Lista de los equipos confirmados");
	//$mailer->attachFile($ruta_completa);
	//$mailer->send() ? "Enviado": "Problema al enviar";

	$cuerpo = 'hola';
	$asunto = 'uva estudio';

	$conf['to'] = $email_to;
	$conf['from'] = $mi_email;
	$conf['subject'] = $asunto;
	$conf['content'] = $cuerpo;

	//$files[] = __FILE__; //  este script!
	$files = '';

	if (mailto($conf, $files, true))
	{
	// ok
	echo 'ok - ';
	} else {
		echo 'error';
	}


?>
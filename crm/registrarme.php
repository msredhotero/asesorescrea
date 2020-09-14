<?php

require 'includes/funcionesUsuarios.php';
require 'includes/funcionesReferencias.php';
require 'includes/funciones.php';
require 'includes/validadores.php';

session_start();

$serviciosUsuario = new ServiciosUsuarios();
$serviciosReferencias = new ServiciosReferencias();
$serviciosFunciones 	= new Servicios();
$serviciosValidador = new serviciosValidador();

if (isset($_SESSION['usua_sahilices'])) {
  header('Location: dashboard/index.php');
} else {

  $arInput = array();

  $error = false;

  $nombre           = $_POST['nombre'];
  $apellidopaterno  = $_POST['apellido-paterno'];
  $apellidomaterno  = $_POST['apellido-materno'];
  $email            = $_POST['correo-electronico'];
  $fechanacimiento  = $_POST['fecha-nacimiento'];
  $telefono         = $_POST['telefono'];
  $sexo             = $_POST['sexo'];
  $codigopostal     = $_POST['codigo-postal'];

   if ($nombre == '' ) {
      array_push($arInput,array( 'lblerror' =>"* Debe completar el campo Nombre"));
      $error = true;
   }

   if ($apellidopaterno == '' ) {
      array_push($arInput,array( 'lblerror' =>"* Debe completar el campo Apellido Paterno"));
      $error = true;
   }

   if ($apellidomaterno == '') {
      array_push($arInput,array( 'lblerror' =>"* Debe completar el campo Apellido Materno"));
      $error = true;
   }

   if ($email == '') {
      array_push($arInput,array( 'lblerror' =>"* Debe completar el campo Correo Electronico"));
      $error = true;
   } else {
      if ($serviciosValidador->validaEmail($email) === false) {
         array_push($arInput,array( 'lblerror' =>"* Correo Electronico invalido"));
         $error = true;
      }
   }




  $pass       = $serviciosReferencias->GUID();

  $existeEmail = $serviciosUsuario->existeUsuario($email);

  if ($existeEmail == 1) {
     array_push($arInput,array( 'lblerror' =>"* El Email ingresado ya existe! "));

     $error = true;
  }

  if ($error === false) {
     // todo ok
     $refusuarios = $serviciosUsuario->insertarUsuario($nombre,$pass,16,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

      if ((integer)$refusuarios > 0) {
         $fechacrea = date('Y-m-d');
         $fechamodi = date('Y-m-d');
         $usuariocrea = 'Web';
         $usuariomodi = date('Y-m-d');

         $numerocliente = $serviciosReferencias->generaNroCliente();


         $res = $serviciosReferencias->insertarClientes(1,$nombre,$apellidopaterno,$apellidomaterno,'','','',$telefono,$email,'','',$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,'','','',0,'','',$codigopostal,'','','','','','');

         // empiezo la activacion del usuarios
         $resActivacion = $serviciosUsuario->registrarCliente($email, $apellidopaterno.' '.$apellidomaterno, $nombre, $res, $refusuarios,$pass);

         if ($resActivacion) {

            $error = false;
         } else {
            $error = true;

            array_push($arInput,array( 'lblerror' =>"* Se genero un error en el sistema, intentelo nuevamente por favor. "));
         }
      } else {
         $error = true;
         array_push($arInput,array( 'lblerror' =>"* Se genero un error en el sistema, intentelo nuevamente por favor. "));
      }


  }


}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="pingback" href="https://asesorescrea.com/xmlrpc.php">
    <title>Registro &#8211; CREA | Asesores en Banca y Seguros</title>

        <script type="text/javascript">
            var custom_blog_css = "";
            if (document.getElementById("custom_blog_styles")) {
                document.getElementById("custom_blog_styles").innerHTML += custom_blog_css;
            } else if (custom_blog_css !== "") {
                document.head.innerHTML += '<style id="custom_blog_styles" type="text/css">'+custom_blog_css+'</style>';
            }
        </script>
                            <script>
                            /* You can add more configuration options to webfontloader by previously defining the WebFontConfig with your options */
                            if ( typeof WebFontConfig === "undefined" ) {
                                WebFontConfig = new Object();
                            }
                            WebFontConfig['google'] = {families: ['Montserrat:500,700', 'Lato:300,400,700,300italic,400italic', 'Prata:400']};

                            (function() {
                                var wf = document.createElement( 'script' );
                                wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.3/webfont.js';
                                wf.type = 'text/javascript';
                                wf.async = 'true';
                                var s = document.getElementsByTagName( 'script' )[0];
                                s.parentNode.insertBefore( wf, s );
                            })();
                        </script>
                        <link rel='dns-prefetch' href='//s.w.org' />
<link rel="alternate" type="application/rss+xml" title="CREA | Asesores en Banca y Seguros &raquo; Feed" href="https://asesorescrea.com/feed/" />
<link rel="alternate" type="application/rss+xml" title="CREA | Asesores en Banca y Seguros &raquo; Feed de los comentarios" href="https://asesorescrea.com/comments/feed/" />
<meta property="og:title" content="Registro"/><meta property="og:type" content="article"/><meta property="og:url" content="https://asesorescrea.com/registro/"/><meta property="og:site_name" content="CREA | Asesores en Banca y Seguros"/><meta property="og:image" content="https://asesorescrea.com/wp-content/uploads/2020/07/banner-portada-Asesores-CREA-registro-768x298.jpg"/>		<script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/12.0.0-1\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/12.0.0-1\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/asesorescrea.com\/wp-includes\/js\/wp-emoji-release.min.js?ver=5.4.2"}};
			/*! This file is auto-generated */
			!function(e,a,t){var r,n,o,i,p=a.createElement("canvas"),s=p.getContext&&p.getContext("2d");function c(e,t){var a=String.fromCharCode;s.clearRect(0,0,p.width,p.height),s.fillText(a.apply(this,e),0,0);var r=p.toDataURL();return s.clearRect(0,0,p.width,p.height),s.fillText(a.apply(this,t),0,0),r===p.toDataURL()}function l(e){if(!s||!s.fillText)return!1;switch(s.textBaseline="top",s.font="600 32px Arial",e){case"flag":return!c([127987,65039,8205,9895,65039],[127987,65039,8203,9895,65039])&&(!c([55356,56826,55356,56819],[55356,56826,8203,55356,56819])&&!c([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]));case"emoji":return!c([55357,56424,55356,57342,8205,55358,56605,8205,55357,56424,55356,57340],[55357,56424,55356,57342,8203,55358,56605,8203,55357,56424,55356,57340])}return!1}function d(e){var t=a.createElement("script");t.src=e,t.defer=t.type="text/javascript",a.getElementsByTagName("head")[0].appendChild(t)}for(i=Array("flag","emoji"),t.supports={everything:!0,everythingExceptFlag:!0},o=0;o<i.length;o++)t.supports[i[o]]=l(i[o]),t.supports.everything=t.supports.everything&&t.supports[i[o]],"flag"!==i[o]&&(t.supports.everythingExceptFlag=t.supports.everythingExceptFlag&&t.supports[i[o]]);t.supports.everythingExceptFlag=t.supports.everythingExceptFlag&&!t.supports.flag,t.DOMReady=!1,t.readyCallback=function(){t.DOMReady=!0},t.supports.everything||(n=function(){t.readyCallback()},a.addEventListener?(a.addEventListener("DOMContentLoaded",n,!1),e.addEventListener("load",n,!1)):(e.attachEvent("onload",n),a.attachEvent("onreadystatechange",function(){"complete"===a.readyState&&t.readyCallback()})),(r=t.source||{}).concatemoji?d(r.concatemoji):r.wpemoji&&r.twemoji&&(d(r.twemoji),d(r.wpemoji)))}(window,document,window._wpemojiSettings);
		</script>
		<style type="text/css">
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 .07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
	<link rel='stylesheet' id='mailchimpSF_main_css-css'  href='https://asesorescrea.com/?mcsf_action=main_css&#038;ver=5.4.2' type='text/css' media='all' />
<!--[if IE]>
<link rel='stylesheet' id='mailchimpSF_ie_css-css'  href='https://asesorescrea.com/wp-content/plugins/mailchimp/css/ie.css?ver=5.4.2' type='text/css' media='all' />
<![endif]-->
<link rel='stylesheet' id='elementor-icons-css'  href='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css?ver=5.6.2' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-common-css'  href='https://asesorescrea.com/wp-content/plugins/elementor/assets/css/common.min.css?ver=2.9.9' type='text/css' media='all' />
<link rel='stylesheet' id='wp-block-library-css'  href='https://asesorescrea.com/wp-includes/css/dist/block-library/style.min.css?ver=5.4.2' type='text/css' media='all' />
<link rel='stylesheet' id='gt3pg-lite-frontend-css'  href='https://asesorescrea.com/wp-content/plugins/gt3-photo-video-gallery/dist/css/gutenberg/frontend.css?ver=1590451159' type='text/css' media='all' />
<link rel='stylesheet' id='contact-form-7-css'  href='https://asesorescrea.com/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=5.1.9' type='text/css' media='all' />
<link rel='stylesheet' id='blueimp-gallery.css-css'  href='https://asesorescrea.com/wp-content/plugins/gt3-photo-video-gallery/dist/css/deprecated/frontend.css?ver=1590451159' type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css'  href='https://asesorescrea.com/wp-content/plugins/revslider/public/assets/css/rs6.css?ver=6.1.5' type='text/css' media='all' />
<style id='rs-plugin-settings-inline-css' type='text/css'>
#rs-demo-id {}
</style>
<link rel='stylesheet' id='gt3-parent-style-css'  href='https://asesorescrea.com/wp-content/themes/zayne/style.css?ver=5.4.2' type='text/css' media='all' />
<link rel='stylesheet' id='slick-css'  href='https://asesorescrea.com/wp-content/plugins/gt3-themes-core/core/elementor/assets/css/slick.css?ver=5.4.2' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-blueimp-gallery-css'  href='https://asesorescrea.com/wp-content/plugins/gt3-themes-core/core/elementor/assets/css/gallery.css?ver=5.4.2' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-animations-css'  href='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/animations/animations.min.css?ver=2.9.9' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-frontend-css'  href='https://asesorescrea.com/wp-content/plugins/elementor/assets/css/frontend.min.css?ver=2.9.9' type='text/css' media='all' />
<link rel='stylesheet' id='gt3-elementor-core-frontend-css'  href='https://asesorescrea.com/wp-content/plugins/gt3-themes-core/core/elementor/assets/css/frontend.css?ver=5.4.2' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-global-css'  href='https://asesorescrea.com/wp-content/uploads/elementor/css/global.css?ver=1590451624' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-7099-css'  href='https://asesorescrea.com/wp-content/uploads/elementor/css/post-7099.css?ver=1595522000' type='text/css' media='all' />
<link rel='stylesheet' id='gt3-theme-default-style-css'  href='https://asesorescrea.com/wp-content/themes/zayne-child/style.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='gt3-theme-icon-css'  href='https://asesorescrea.com/wp-content/themes/zayne/fonts/theme-font/theme_icon.css?ver=5.4.2' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'  href='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min.css?ver=4.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='select2-css'  href='https://asesorescrea.com/wp-content/themes/zayne/css/select2.min.css?ver=4.0.5' type='text/css' media='1' />
<link rel='stylesheet' id='gt3-theme-css'  href='https://asesorescrea.com/wp-content/themes/zayne/css/theme.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='gt3-elementor-css'  href='https://asesorescrea.com/wp-content/themes/zayne/css/base-elementor.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='gt3-photo-modules-css'  href='https://asesorescrea.com/wp-content/themes/zayne/css/photo_modules.css?ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='gt3-responsive-css'  href='https://asesorescrea.com/wp-content/themes/zayne/css/responsive.css?ver=1.0' type='text/css' media='all' />
<style id='gt3-responsive-inline-css' type='text/css'>
/* Custom CSS */*{}body,.main_footer .widget-title,.widget-title,body .widget .yit-wcan-select-open,body .widget-hotspot,body div[id*="ajaxsearchlitesettings"].searchsettings form fieldset legend,.prev_next_links_fullwidht .link_item,span.elementor-drop-cap span.elementor-drop-cap-letter,input[type="date"],input[type="email"],input[type="number"],input[type="password"],input[type="search"],input[type="tel"],input[type="text"],input[type="url"],select,textarea,input[type="submit"],button,blockquote cite,blockquote code {font-family:Lato;}body {background:#ffffff;font-size:18px;line-height:30px;font-weight:300;color: #333743;}.post_share_block:hover > .post_share_wrap ul li {background:#ffffff;}.single .post_share_block:hover > .post_share_wrap ul li {background:#ffffff !important;}p {line-height: 1.6666666666667;}/* Secondaty Fonts */.secondary {font-family:Lato;font-size:14px;line-height:20px;color: #b0b0b0;}/* Custom Fonts */.module_team .team_info,h1,h2,h3,h4,h5,h6,.gt3_header_builder_component.gt3_header_builder_search_cat_component .gt3-search_cat-select,.main_wrapper .gt3_search_form:before,.widget_search .gt3_search_form label,.main_wrapper .gt3_search_form label,.main_wrapper .sidebar-container .widget_categories ul li > a:hover:before,.main_wrapper .sidebar-container .widget_product_categories ul li > a:hover:before,.main_wrapper .sidebar-container .widget_layered_nav ul li > a:hover:before,.logged-in-as a:hover,.sidebar-container .widget.widget_posts .recent_posts .post_title a,.gt3_header_builder_component .woocommerce-mini-cart__empty-message,.elementor-widget-gt3-core-button.gt3_portfolio_view_more_link_wrapper .gt3_module_button_elementor:not(.hover_type2):not(.hover_type4):not(.hover_type5) .elementor_gt3_btn_text,.elementor-widget-gt3-core-tabs .ui-tabs-nav .ui-state-default a,.single_prev_next_posts .gt3_post_navi:after,.gt3-wpcf7-subscribe-style input[type="date"], .gt3-wpcf7-subscribe-style input[type="email"], .gt3-wpcf7-subscribe-style input[type="number"], .gt3-wpcf7-subscribe-style input[type="password"], .gt3-wpcf7-subscribe-style input[type="search"], .gt3-wpcf7-subscribe-style input[type="tel"], .gt3-wpcf7-subscribe-style input[type="text"], .gt3-wpcf7-subscribe-style input[type="url"], .gt3-wpcf7-subscribe-style textarea, .gt3-wpcf7-subscribe-style select,.elementor-widget-gt3-core-portfolio .portfolio_wrapper.hover_type6 .text_wrap .title,.gt3_price_item-elementor .gt3_item_cost_wrapper h3,.gt3_custom_header_btn a{color: #232325;}.search-results .blogpost_title a {color: #232325 !important;}.search-results .blogpost_title a:hover {color: #cfb795 !important;}.gt3_icon_box__icon--number,h1,h2,h3,h4,h5,h6,.strip_template .strip-item a span,.column1 .item_title a,.index_number,.price_item_btn a,.shortcode_tab_item_title,.gt3_twitter .twitt_title,.elementor-widget-gt3-core-counter .counter,.gt3_process_item .gt3_process_item__number,.gt3_dropcaps,.dropcap{font-family: Prata;font-weight: 400;}.gt3-page-title .page_title_meta.cpt_portf * {font-weight: inherit;}.gt3_page_title_cats a:hover,.format-video .gt3_video__play_button:hover,.widget .calendar_wrap tbody td > a:before,.portfolio_wrapper .elementor-widget-gt3-core-button.gt3_portfolio_view_more_link_wrapper .gt3_module_button_elementor:not(.hover_type2):not(.hover_type4):not(.hover_type5) a:hover,.gt3_custom_header_btn a:hover{background: #cfb795;}h1,.elementor-widget-heading h1.elementor-heading-title {font-size:36px;line-height:43px;}h2,.elementor-widget-heading h2.elementor-heading-title,.elementor-widget-gt3-core-blog .blogpost_title {font-size:30px;line-height:40px;}h3,.elementor-widget-heading h3.elementor-heading-title,#customer_login h2,.gt3_header_builder__login-modal_container h2,.sidepanel .title{font-size:24px;line-height:36px;}h4,.elementor-widget-heading h4.elementor-heading-title {font-size:20px;line-height:33px;}h5,.elementor-widget-heading h5.elementor-heading-title {font-size:16px;line-height:28px;}h6,.elementor-widget-heading h6.elementor-heading-title {font-size:14px;line-height:24px;}.woocommerce-MyAccount-navigation ul li a,.diagram_item .chart,.item_title a ,.contentarea ul,.blog_post_media--link .blog_post_media__link_text p,.elementor-shortcode .has_only_email input[type="text"],.elementor-shortcode .has_only_email .mc_merge_var label, .woocommerce-LostPassword a:hover{color:#232325;}button,.gt3_header_builder_cart_component .buttons .button,.gt3_module_button a,.learn_more,.testimonials_title,blockquote p:last-child {font-family:Lato;}/* Theme color */a,.calendar_wrap thead,.gt3_practice_list__image-holder i,.load_more_works:hover,.copyright a:hover,.price_item .items_text ul li:before,.price_item.most_popular .item_cost_wrapper h3,.gt3_practice_list__title a:hover,#select2-gt3_product_cat-results li,.listing_meta,.ribbon_arrow,.flow_arrow,.main_wrapper ol > li:before,.main_wrapper #main_content ul.gt3_list_line li:before,.main_wrapper .elementor-section ul.gt3_list_line li:before,.main_wrapper #main_content ul.gt3_list_disc li:before,.main_wrapper .elementor-section ul.gt3_list_disc li:before,.top_footer a:hover,.main_wrapper .sidebar-container .widget_categories ul > li.current-cat > a,.main_wrapper .sidebar-container .widget_categories ul > li > a:hover,.single_prev_next_posts a:hover .gt3_post_navi:after,.sidebar .widget.gt3_widget.widget_search .search_form:before,.gt3_practice_list__link:before,.load_more_works,.woocommerce ul.products li.product .woocommerce-loop-product__title:hover,.woocommerce ul.cart_list li a:hover,ul.gt3_list_disc li:before,.woocommerce-MyAccount-navigation ul li a:hover,.elementor-widget-gt3-core-portfolio .portfolio_wrapper.hover_type6 .text_wrap:hover .title,.elementor-widget-gt3-core-team .module_team.type3 .team_link a:hover,.elementor-widget-gt3-core-team .module_team .team_title__text a:hover{color: #cfb795;}.gt3_practice_list__link:before,.load_more_works,.woocommerce ul.products:not(.list) li.product .gt3_woocommerce_open_control_tag div a:before,.woocommerce ul.products:not(.list) li.product .gt3_woocommerce_open_control_tag .added_to_cart:hover,.woocommerce ul.products:not(.list) li.product .gt3_woocommerce_open_control_tag div a:hover,#back_to_top,.pre_footer .mc_signup_submit{background-color: #cfb795;}.comment-reply-link:hover,.main_wrapper .gt3_product_list_nav li a:hover {color: #cfb795;}.calendar_wrap caption,.widget .calendar_wrap table td#today:before {background: #cfb795;}.wpcf7-form label,.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,div:not(.packery_wrapper) .blog_post_preview .listing_meta a:hover,.blog_post_media--quote .quote_text a:hover {color: #cfb795;}.blogpost_title a:hover {color: #cfb795 !important;}.gt3_icon_box__link a:before,.gt3_icon_box__link a:before,.stripe_item-divider{background-color: #cfb795;}.single-member-page .member-icon:hover,.single-member-page .team-link:hover,.module_testimonial blockquote:before,.module_testimonial .testimonials_title,.sidebar .widget_nav_menu .menu .menu-item > a:hover, .widget.widget_recent_entries > ul > li:hover a,.gt3_widget > ul > li a:hover,#main_content ul.wp-block-archives li > a:hover,#main_content ul.wp-block-categories li > a:hover,#main_content ul.wp-block-latest-posts li > a:hover,#respond #commentform p[class*="comment-form-"] > label.gt3_onfocus,.comment-notes .required,#cancel-comment-reply-link,.top_footer .widget.widget_recent_entries ul li > a:hover {color: #cfb795;}/* menu fonts */.main-menu>.gt3-menu-categories-title,.main-menu>ul,.main-menu>div>ul,.column_menu>ul,.column_menu>.gt3-menu-categories-title,.column_menu>div>ul {font-family:Montserrat;font-weight:500;line-height:22px;font-size:12px;text-transform: uppercase;}/* sub menu styles */.main-menu ul.sub-menu li.menu-item:hover > a:hover,.column_menu ul li.menu-item:hover > a:hover,.main-menu .current_page_item,.main-menu .current-menu-item,.main-menu .current-menu-ancestor,.gt3_header_builder_menu_component .column_menu .menu li.current_page_item > a,.gt3_header_builder_menu_component .column_menu .menu li.current-menu-item > a,.gt3_header_builder_menu_component .column_menu .menu li.current-menu-ancestor > a,.column_menu .current_page_item,.column_menu .current-menu-item,.column_menu .current-menu-ancestor{color: #c6aa83;}.main-menu ul li ul.sub-menu,.column_menu ul li ul.sub-menu,.main_header .header_search__inner .search_form,.mobile_menu_container {background-color: rgba(255,255,255,1) ;color: #1e252f ;}.main_header .header_search__inner .search_text::-webkit-input-placeholder{color: #1e252f !important;}.main_header .header_search__inner .search_text:-moz-placeholder {color: #1e252f !important;}.main_header .header_search__inner .search_text::-moz-placeholder {color: #1e252f !important;}.main_header .header_search__inner .search_text:-ms-input-placeholder {color: #1e252f !important;}/* widgets */body div[id*='ajaxsearchlitesettings'].searchsettings fieldset .label:hover,body div[id*='ajaxsearchlite'] .probox .proclose:hover,.module_team.type2 .team_title__text,.widget.widget_rss > ul > li a,.sidebar-container .widget.widget_posts .recent_posts .listing_meta span,.woocommerce ul.cart_list li .quantity,.woocommerce ul.product_list_widget li .quantity,.gt3_header_builder_cart_component__cart-container .total{color: #232325;}#back_to_top.show:hover {background-color: #232325;}/* blog */.countdown-period,.gt3-page-title_default_color_a .gt3-page-title__content .gt3_breadcrumb a,.gt3-page-title_default_color_a .gt3-page-title__content .gt3_breadcrumb .gt3_pagination_delimiter,.module_team.type2 .team-positions,.widget.widget_recent_entries > ul > li a,.gt3_widget > ul > li a,#main_content ul.wp-block-archives li > a,#main_content ul.wp-block-categories li > a,#main_content ul.wp-block-latest-posts li > a,.comment-reply-link,.sidebar .widget_nav_menu .menu .menu-item > a,.gt3_module_button_list a,.blog_post_info,.likes_block.already_liked .icon,.likes_block.already_liked:hover .icon,blockquote cite:before,blockquote code:before,.header_search__inner .search_form{color: #333743;}div:not(.packery_wrapper) .blog_post_preview .listing_meta {color: rgba(51,55,67, 0.85);}.listing_meta span.post_category a:after {color: rgba(51,55,67, 0.85) !important;}body .gt3_module_related_posts .blog_post_preview .listing_meta {color: rgba(51,55,67, 0.65);}.blogpost_title i,.widget.widget_recent_comments > ul > li a:hover,.widget.widget_rss > ul > li:hover a,.sidebar-container .widget.widget_posts .recent_posts .post_title a:hover,.comment_info a:hover,.gt3_module_button_list a:hover,.elementor-widget-gt3-core-pricebox .price_button-elementor a:hover{color: #cfb795;}.gt3_header_builder_cart_component__cart-container .total strong,.prev_next_links .title,.widget.widget_recent_comments > ul > li a {color: #232325;}.elementor-widget-gt3-core-pricebox .price_button-elementor a,.gt3_module_title .carousel_arrows a:hover span,.stripe_item:after,.packery-item .packery_overlay,.ui-datepicker .ui-datepicker-buttonpane button.ui-state-hover,.woocommerce div.product form.cart .button,.wc-proceed-to-checkout a.checkout-button.button.alt.wc-forward:hover,.woocommerce-cart table.cart td.actions .coupon .button:hover{background: #cfb795;}.elementor-widget-gt3-core-pricebox .price_button-elementor a,.elementor-widget-gt3-core-pricebox .price_button-elementor a:hover,button:hover,.ui-datepicker .ui-datepicker-buttonpane button.ui-state-hover,.woocommerce ul.products li.product .gt3_woocommerce_open_control_tag_bottom div a,.woocommerce ul.products li.product .gt3_woocommerce_open_control_tag_bottom div a:hover,.woocommerce div.product form.cart .button,.woocommerce div.product form.cart .button:hover,.woocommerce-account .woocommerce-MyAccount-content .woocommerce-message--info .button,.woocommerce-account .woocommerce-MyAccount-content .woocommerce-message--info .button:hover {border-color: #cfb795;}.gt3_module_title .carousel_arrows a:hover span:before {border-color: #cfb795;}.gt3_module_title .carousel_arrows a span,.elementor-slick-slider .slick-slider .slick-prev:after,.elementor-slick-slider .slick-slider .slick-next:after,.woocommerce ul.products li.product .gt3_woocommerce_open_control_tag .button,.woocommerce div.product form.cart button.single_add_to_cart_button.button.alt:hover,.woocommerce .woocommerce-message a.button:hover,.wc-proceed-to-checkout a.checkout-button.button.alt.wc-forward,.woocommerce-cart table.cart td.actions .coupon .button,.woocommerce .woocommerce-message a.woocommerce-Button.button:hover,.woocommerce-account .woocommerce-MyAccount-content .woocommerce-message--info .button:hover,.woocommerce-account .woocommerce-MyAccount-content .woocommerce-Message.woocommerce-Message--info.woocommerce-info .button:hover {background: #232325;}.gt3_module_title .carousel_arrows a span:before {border-color: #232325;}.post_share_block:hover > a,.woocommerce ul.products li.product .gt3_woocommerce_open_control_tag_bottom div a:hover,.woocommerce ul.products.list li.product .gt3_woocommerce_open_control_tag div a:hover:before, .woocommerce ul.products li.product .gt3_woocommerce_open_control_tag_bottom div a:hover:before,.woocommerce div.product form.cart .button:hover,.single-product.woocommerce div.product .product_meta a:hover,.woocommerce div.product span.price,.likes_block:hover .icon,.woocommerce .gt3-pagination_nav nav.woocommerce-pagination ul li a.prev:hover,.woocommerce .gt3-pagination_nav nav.woocommerce-pagination ul li a.next:hover,.woocommerce .gt3-pagination_nav nav.woocommerce-pagination ul li a.gt3_show_all:hover,.woocommerce div.product div.images div.woocommerce-product-gallery__trigger:hover{color: #cfb795;}.gt3_practice_list__filter,.isotope-filter,.woocommerce ul.products li.product .price {color: #232325;}ul.products:not(.list) li.product:hover .gt3_woocommerce_open_control_tag div a{background: #232325;}.gt3_module_title .external_link .learn_more {line-height:30px;}.gt3_image_rotate .gt3_image_rotate_title {background:#ffffff;}blockquote:before,.blog_post_media__link_text a:hover,h3#reply-title a,.comment_author_says a:hover,.dropcap,.gt3_custom_text a,.gt3_custom_button i {color: #cfb795;}.main_wrapper .content-container ol > li:before,.main_wrapper #main_content ul[class*="gt3_list_"] li:before,.single .post_tags > span,h3#reply-title a:hover,.comment_author_says,.comment_author_says a {color: #232325;}::-moz-selection{background: #cfb795;}::selection{background: #cfb795;}.gt3_practice_list__overlay:before {background-color: #cfb795;}@media only screen and (max-width: 767px){.gt3-hotspot-shortcode-wrapper .gt3_tooltip{background-color: #ffffff;}}.gt3-page-title_has_img_bg:before{background-image: radial-gradient(at center center, rgba(32,35,38, 0.3) 0%, rgba(32,35,38, 1) 85%);}.body_pp .gt3_header_builder.header_over_bg,.post-type-archive.post-type-archive-product .gt3_header_builder.header_over_bg{background-color: #202326;}.top_footer .widget.widget_posts .recent_posts li > .recent_posts_content .post_title a,.top_footer .widget.widget_archive ul li > a,.top_footer .widget.widget_categories ul li > a,.top_footer .widget.widget_pages ul li > a,.top_footer .widget.widget_meta ul li > a,.top_footer .widget.widget_recent_comments ul li > a,.top_footer .widget.widget_recent_entries ul li > a,.main_footer .top_footer .widget h3.widget-title,.top_footer strong,.top_footer .widget-title,.top_footer .widget.widget_nav_menu ul li > a:hover{color: #333744 ;}.top_footer{color: #909aa3;}.main_footer .copyright{color: #909aa3;}.gt3_header_builder__section--top .gt3_currency_switcher:hover ul,.gt3_header_builder__section--top .gt3_lang_switcher:hover ul{background-color:rgba(255,255,255,0);}.gt3_header_builder__section--middle .gt3_currency_switcher:hover ul,.gt3_header_builder__section--middle .gt3_lang_switcher:hover ul{background-color:rgba(255,255,255,0);}.gt3_header_builder__section--bottom .gt3_currency_switcher:hover ul,.gt3_header_builder__section--bottom .gt3_lang_switcher:hover ul{background-color:rgba(255,255,255,1);}.main_footer .pre_footer{color: #909aa3;}@media only screen and (max-width: 1200px){.header_side_container .logo_container .tablet_logo{height: 120px;}}@media only screen and (max-width: 767px){.header_side_container .logo_container {max-width: 109px;}.header_side_container .logo_container img{height: auto !important;}}.woocommerce div.product form.cart .qty{font-family: Prata;}.quantity-spinner.quantity-up:hover,.quantity-spinner.quantity-down:hover,.woocommerce .gt3-products-header .gridlist-toggle:hover,.elementor-widget-gt3-core-accordion .item_title .ui-accordion-header-icon:before,.elementor-element.elementor-widget-gt3-core-accordion .accordion_wrapper .item_title.ui-accordion-header-active.ui-state-active,.elementor-widget-gt3-core-accordion .accordion_wrapper .item_title:hover{color: #cfb795;}.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce #reviews a.button:hover,.woocommerce #reviews button.button:hover,.woocommerce #reviews input.button:hover,.woocommerce #respond input#submit.disabled:hover,.woocommerce #respond input#submit:disabled:hover,.woocommerce #respond input#submit:disabled[disabled]:hover,.woocommerce a.button.disabled:hover,.woocommerce a.button:disabled:hover,.woocommerce a.button:disabled[disabled]:hover,.woocommerce button.button.disabled:hover,.woocommerce button.button:disabled:hover,.woocommerce button.button:disabled[disabled]:hover,.woocommerce input.button.disabled:hover,.woocommerce input.button:disabled:hover,.woocommerce input.button:disabled[disabled]:hover{border-color: #cfb795;background-color: #cfb795;}.woocommerce #respond input#submit.alt.disabled:hover,.woocommerce #respond input#submit.alt:disabled:hover,.woocommerce #respond input#submit.alt:disabled[disabled]:hover,.woocommerce a.button.alt.disabled:hover,.woocommerce a.button.alt:disabled:hover,.woocommerce a.button.alt:disabled[disabled]:hover,.woocommerce button.button.alt.disabled:hover,.woocommerce button.button.alt:disabled:hover,.woocommerce button.button.alt:disabled[disabled]:hover,.woocommerce input.button.alt.disabled:hover,.woocommerce input.button.alt:disabled:hover,.woocommerce input.button.alt:disabled[disabled]:hover,.woocommerce div.product form.cart .qty{font-family: Prata;}.quantity-spinner.quantity-up:hover,.quantity-spinner.quantity-down:hover,.woocommerce .gt3-products-header .gridlist-toggle:hover,.elementor-widget-gt3-core-accordion .item_title .ui-accordion-header-icon:before,.elementor-element.elementor-widget-gt3-core-accordion .accordion_wrapper .item_title.ui-accordion-header-active.ui-state-active{color: #cfb795;}.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce #reviews a.button:hover,.woocommerce #reviews button.button:hover,.woocommerce #reviews input.button:hover,.woocommerce #respond input#submit.disabled:hover,.woocommerce #respond input#submit:disabled:hover,.woocommerce #respond input#submit:disabled[disabled]:hover,.woocommerce a.button.disabled:hover,.woocommerce a.button:disabled:hover,.woocommerce a.button:disabled[disabled]:hover,.woocommerce button.button.disabled:hover,.woocommerce button.button:disabled:hover,.woocommerce button.button:disabled[disabled]:hover,.woocommerce input.button.disabled:hover,.woocommerce input.button:disabled:hover,.woocommerce input.button:disabled[disabled]:hover{border-color: #cfb795;background-color: #cfb795;}.woocommerce #respond input#submit.alt.disabled,.woocommerce #respond input#submit.alt:disabled,.woocommerce #respond input#submit.alt:disabled[disabled],.woocommerce a.button.alt.disabled,.woocommerce a.button.alt:disabled,.woocommerce a.button.alt:disabled[disabled],.woocommerce button.button.alt.disabled,.woocommerce button.button.alt:disabled,.woocommerce button.button.alt:disabled[disabled],.woocommerce input.button.alt.disabled,.woocommerce input.button.alt:disabled,.woocommerce input.button.alt:disabled[disabled]{color: #cfb795;}.woocommerce #respond input#submit.alt.disabled:hover,.woocommerce #respond input#submit.alt:disabled:hover,.woocommerce #respond input#submit.alt:disabled[disabled]:hover,.woocommerce a.button.alt.disabled:hover,.woocommerce a.button.alt:disabled:hover,.woocommerce a.button.alt:disabled[disabled]:hover,.woocommerce button.button.alt.disabled:hover,.woocommerce button.button.alt:disabled:hover,.woocommerce button.button.alt:disabled[disabled]:hover,.woocommerce input.button.alt.disabled:hover,.woocommerce input.button.alt:disabled:hover,.woocommerce input.button.alt:disabled[disabled]:hover,.woocommerce .woocommerce-message a.button {background-color: #cfb795;border-color: #cfb795;}.woocommerce table.shop_table .product-quantity .qty.allotted,.woocommerce div.product form.cart .qty.allotted,.image_size_popup .close,#yith-quick-view-content .product_meta,.single-product.woocommerce div.product .product_meta,.woocommerce div.product form.cart .variations td,.woocommerce div.product .woocommerce-tabs ul.tabs li,.woocommerce .widget_shopping_cart .total,.woocommerce.widget_shopping_cart .total,.woocommerce table.shop_table thead th,.woocommerce table.woocommerce-checkout-review-order-table tfoot td .woocommerce-Price-amount,.gt3_custom_tooltip {color: #232325;}.gt3_custom_tooltip:before,.gt3_price_item-elementor .label_text span{background: #232325;}.gt3_custom_tooltip:after {border-color: #232325 transparent transparent transparent;}#yith-quick-view-content .product_meta a,#yith-quick-view-content .product_meta .sku,.single-product.woocommerce div.product .product_meta a,.single-product.woocommerce div.product .product_meta .sku,.select2-container--default .select2-selection--single .select2-selection__rendered,.woocommerce ul.products li.product .woocommerce-loop-product__title,.gt3_404_search .search_form label,.search_result_form .search_form label,.woocommerce .star-rating::before,.woocommerce #reviews p.stars span a,.woocommerce p.stars span a:hover~a::before,.woocommerce p.stars.selected span a.active~a::before,.select2-container--default .select2-results__option--highlighted[aria-selected],.select2-container--default .select2-results__option--highlighted[data-selected],.cart_list.product_list_widget a.remove,.elementor-widget-gt3-core-accordion .accordion_wrapper .item_title,.woocommerce .gt3-pagination_nav nav.woocommerce-pagination ul li .gt3_pagination_delimiter,.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item span.count,.widget_categories ul li .post_count {color: #333743;} .woocommerce #reviews a.button:hover,.woocommerce #reviews button.button:hover,.woocommerce #reviews input.button:hover,.woocommerce div.product > .woocommerce-tabs ul.tabs li.active a,.woocommerce ul.products li.product a:hover .woocommerce-loop-product__title,.widget .calendar_wrap table td#today,.woocommerce ul.products li.product .woocommerce-loop-product__title:hover{color: #cfb795;}.woocommerce.single-product #respond #commentform textarea:focus,.woocommerce div.product > .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover{border-bottom-color: #cfb795;}.woocommerce .gridlist-toggle,.woocommerce .gt3-products-header .gt3-gridlist-toggle{background-color: #ffffff;}.price_item .item_cost_wrapper h3,.price_item-cost,.elementor-widget-slider-gt3 .slider_type_1 .controls .slick-position span:not(.all_slides),.elementor-widget-slider-gt3 .slider_type_3 .controls .slick-position span:not(.all_slides),.elementor-widget-slider-gt3 .controls .slick_control_text span:not(.all_slides),.ribbon_arrow .control_text span:not(.all_slides),.elementor-widget-tabs .elementor-tab-desktop-title,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.woocommerce.widget_product_categories ul li:hover > a,.product-categories > li.cat-parent:hover .gt3-button-cat-open,.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item:hover > a,.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item:hover span,.cart_list.product_list_widget a.remove:hover,.woocommerce .return-to-shop a.button.wc-backward,.woocommerce ul.products li.product a:hover,.woocommerce table.shop_table td.product-remove a:hover:before,.woocommerce table.shop_table td.product-name a:hover{color: #cfb795;}.price_item .label_text span,a.bordered:hover,.woocommerce ul.products li.product .gt3_woocommerce_open_control_tag_bottom div a,.woocommerce-cart table.cart td.actions > .button:hover, .woocommerce-cart .shipping-calculator-form .button:hover,.woocommerce button.button.alt:hover,.woocommerce #payment .woocommerce-page #place_order,.woocommerce #payment .woocommerce-page #place_order:hover,.woocommerce .return-to-shop a.button.wc-backward:hover,.prev_next_links_fullwidht .link_item,span.ui-slider-handle.ui-state-default.ui-corner-all.ui-state-hover,body table.compare-list .add-to-cart td a:hover,.woocommerce ul.products li.product .gt3_woocommerce_open_control_tag .button:hover,.woocommerce .widget_price_filter .price_slider_amount .button:hover,.woocommerce-account .woocommerce-MyAccount-content .woocommerce-Message.woocommerce-Message--info.woocommerce-info .button,.woo_mini-count > span:not(:empty),input[type="submit"]:hover,button:hover,#review_form form#commentform input#submit:hover,.mc_signup_submit:hover,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.infinite-scroll-request > div{background-color: #cfb795;}.elementor-shortcode .mc_form_inside.has_only_email .mc_signup_submit:hover {background-color: rgba(51,55,67, 0.9);}ul.pagerblock li a,ul.pagerblock li span,.gt3_comments_pagination .page-numbers,.page-link .page-number,.woocommerce nav.woocommerce-pagination ul li a {color: rgba(51,55,67, 0.5);}ul.pagerblock li a:hover,.tagcloud a:hover,.woocommerce nav.woocommerce-pagination ul li a:hover{color: #333743;}ul.pagerblock li a.current,.gt3_comments_pagination .page-numbers.current,.page-link > span.page-number,input[type="submit"],button,.elementor-widget-gt3-core-tabs .ui-tabs-nav .ui-state-default.ui-tabs-active a,#review_form form#commentform input#submit,.mc_signup_submit,.woocommerce .gt3-products-bottom nav.woocommerce-pagination ul li .page-numbers.current,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt{background-color: #333743;}a.bordered:hover,.elementor-widget-tabs.elementor-tabs-view-horizontal .elementor-tab-desktop-title.elementor-active:after,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:before{border-color: #cfb795;}.price_item-cost,.countdown-section{font-family: Prata;}.price_item-cost span,.elementor-widget-slider-gt3 .controls .slick_control_text span.all_slides,.ribbon_arrow .control_text span.all_slides,.woocommerce ul.cart_list li a {color: #333743;}.fs_gallery_wrapper .status .first,.fs_gallery_wrapper .status .divider,.countdown-section,.page_nav_ancor a,.isotope-filter a,.isotope-filter a.active,.gt3_widget span.woocommerce-Price-amount.amount,.woocommerce table.shop_table td.product-remove a,.woocommerce table.shop_table td.product-name a,.sidebar-container .widget.widget_posts .recent_posts .listing_meta span,.gt3_header_builder_cart_component:hover .gt3_header_builder_cart_component__cart{color: #232325;}/* PixProof */.mfp-container button.mfp-arrow-right:hover {border-left-color: #cfb795;}.mfp-container button.mfp-arrow-left:hover {border-right-color: #cfb795;}/* End PixProof *//* Map */.map_info_marker {background: #f9f9f9;}.map_info_marker:after {border-color: #f9f9f9 transparent transparent transparent;}.marker_info_street_number,.marker_info_street,.footer_back2top .gt3_svg_line_icon{color: #cfb795;}.marker_info_desc {color: #949494;}.map_info_marker_content {font-family:Montserrat;font-weight:700;}.marker_info_divider:after {background: #949494;}.elementor-widget-gt3-core-button .gt3_module_button_elementor:not(.hover_type2) a,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type2 .gt3_module_button__container span.gt3_module_button__cover.front {border-color: #cfb795;}.elementor-element.elementor-widget-gt3-core-button .gt3_module_button_elementor a:not(.hover_type2):not(.hover_type5){border-color: #cfb795;background: #cfb795;}.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type4 .gt3_module_button__cover:before {background: #cfb795;border: 0px solid #cfb795;}.elementor-widget-gt3-core-button .gt3_module_button_elementor:not(.hover_type2):not(.hover_type4):not(.hover_type5) a,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type2 .gt3_module_button__container span.gt3_module_button__cover.front,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type4 .gt3_module_button__cover:before,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type5 .gt3_module_button__container .gt3_module_button__cover.front:before,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type5 .gt3_module_button__container .gt3_module_button__cover.front:after,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type6 {background: #cfb795;}.elementor-widget-gt3-core-button .gt3_module_button_elementor.button_icon_icon:not(.hover_type2) a:hover .elementor_gt3_btn_icon,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type2 .gt3_module_button__container span.gt3_module_button__cover.back .elementor_btn_icon_container .elementor_gt3_btn_icon,.elementor-widget-gt3-core-button a:hover .icon_svg_btn,.elementor-element.elementor-widget-gt3-core-button .gt3_module_button_elementor a:hover,.elementor-widget-gt3-core-button a:not(.hover_type2):hover .elementor_gt3_btn_text,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type2 .gt3_module_button__container .gt3_module_button__cover.back .elementor_gt3_btn_text,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type4:hover .gt3_module_button__container .gt3_module_button__cover.front .elementor_gt3_btn_text {color: #cfb795;}.elementor-widget-gt3-core-button .gt3_module_button_elementor:not(.hover_type2) a:hover,.elementor-widget-gt3-core-button .gt3_module_button_elementor .hover_type2 .gt3_module_button__container span.gt3_module_button__cover.back {border-color: #cfb795;}.gt3_header_builder__section--top{background-color:rgba(255,255,255,0);color:#a3adb8;/*height:42px;*/}.gt3_header_builder__section--top .gt3_header_builder__section-container{height:42px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--top ul.menu{line-height:42px;}.gt3_header_builder__section--top a:hover,.gt3_header_builder__section--top .menu-item.active_item > a,.gt3_header_builder__section--top .current-menu-item a,.gt3_header_builder__section--top .current-menu-ancestor > a,.gt3_header_builder__section--top .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--top .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--top .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--top .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--top .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--top .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--top .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#ffffff;}.gt3_header_builder__section--top{border-bottom: 1px solid rgba(255,255,255,0.2);}.gt3_header_builder__section--middle{background-color:rgba(255,255,255,0);color:#ffffff;/*height:86px;*/}.gt3_header_builder__section--middle .gt3_header_builder__section-container{height:86px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--middle ul.menu{line-height:86px;}.gt3_header_builder__section--middle a:hover,.gt3_header_builder__section--middle .menu-item.active_item > a,.gt3_header_builder__section--middle .current-menu-item a,.gt3_header_builder__section--middle .current-menu-ancestor > a,.gt3_header_builder__section--middle .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--middle .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--middle .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--middle .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--middle .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--middle .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--middle .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#ffffff;}.gt3_header_builder__section--bottom{background-color:rgba(255,255,255,1);color:#232325;/*height:100px;*/}.gt3_header_builder__section--bottom .gt3_header_builder__section-container{height:100px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--bottom ul.menu{line-height:100px;}.gt3_header_builder__section--bottom a:hover,.gt3_header_builder__section--bottom .menu-item.active_item > a,.gt3_header_builder__section--bottom .current-menu-item a,.gt3_header_builder__section--bottom .current-menu-ancestor > a,.gt3_header_builder__section--bottom .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--bottom .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--bottom .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--bottom .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--bottom .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--bottom .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--bottom .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#232325;}.gt3_header_builder__section--top__tablet{background-color:rgba(255,255,255,0);color:#a3adb8;/*height:42px;*/}.gt3_header_builder__section--top__tablet .gt3_header_builder__section-container{height:42px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--top__tablet ul.menu{line-height:42px;}.gt3_header_builder__section--top__tablet a:hover,.gt3_header_builder__section--top__tablet .menu-item.active_item > a,.gt3_header_builder__section--top__tablet .current-menu-item a,.gt3_header_builder__section--top__tablet .current-menu-ancestor > a,.gt3_header_builder__section--top__tablet .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--top__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--top__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--top__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--top__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--top__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--top__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#ffffff;}.gt3_header_builder__section--top__tablet{border-bottom: 1px solid rgba(255,255,255,0.2);}.gt3_header_builder__section--middle__tablet{background-color:rgba(255,255,255,0);color:#ffffff;/*height:86px;*/}.gt3_header_builder__section--middle__tablet .gt3_header_builder__section-container{height:86px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--middle__tablet ul.menu{line-height:86px;}.gt3_header_builder__section--middle__tablet a:hover,.gt3_header_builder__section--middle__tablet .menu-item.active_item > a,.gt3_header_builder__section--middle__tablet .current-menu-item a,.gt3_header_builder__section--middle__tablet .current-menu-ancestor > a,.gt3_header_builder__section--middle__tablet .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--middle__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--middle__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--middle__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--middle__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--middle__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--middle__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#ffffff;}.gt3_header_builder__section--bottom__tablet{background-color:rgba(255,255,255,1);color:#232325;/*height:100px;*/}.gt3_header_builder__section--bottom__tablet .gt3_header_builder__section-container{height:100px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--bottom__tablet ul.menu{line-height:100px;}.gt3_header_builder__section--bottom__tablet a:hover,.gt3_header_builder__section--bottom__tablet .menu-item.active_item > a,.gt3_header_builder__section--bottom__tablet .current-menu-item a,.gt3_header_builder__section--bottom__tablet .current-menu-ancestor > a,.gt3_header_builder__section--bottom__tablet .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--bottom__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--bottom__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--bottom__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--bottom__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--bottom__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--bottom__tablet .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#232325;}.gt3_header_builder__section--top__mobile{background-color:rgba(255,255,255,0);color:#a3adb8;/*height:38px;*/}.gt3_header_builder__section--top__mobile .gt3_header_builder__section-container{height:38px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--top__mobile ul.menu{line-height:38px;}.gt3_header_builder__section--top__mobile a:hover,.gt3_header_builder__section--top__mobile .menu-item.active_item > a,.gt3_header_builder__section--top__mobile .current-menu-item a,.gt3_header_builder__section--top__mobile .current-menu-ancestor > a,.gt3_header_builder__section--top__mobile .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--top__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--top__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--top__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--top__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--top__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--top__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#ffffff;}.gt3_header_builder__section--top__mobile{border-bottom: 1px solid rgba(255,255,255,0.2);}.gt3_header_builder__section--middle__mobile{background-color:rgba(255,255,255,0);color:#ffffff;/*height:55px;*/}.gt3_header_builder__section--middle__mobile .gt3_header_builder__section-container{height:55px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--middle__mobile ul.menu{line-height:55px;}.gt3_header_builder__section--middle__mobile a:hover,.gt3_header_builder__section--middle__mobile .menu-item.active_item > a,.gt3_header_builder__section--middle__mobile .current-menu-item a,.gt3_header_builder__section--middle__mobile .current-menu-ancestor > a,.gt3_header_builder__section--middle__mobile .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--middle__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--middle__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--middle__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--middle__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--middle__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--middle__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#ffffff;}.gt3_header_builder__section--bottom__mobile{background-color:rgba(255,255,255,1);color:#232325;/*height:100px;*/}.gt3_header_builder__section--bottom__mobile .gt3_header_builder__section-container{height:100px;background-color:rgba(255,255,255,0);}.gt3_header_builder__section--bottom__mobile ul.menu{line-height:100px;}.gt3_header_builder__section--bottom__mobile a:hover,.gt3_header_builder__section--bottom__mobile .menu-item.active_item > a,.gt3_header_builder__section--bottom__mobile .current-menu-item a,.gt3_header_builder__section--bottom__mobile .current-menu-ancestor > a,.gt3_header_builder__section--bottom__mobile .gt3_header_builder_login_component:hover .wpd_login__user_name,.gt3_header_builder__section--bottom__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:hover, .gt3_header_builder__section--bottom__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown a:focus, .gt3_header_builder__section--bottom__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown .wpml-ls-current-language:hover > a, .gt3_header_builder__section--bottom__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:hover, .gt3_header_builder__section--bottom__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click a:focus, .gt3_header_builder__section--bottom__mobile .gt3_header_builder_wpml_component .wpml-ls-legacy-dropdown-click .wpml-ls-current-language:hover > a{color:#232325;}
</style>
<script type='text/javascript'>
/* <![CDATA[ */
var gt3_themes_core = {"ajaxurl":"https:\/\/asesorescrea.com\/wp-admin\/admin-ajax.php"};
/* ]]> */
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/jquery.js?ver=1.12.4-wp'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/mailchimp//js/scrollTo.js?ver=1.5.7'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/jquery.form.min.js?ver=4.2.1'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var mailchimpSF = {"ajax_url":"https:\/\/asesorescrea.com\/"};
/* ]]> */
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/mailchimp//js/mailchimp.js?ver=1.5.7'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/mailchimp//js/datepicker.js?ver=5.4.2'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/revslider/public/assets/js/revolution.tools.min.js?ver=6.0'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/revslider/public/assets/js/rs6.min.js?ver=6.1.5'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/themes/zayne/js/select2.full.min.js?ver=4.0.5'></script>
<link rel='https://api.w.org/' href='https://asesorescrea.com/wp-json/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://asesorescrea.com/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://asesorescrea.com/wp-includes/wlwmanifest.xml" />
<meta name="generator" content="WordPress 5.4.2" />
<link rel="canonical" href="https://asesorescrea.com/registro/" />
<link rel='shortlink' href='https://asesorescrea.com/?p=7099' />
<link rel="alternate" type="application/json+oembed" href="https://asesorescrea.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fasesorescrea.com%2Fregistro%2F" />
<link rel="alternate" type="text/xml+oembed" href="https://asesorescrea.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fasesorescrea.com%2Fregistro%2F&#038;format=xml" />
<script type="text/javascript">
        jQuery(function($) {
            $('.date-pick').each(function() {
                var format = $(this).data('format') || 'mm/dd/yyyy';
                format = format.replace(/yyyy/i, 'yy');
                $(this).datepicker({
                    autoFocusNextInput: true,
                    constrainInput: false,
                    changeMonth: true,
                    changeYear: true,
                    beforeShow: function(input, inst) { $('#ui-datepicker-div').addClass('show'); },
                    dateFormat: format.toLowerCase(),
                });
            });
            d = new Date();
            $('.birthdate-pick').each(function() {
                var format = $(this).data('format') || 'mm/dd';
                format = format.replace(/yyyy/i, 'yy');
                $(this).datepicker({
                    autoFocusNextInput: true,
                    constrainInput: false,
                    changeMonth: true,
                    changeYear: false,
                    minDate: new Date(d.getFullYear(), 1-1, 1),
                    maxDate: new Date(d.getFullYear(), 12-1, 31),
                    beforeShow: function(input, inst) { $('#ui-datepicker-div').removeClass('show'); },
                    dateFormat: format.toLowerCase(),
                });

            });

        });
    </script>
<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style><meta name="generator" content="Powered by Slider Revolution 6.1.5 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />
<link rel="icon" href="https://asesorescrea.com/wp-content/uploads/2020/05/cropped-favicon-32x32.png" sizes="32x32" />
<link rel="icon" href="https://asesorescrea.com/wp-content/uploads/2020/05/cropped-favicon-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="https://asesorescrea.com/wp-content/uploads/2020/05/cropped-favicon-180x180.png" />
<meta name="msapplication-TileImage" content="https://asesorescrea.com/wp-content/uploads/2020/05/cropped-favicon-270x270.png" />
<script type="text/javascript">function setREVStartSize(t){try{var h,e=document.getElementById(t.c).parentNode.offsetWidth;if(e=0===e||isNaN(e)?window.innerWidth:e,t.tabw=void 0===t.tabw?0:parseInt(t.tabw),t.thumbw=void 0===t.thumbw?0:parseInt(t.thumbw),t.tabh=void 0===t.tabh?0:parseInt(t.tabh),t.thumbh=void 0===t.thumbh?0:parseInt(t.thumbh),t.tabhide=void 0===t.tabhide?0:parseInt(t.tabhide),t.thumbhide=void 0===t.thumbhide?0:parseInt(t.thumbhide),t.mh=void 0===t.mh||""==t.mh||"auto"===t.mh?0:parseInt(t.mh,0),"fullscreen"===t.layout||"fullscreen"===t.l)h=Math.max(t.mh,window.innerHeight);else{for(var i in t.gw=Array.isArray(t.gw)?t.gw:[t.gw],t.rl)void 0!==t.gw[i]&&0!==t.gw[i]||(t.gw[i]=t.gw[i-1]);for(var i in t.gh=void 0===t.el||""===t.el||Array.isArray(t.el)&&0==t.el.length?t.gh:t.el,t.gh=Array.isArray(t.gh)?t.gh:[t.gh],t.rl)void 0!==t.gh[i]&&0!==t.gh[i]||(t.gh[i]=t.gh[i-1]);var r,a=new Array(t.rl.length),n=0;for(var i in t.tabw=t.tabhide>=e?0:t.tabw,t.thumbw=t.thumbhide>=e?0:t.thumbw,t.tabh=t.tabhide>=e?0:t.tabh,t.thumbh=t.thumbhide>=e?0:t.thumbh,t.rl)a[i]=t.rl[i]<window.innerWidth?0:t.rl[i];for(var i in r=a[0],a)r>a[i]&&0<a[i]&&(r=a[i],n=i);var d=e>t.gw[n]+t.tabw+t.thumbw?1:(e-(t.tabw+t.thumbw))/t.gw[n];h=t.gh[n]*d+(t.tabh+t.thumbh)}void 0===window.rs_init_css&&(window.rs_init_css=document.head.appendChild(document.createElement("style"))),document.getElementById(t.c).height=h,window.rs_init_css.innerHTML+="#"+t.c+"_wrapper { height: "+h+"px }"}catch(t){console.log("Failure at Presize of Slider:"+t)}};</script>
		<style type="text/css" id="wp-custom-css">
			.gt3_header_builder_menu_component .main-menu > ul li.menu-item-has-children > a:after {
      display:none;
}



.mc_form_inside .mc_merge_var {
    margin: 0px 60px;
}


.mc_form_inside.has_only_email .mc_signup_submit {
    right: -80px;
}		</style>
		<style type="text/css" title="dynamic-css" class="options-output">.gt3_delimiter1{height:1em;}.gt3_delimiter2{height:1em;}.gt3_delimiter3{height:1em;}.gt3_delimiter4{height:1em;}.gt3_delimiter5{height:1em;}.gt3_delimiter6{height:1em;}</style><script type='text/javascript'>
jQuery(document).ready(function(){

});
</script></head>


<body class="page-template-default page page-id-7099 logged-in  elementor-default elementor-kit-6590 elementor-page elementor-page-7099" data-theme-color="#cfb795" >
    <div class='gt3_header_builder header_over_bg--tablet header_over_bg--mobile header_over_bg'><div class='gt3_header_builder__container'><div class='gt3_header_builder__section gt3_header_builder__section--top gt3_header_builder__section--hide_on_mobile'><div class='gt3_header_builder__section-container container'><div class='top_left left header_side'><div class='header_side_container'><div class="gt3_header_builder_component gt3_header_builder_text_component"><p><a class="gt3_icon_link" href="mailto:consulta@asesorescrea.com" target="_blank" style="font-size: 17px; color: inherit; margin-right: 6px; vertical-align: middle;" rel="noopener"><i class="fa fa-envelope"> </i></a> <a href="mailto:consulta@asesorescrea.com" class="gt3_styled_link gt3_custom_color" data-color="inherit" data-hover-color="inherit" style="color: inherit; vertical-align: middle; font-weight: normal;">consulta@asesorescrea.com</a></p></div><div class="gt3_header_builder_component gt3_header_builder_text_component"><p><a class="gt3_icon_link" href="tel:5551350259" target="_blank" style="font-size: 19px; color: inherit; margin-right: 6px; vertical-align: middle;" rel="noopener"><i class="fa fa-mobile"> </i></a> <a href="tel:5551350259" class="gt3_styled_link gt3_custom_color" data-color="inherit" data-hover-color="inherit" style="color: inherit; vertical-align: middle; font-weight: normal;">(55) 5135.0259</a></p></div></div></div><div class='top_right right header_side'><div class='header_side_container'><div class="gt3_header_builder_component gt3_header_builder_text_component"><p><a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px;" rel="noopener"><i class="fa fa-linkedin"> </i></a> <a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px;" rel="noopener"><i class="fa fa-twitter"> </i></a> <a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px;" rel="noopener"><i class="fa fa-facebook"> </i></a> <a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit;" rel="noopener"><i class="fa fa-instagram"> </i></a></p></div></div></div></div></div><div class='gt3_header_builder__section gt3_header_builder__section--middle gt3_header_builder__section--hide_on_mobile'><div class='gt3_header_builder__section-container container'><div class='middle_left left header_side'><div class='header_side_container'><div class='logo_container'><a href='https://asesorescrea.com/'><img class="default_logo" src="https://asesorescrea.com/wp-content/uploads/2020/06/Asesores-CREA-horizontal-blanco_.png" alt="logo" style="height:120px;"></a></div></div></div><div class='middle_right right header_side'><div class='header_side_container'><div class='gt3_header_builder_component gt3_header_builder_menu_component'><nav class='main-menu main_menu_container'><ul id="menu-menu-principal" class="menu"><li id="menu-item-6591" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6591"><a href="#"><span>SEGUROS</span></a>
<ul class="sub-menu">
	<li id="menu-item-6731" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6731"><a href="https://asesorescrea.com/seguro-de-vida/"><span>Vida</span></a></li>
	<li id="menu-item-6686" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6686"><a href="https://asesorescrea.com/seguro-de-auto/"><span>Auto</span></a></li>
	<li id="menu-item-6777" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6777"><a href="https://asesorescrea.com/gastos-medicos/"><span>Gastos Médicos</span></a></li>
	<li id="menu-item-6689" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6689"><a href="#"><span>Protección Hogar</span></a></li>
</ul>
</li>
<li id="menu-item-6592" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6592"><a href="#"><span>BANCA</span></a>
<ul class="sub-menu">
	<li id="menu-item-6828" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6828"><a href="https://asesorescrea.com/credito-hipotecario/"><span>Crédito Hipotecario</span></a></li>
	<li id="menu-item-6691" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6691"><a href="#"><span>Cuentas de Inversión</span></a></li>
	<li id="menu-item-6843" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6843"><a href="https://asesorescrea.com/tarjetas-de-credito/"><span>Tarjetas de Crédito</span></a></li>
	<li id="menu-item-6693" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6693"><a href="#"><span>Crédito TELMEX</span></a></li>
</ul>
</li>
<li id="menu-item-7041" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7041"><a href="https://asesorescrea.com/mejorar-condiciones/"><span>MEJORAR CONDICIONES</span></a></li>
<li id="menu-item-7008" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7008"><a href="https://asesorescrea.com/venta-en-linea/"><span>VENTA EN LÍNEA</span></a></li>
</ul></nav><div class="mobile-navigation-toggle"><div class="toggle-box"><div class="toggle-inner"></div></div></div></div></div></div></div></div><div class='gt3_header_builder__section gt3_header_builder__section--top__mobile gt3_header_builder__section--show_on_mobile'><div class='gt3_header_builder__section-container container'><div class='top__mobile_left left header_side'></div><div class='top_right__mobile right header_side'><div class='header_side_container'><div class="gt3_header_builder_component gt3_header_builder_text_component"><p><a class="gt3_icon_link" href="mailto:consulta@asesorescrea.com" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px; vertical-align: middle;" rel="noopener"><i class="fa fa-envelope"> </i></a><a class="gt3_icon_link" href="tel:5551350259" target="_blank" style="font-size: 19px; color: inherit; margin-right: 0; vertical-align: middle;" rel="noopener"><i class="fa fa-mobile"> </i></a></p></div><div class="gt3_header_builder_component gt3_header_builder_text_component"><p><a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px;" rel="noopener"><i class="fa fa-linkedin"> </i></a> <a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px;" rel="noopener"><i class="fa fa-twitter"> </i></a> <a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit; margin-right: 20px;" rel="noopener"><i class="fa fa-facebook"> </i></a> <a class="gt3_icon_link" href="#" target="_blank" style="font-size: 18px; color: inherit;" rel="noopener"><i class="fa fa-instagram"> </i></a></p></div></div></div></div></div><div class='gt3_header_builder__section gt3_header_builder__section--middle__mobile gt3_header_builder__section--show_on_mobile'><div class='gt3_header_builder__section-container container'><div class='middle_left__mobile left header_side'><div class='header_side_container'><div class='logo_container'><a href='https://asesorescrea.com/'><img class="default_logo" src="https://asesorescrea.com/wp-content/uploads/2020/06/Asesores-CREA-horizontal-blanco_.png" alt="logo" style="height:120px;"></a></div></div></div><div class='middle_right__mobile right header_side'><div class='header_side_container'><div class='gt3_header_builder_component gt3_header_builder_menu_component'><nav class='main-menu main_menu_container'><ul id="menu-menu-principal-1" class="menu"><li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6591"><a href="#"><span>SEGUROS</span></a>
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6731"><a href="https://asesorescrea.com/seguro-de-vida/"><span>Vida</span></a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6686"><a href="https://asesorescrea.com/seguro-de-auto/"><span>Auto</span></a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6777"><a href="https://asesorescrea.com/gastos-medicos/"><span>Gastos Médicos</span></a></li>
	<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6689"><a href="#"><span>Protección Hogar</span></a></li>
</ul>
</li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6592"><a href="#"><span>BANCA</span></a>
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6828"><a href="https://asesorescrea.com/credito-hipotecario/"><span>Crédito Hipotecario</span></a></li>
	<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6691"><a href="#"><span>Cuentas de Inversión</span></a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6843"><a href="https://asesorescrea.com/tarjetas-de-credito/"><span>Tarjetas de Crédito</span></a></li>
	<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6693"><a href="#"><span>Crédito TELMEX</span></a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7041"><a href="https://asesorescrea.com/mejorar-condiciones/"><span>MEJORAR CONDICIONES</span></a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7008"><a href="https://asesorescrea.com/venta-en-linea/"><span>VENTA EN LÍNEA</span></a></li>
</ul></nav><div class="mobile-navigation-toggle"><div class="toggle-box"><div class="toggle-inner"></div></div></div></div></div></div></div></div></div><div class="mobile_menu_container"><div class='container'><div class='gt3_header_builder_component gt3_header_builder_menu_component'><nav class='main-menu main_menu_container'><ul id="menu-menu-principal-2" class="menu"><li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6591"><a href="#"><span>SEGUROS</span></a>
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6731"><a href="https://asesorescrea.com/seguro-de-vida/"><span>Vida</span></a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6686"><a href="https://asesorescrea.com/seguro-de-auto/"><span>Auto</span></a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6777"><a href="https://asesorescrea.com/gastos-medicos/"><span>Gastos Médicos</span></a></li>
	<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6689"><a href="#"><span>Protección Hogar</span></a></li>
</ul>
</li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6592"><a href="#"><span>BANCA</span></a>
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6828"><a href="https://asesorescrea.com/credito-hipotecario/"><span>Crédito Hipotecario</span></a></li>
	<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6691"><a href="#"><span>Cuentas de Inversión</span></a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6843"><a href="https://asesorescrea.com/tarjetas-de-credito/"><span>Tarjetas de Crédito</span></a></li>
	<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6693"><a href="#"><span>Crédito TELMEX</span></a></li>
</ul>
</li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7041"><a href="https://asesorescrea.com/mejorar-condiciones/"><span>MEJORAR CONDICIONES</span></a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7008"><a href="https://asesorescrea.com/venta-en-linea/"><span>VENTA EN LÍNEA</span></a></li>
</ul></nav></div></div></div></div> <script type="text/javascript">
                var custom_page_title_style = ".gt3-page-title_wrapper .gt3-page-title{padding-top: 128px;}@media only screen and (max-width: 1200px){.gt3-page-title_wrapper .gt3-page-title{padding-top: 128px;}}@media only screen and (max-width: 767px){.gt3-page-title_wrapper .gt3-page-title{padding-top: 93px;}}";
                if (document.getElementById("custom_page_title_style")) {
                    document.getElementById("custom_page_title_style").innerHTML += custom_page_title_style;
                } else if (custom_page_title_style !== "") {
                    document.body.innerHTML += '<style id="custom_page_title_style" type="text/css">'+custom_page_title_style+'</style>';
                }</script><div class="gt3-page-title_wrapper"><div class='gt3-page-title gt3-page-title_horiz_align_left gt3-page-title_vert_align_middle gt3-page-title_has_img_bg' style="background-color:#202326;height:390px;color:#ffffff;margin-bottom:60px;background-image:url(https://asesorescrea.com/wp-content/uploads/2020/07/banner-portada-Asesores-CREA-registro.jpg);background-size:cover;background-repeat:no-repeat;background-attachment:scroll;background-position:center center;"><div class='gt3-page-title-fill' style='background-color:#343852;'></div><div class='gt3-page-title__inner has_fill_inner'><div class='container'><div class='gt3-page-title__content'><div class='page_title'><h1>Registro</h1><div class='page_sub_title' style="color:#c6ac83;"><div>Si aún no cuentas con un seguro, regístrate y te asesoramos sin compromiso con las mejores condiciones del mercado.</div></div></div></div></div></div></div></div>    <div class="site_wrapper fadeOnLoad">
                <div class="main_wrapper">

    <div class="container container-sidebar_none">
        <div class="row sidebar_none">
            <div class="content-container span12">
                <section id='main_content'>
                		<div data-elementor-type="wp-post" data-elementor-id="7099" class="elementor elementor-7099" data-elementor-settings="[]">
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
		<section class="elementor-element elementor-element-1cc1ef4 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="1cc1ef4" data-element_type="section" style="padding: 20px 15%;">
			<!--<div class="elementor-container elementor-column-gap-default">-->
		<div class="row">

      <?php
         //$error = false;
         //$arInput = array();
         //$nombre = 'Marcos';
         //array_push($arInput,array( 'lblerror' =>"* Debe completar el campo Nombre"));
         //array_push($arInput,array( 'lblerror' =>"* Debe completar el campo Apellido Paterno"));
         if ($error) {
      ?>

         <h3>Lo sentimos, su registro no pudo ser procesado, por favor verifique los siguientes datos solicitados para poder finalizar con el proceso de Registro en la Plataforma de <b>ASESORES CREA</b>.</h3>
      </div>

         <?php

         foreach ($arInput as $errores) {
            echo '<div class="row" style="margin-top:10px; color:red;"><p>'.$errores['lblerror'].'</p></div>';
         }

         ?>

      <div class="row">
         <p><bottom class="wpcf7-form-control" onClick="window.location='registro2.html'" style="display: inline-block;
          transition: background-color 300ms;
          color: #fff;
          border-radius: 0;
          outline: none;
          width: auto;
          height: 49px;
          cursor: pointer;
          padding: 11px 25px;
          line-height: 23px;
          margin: 0 0 25px 0;
          font-size: 16px;
          font-weight: 500;
          text-transform: none;
          border: none;background-color: #cfb795;">Volver</bottom></p>

      <?php } else { ?>

         <div class="row">
            <h3>Felicitaciones <b><?php echo $nombre; ?></b>, su registro fue procesado correctamente, por favor verifique su casilla de correo para poder acceder a nuestra Plataforma de <b>ASESORES CREA</b>.</h3>
         </div>
         <div class="row" style="text-align:center; margin-bottom:20px; margin-top:30px;">
            <img src="imagenes/success-png-icon-7.png" width="18%"/>
         </div>
      <?php } ?>



		</div>
			<!--</div>-->
	</section>


						</div>
			</div>
		</div>
		                    <div class="clear"></div>

<div id="comments"></div>
                                </section>
            </div>
                    </div>

    </div>

	        </div><!-- .main_wrapper -->
	</div><!-- .site_wrapper -->

   <div class='back_to_top_container'><a href='javascript:void(0)' class='gt3_back2top' id='back_to_top'></a></div>

   <footer class='main_footer fadeOnLoad clearfix' style=" background-color :#f9f9f9;" id='footer'>
      <div class='top_footer column_4 align-left'><div class='container'><div class='row' style="padding-top:70px;padding-bottom:76px;"><div class='span3'><div id="text-8" class="widget gt3_widget widget_text">			<div class="textwidget"><p><img class="wp-image-6266 size-full aligncenter" src="https://asesorescrea.com/wp-content/uploads/2020/06/Asesores-CREA-Vertical-Crema-Oscuro.png" alt="Asesores CREA" width="180" height="180" /></p>
</div>
		</div></div><div class='span3'><div id="text-10" class="widget gt3_widget widget_text"><h4 class="widget-title">EMPRESAS RELACIONADAS</h4>			<div class="textwidget"><p><a href="#">Financiera CREA</a></p>
<p><a href="#">Grupo Foncerrada y Javelly</a></p>
<p><a href="https://www.inbursa.com/portal/">Grupo Financiero Inbursa</a></p>
</div>
		</div></div><div class='span3'><div id="text-9" class="widget gt3_widget widget_text"><h4 class="widget-title">CONTACTO</h4>			<div class="textwidget"><p><a style="color: #c6ac83;" href="mailto:consulta@asesorescrea.com" target="_blank" rel="noopener noreferrer">consulta@asesorescrea.com</a><br />
<a style="color: #333744;" href="tel:5551350259" target="_blank" rel="noopener noreferrer">(55) 5135.0259</a></p>
<p>Lun &#8211; Vie: <span style="color: #333744;">9:00 – 18:00</span></p>
</div>
		</div></div><div class='span3'><div id="nav_menu-2" class="widget gt3_widget widget_nav_menu"><h4 class="widget-title">MENÚ RÁPIDO</h4><div class="menu-menu-rapido-container"><ul id="menu-menu-rapido" class="menu"><li id="menu-item-6604" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6604"><a href="#">Seguros</a></li>
<li id="menu-item-6605" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6605"><a href="#">Banca</a></li>
<li id="menu-item-7028" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7028"><a href="https://asesorescrea.com/venta-en-linea/">Venta en Línea</a></li>
<li id="menu-item-7030" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7030"><a href="#">Médicos</a></li>
<li id="menu-item-7029" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7029"><a href="#">Siniestros</a></li>
</ul></div></div></div></div></div></div><div class='copyright align-left' style="background-color:#ffffff;border-top: 1px solid rgba(240,240,240,1);"><div class='container'><div class='row' style="padding-top:17px;padding-bottom:17px;"><div class='span12'><p style="float: left;"><a href="#">Términos y condiciones</a><span style="padding: 0 8px;">|</span><a href="#">Políticas de privacidad</a></p>
<p style="float: right;">© 2020 Asesores CREA. Todos los derechos reservados.</p></div></div></div></div></footer><script type="text/template" id="tmpl-elementor-templates-modal__header">
	<div class="elementor-templates-modal__header__logo-area"></div>
	<div class="elementor-templates-modal__header__menu-area"></div>
	<div class="elementor-templates-modal__header__items-area">
		<# if ( closeType ) { #>
			<div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--{{{ closeType }}} elementor-templates-modal__header__item">
				<# if ( 'skip' === closeType ) { #>
				<span>Saltar</span>
				<# } #>
				<i class="eicon-close" aria-hidden="true" title="Cerrar"></i>
				<span class="elementor-screen-only">Cerrar</span>
			</div>
		<# } #>
		<div id="elementor-template-library-header-tools"></div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-templates-modal__header__logo">
	<span class="elementor-templates-modal__header__logo__icon-wrapper elementor-gradient-logo">
		<i class="eicon-elementor"></i>
	</span>
	<span class="elementor-templates-modal__header__logo__title">{{{ title }}}</span>
</script>
<script type="text/template" id="tmpl-elementor-finder">
	<div id="elementor-finder__search">
		<i class="eicon-search"></i>
		<input id="elementor-finder__search__input" placeholder="Teclea para encontrar lo que sea en Elementor">
	</div>
	<div id="elementor-finder__content"></div>
</script>

<script type="text/template" id="tmpl-elementor-finder-results-container">
	<div id="elementor-finder__no-results">Ningún resultado</div>
	<div id="elementor-finder__results"></div>
</script>

<script type="text/template" id="tmpl-elementor-finder__results__category">
	<div class="elementor-finder__results__category__title">{{{ title }}}</div>
	<div class="elementor-finder__results__category__items"></div>
</script>

<script type="text/template" id="tmpl-elementor-finder__results__item">
	<a href="{{ url }}" class="elementor-finder__results__item__link">
		<div class="elementor-finder__results__item__icon">
			<i class="eicon-{{{ icon }}}"></i>
		</div>
		<div class="elementor-finder__results__item__title">{{{ title }}}</div>
		<# if ( description ) { #>
			<div class="elementor-finder__results__item__description">- {{{ description }}}</div>
		<# } #>
	</a>
	<# if ( actions.length ) { #>
		<div class="elementor-finder__results__item__actions">
		<# jQuery.each( actions, function() { #>
			<a class="elementor-finder__results__item__action elementor-finder__results__item__action--{{ this.name }}" href="{{ this.url }}" target="_blank">
				<i class="eicon-{{{ this.icon }}}"></i>
			</a>
		<# } ); #>
		</div>
	<# } #>
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/widget.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/tabs.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/accordion.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill.min.js?ver=7.4.4'></script>
<script type='text/javascript'>
( 'fetch' in window ) || document.write( '<script src="https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill-fetch.min.js?ver=3.0.0"></scr' + 'ipt>' );( document.contains ) || document.write( '<script src="https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill-node-contains.min.js?ver=3.42.0"></scr' + 'ipt>' );( window.DOMRect ) || document.write( '<script src="https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill-dom-rect.min.js?ver=3.42.0"></scr' + 'ipt>' );( window.URL && window.URL.prototype && window.URLSearchParams ) || document.write( '<script src="https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill-url.min.js?ver=3.6.4"></scr' + 'ipt>' );( window.FormData && window.FormData.prototype.keys ) || document.write( '<script src="https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill-formdata.min.js?ver=3.0.12"></scr' + 'ipt>' );( Element.prototype.matches && Element.prototype.closest ) || document.write( '<script src="https://asesorescrea.com/wp-includes/js/dist/vendor/wp-polyfill-element-closest.min.js?ver=2.0.2"></scr' + 'ipt>' );
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/dist/i18n.min.js?ver=cced130522e86c87a37cd7b8397b882c'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/imagesloaded.min.js?ver=3.2.0'></script>
<script type='text/javascript'>
/* <![CDATA[ */
;document.addEventListener("DOMContentLoaded", function(){window.wp && wp.i18n && wp.i18n.setLocaleData({"":{"domain":"gt3pg","lang":"es_ES"}}, "gt3pg" );;window.ajaxurl = window.ajaxurl || "https://asesorescrea.com/wp-admin/admin-ajax.php";});
/* ]]> */
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/gt3-photo-video-gallery/dist/js/gutenberg/frontend.js?ver=1590451159'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/gt3-photo-video-gallery/dist/js/isotope.pkgd.min.js?ver=1590451159'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var wpcf7 = {"apiSettings":{"root":"https:\/\/asesorescrea.com\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"}};
/* ]]> */
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.1.9'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/mouse.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/draggable.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/underscore.min.js?ver=1.8.3'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/backbone.min.js?ver=1.4.0'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.marionette.min.js?ver=2.4.5'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.radio.min.js?ver=1.0.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/js/common-modules.min.js?ver=2.9.9'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/jquery/ui/position.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/dialog/dialog.min.js?ver=4.7.6'></script>
<script type='text/javascript'>
var elementorCommonConfig = {"version":"2.9.9","isRTL":false,"isDebug":false,"activeModules":["ajax","finder","connect"],"urls":{"assets":"https:\/\/asesorescrea.com\/wp-content\/plugins\/elementor\/assets\/"},"ajax":{"url":"https:\/\/asesorescrea.com\/wp-admin\/admin-ajax.php","nonce":"a041cef38e"},"finder":{"data":{"edit":{"title":"Editar","dynamic":true,"name":"edit"},"general":{"title":"General","dynamic":false,"items":{"saved-templates":{"title":"Plantillas guardadas","icon":"library-save","url":"https:\/\/asesorescrea.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=library","keywords":["template","section","page","library"]},"system-info":{"title":"Informaci\u00f3n del sistema","icon":"info-circle-o","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor-system-info","keywords":["system","info","environment","elementor"]},"role-manager":{"title":"Gestor de perfiles","icon":"person","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor-role-manager","keywords":["role","manager","user","elementor"]},"knowledge-base":{"title":"Base de conocimiento","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=go_knowledge_base_site","keywords":["help","knowledge","docs","elementor"]}},"name":"general"},"create":{"title":"Crear","dynamic":false,"items":{"post":{"title":"A\u00f1adir nueva Entrada","icon":"plus-circle-o","url":"https:\/\/asesorescrea.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=post&_wpnonce=dc33455cd2","keywords":["post","page","template","new","create"]},"page":{"title":"A\u00f1adir nueva P\u00e1gina","icon":"plus-circle-o","url":"https:\/\/asesorescrea.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=page&_wpnonce=dc33455cd2","keywords":["post","page","template","new","create"]},"elementor_library":{"title":"A\u00f1adir nueva Plantilla","icon":"plus-circle-o","url":"https:\/\/asesorescrea.com\/wp-admin\/edit.php?post_type=elementor_library#add_new","keywords":["post","page","template","new","create"]}},"name":"create"},"site":{"title":"Sitio","dynamic":false,"items":{"homepage":{"title":"P\u00e1gina de inicio","url":"https:\/\/asesorescrea.com","icon":"home-heart","keywords":["home","page"]},"wordpress-dashboard":{"title":"Escritorio","icon":"dashboard","url":"https:\/\/asesorescrea.com\/wp-admin\/","keywords":["dashboard","wordpress"]},"wordpress-menus":{"title":"Men\u00fas","icon":"wordpress","url":"https:\/\/asesorescrea.com\/wp-admin\/nav-menus.php","keywords":["menu","wordpress"]},"wordpress-themes":{"title":"Temas","icon":"wordpress","url":"https:\/\/asesorescrea.com\/wp-admin\/themes.php","keywords":["themes","wordpress"]},"wordpress-customizer":{"title":"Personalizador","icon":"wordpress","url":"https:\/\/asesorescrea.com\/wp-admin\/customize.php","keywords":["customizer","wordpress"]},"wordpress-plugins":{"title":"Plugins","icon":"wordpress","url":"https:\/\/asesorescrea.com\/wp-admin\/plugins.php","keywords":["plugins","wordpress"]},"wordpress-users":{"title":"Usuarios","icon":"wordpress","url":"https:\/\/asesorescrea.com\/wp-admin\/users.php","keywords":["users","profile","wordpress"]}},"name":"site"},"settings":{"title":"Ajustes","dynamic":false,"items":{"general-settings":{"title":"Ajustes generales","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor","keywords":["general","settings","elementor"]},"style":{"title":"Estilo","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor#tab-style","keywords":["style","settings","elementor"]},"advanced":{"title":"Avanzado","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor#tab-advanced","keywords":["advanced","settings","elementor"]}},"name":"settings"},"tools":{"title":"Herramientas","dynamic":false,"items":{"tools":{"title":"Herramientas","icon":"tools","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor-tools","keywords":["tools","regenerate css","safe mode","debug bar","sync library","elementor"]},"replace-url":{"title":"Reemplazar URL","icon":"tools","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor-tools#tab-replace_url","keywords":["tools","replace url","domain","elementor"]},"version-control":{"title":"Control de versiones","icon":"time-line","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor-tools#tab-versions","keywords":["tools","version","control","rollback","beta","elementor"]},"maintenance-mode":{"title":"Modo de mantenimiento","icon":"tools","url":"https:\/\/asesorescrea.com\/wp-admin\/admin.php?page=elementor-tools#tab-maintenance_mode","keywords":["tools","maintenance","coming soon","elementor"]}},"name":"tools"}},"i18n":{"finder":"Buscador"}},"connect":[]};
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/js/common.min.js?ver=2.9.9'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/themes/zayne/js/jquery.cookie.js?ver=5.4.2'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var gt3_gt3theme = {"ajaxurl":"https:\/\/asesorescrea.com\/wp-admin\/admin-ajax.php","templateUrl":"https:\/\/asesorescrea.com\/wp-content\/themes\/zayne-child"};
/* ]]> */
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/themes/zayne/js/theme.js?ver=1.0'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/themes/zayne/js/jquery.event.swipe.js?ver=5.4.2'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/wp-embed.min.js?ver=5.4.2'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-includes/js/comment-reply.min.js?ver=5.4.2'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/js/frontend-modules.min.js?ver=2.9.9'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/waypoints/waypoints.min.js?ver=4.0.2'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/swiper/swiper.min.js?ver=5.3.6'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/lib/share-link/share-link.min.js?ver=2.9.9'></script>
<script type='text/javascript'>
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false},"i18n":{"shareOnFacebook":"Compartir en Facebook","shareOnTwitter":"Compartir en Twitter","pinIt":"Pinear","downloadImage":"Descargar imagen"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"version":"2.9.9","urls":{"assets":"https:\/\/asesorescrea.com\/wp-content\/plugins\/elementor\/assets\/"},"settings":{"page":[],"general":{"elementor_global_image_lightbox":"yes","elementor_lightbox_enable_counter":"yes","elementor_lightbox_enable_fullscreen":"yes","elementor_lightbox_enable_zoom":"yes","elementor_lightbox_enable_share":"yes","elementor_lightbox_title_src":"title","elementor_lightbox_description_src":"description"},"editorPreferences":[]},"post":{"id":7099,"title":"Registro%20%E2%80%93%20CREA%20%7C%20Asesores%20en%20Banca%20y%20Seguros","excerpt":"","featuredImage":"https:\/\/asesorescrea.com\/wp-content\/uploads\/2020\/07\/banner-portada-Asesores-CREA-registro.jpg"},"user":{"roles":["administrator"]}};
</script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/elementor/assets/js/frontend.min.js?ver=2.9.9'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/gt3-elementor-unlimited-charts/assets/js/Chart.min.js'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/gt3-elementor-unlimited-charts/assets/js/frontend.js?ver=1.0.2'></script>
<script type='text/javascript' src='https://asesorescrea.com/wp-content/plugins/gt3-themes-core/core/elementor/assets/js/core-frontend.js?ver=1.2.0.8'></script>
<script type="text/javascript" id="gt3_custom_footer_js">jQuery(document).ready(function(){

});</script></body>
</html>

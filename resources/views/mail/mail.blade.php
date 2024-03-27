<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Correo Electrónico</title>
</head>
<body>


<div id="m_-2033190933289575797notification" style="height:auto;background-color:#ffffff;margin-left:auto;margin-right:auto;width:80%;max-width:550px"><span class="im">
  <div id="m_-2033190933289575797notification-header" style="padding:2em 2em 0.25em 2em;background-color:#ec1c24">
   <center>
    <!--     <img src="https://ci3.googleusercontent.com/meips/ADKq_NZOCe5eiw61hGrqUqbOhxEmEzPIfqyDWTMLZcJuBNpesmrv2r9QabQolV4ywALkt4K1YxdP2ceT6pE20xWx5lZ3FUC55Ld_qQI68bkGqmolljrNFmFxd-w_3WCi5TaCGB4VdrmR1xEei4MHO71NL0WOkwqRa9nFIxqW_0ppdyEx4a_IY6KVSKTkrsZgcXFVPAUky8IrX-5ePXMNDLkDcnFO5JPs9oCo7vmO6ySJbweuiRhUMpE7oEw=s0-d-e1-ft#https://pbselsalvado.quadientcloud.eu/api/query/Messenger/ResourceQuery?BatchId=617626423&amp;SplitId=5169770&amp;ResourceId=B5D9C9FE018408506F4CAFEA1249282285A36319.png" alt="PBS-White" border="0" width="150px" class="CToWUd a6T" data-bit="iit" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 0.01; left: 250px; top: 162.5px;"><span data-is-tooltip-wrapper="true" class="a5q" jsaction="JIbuQc:.CLIENT"><button class="VYBDae-JX-I VYBDae-JX-I-ql-ay5-ays CgzRE" jscontroller="PIVayb" jsaction="click:h5M12e;clickmod:h5M12e;pointerdown:FEiYhc; pointerup:mF5Elf; pointerenter:EX0mI; pointerleave:vpvbp; pointercancel:xyn4sd; contextmenu:xexox;focus:h06R8; blur:zjh6rb;mlnRJb:fLiPzd;" data-idom-class="CgzRE" jsname="hRZeKc" aria-label="Descargar el archivo adjunto " data-tooltip-enabled="true" data-tooltip-id="tt-c90" data-tooltip-classes="AZPksf" id="" jslog="91252; u014N:cOuCgd,Kr2w4b,xr6bB; 4:WyIjbXNnLWY6MTc5MjA4NzQ2NDM5MzE5MTIwNCJd; 43:WyJpbWFnZS9qcGVnIl0."><span class="OiePBf-zPjgPe VYBDae-JX-UHGRz"></span><span class="bHC-Q" data-unbounded="false" jscontroller="LBaJxb" jsname="m9ZlFb" soy-skip="" ssk="6:RWVI5c"></span><span class="VYBDae-JX-ank-Rtc0Jf" jsname="S5tZuc" aria-hidden="true"><span class="bzc-ank" aria-hidden="true"><svg height="20" viewBox="0 -960 960 960" width="20" focusable="false" class=" aoH"><path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.717-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.162 50.85Q725.676-192 695.96-192H263.717Z"></path></svg></span></span><div class="VYBDae-JX-ano"></div></button><div class="ne2Ple-oshW8e-J9" id="tt-c90" role="tooltip" aria-hidden="true">Descargar</div></span></div>
 -->
   </center>
   <p style="color:#ffffff;text-align:center;font-size:1.3em">
    <strong>FACTURA ELECTRÓNICA</strong>
    <br>
    <strong>
     <span style="font-size:0.85em">Notificación de envío de DTE</span>
    </strong>
   </p>
  </div>
  </span><div id="m_-2033190933289575797notification-body" style="padding:1.25em 2em 1.25em 2em;text-align:justify;color:#444444"><span class="im">
   <p>Estimado cliente  {{ strtoupper($nombreCliente) }}</p>
<p>¡Esperamos que estés teniendo un día excelente!</p>
<p>Te adjuntamos con mucho gusto la <strong>factura electrónica</strong> correspondiente a tu compra.</p>
</span><p>A continuación, te compartimos el código de generación: {{ $dte }} y 
    sello de recepción número:  que necesitas para realizar cualquier gestión 
    relacionada con este documento.</p>
<p>Si necesitas más información sobre tu factura código: {{ $dte }}  o 
    tienes alguna consulta, por favor no dudes en comunicarte con nosotros a 
    través del 2520-2520 o escribemos al correo
    <a href="mailto:{{ $correoEmpresa }}" 
    target="_blank">{{ $correoEmpresa  }}</a>.</p><span class="im">
<p>¡Estaremos encantados de ayudarte!</p>
<p>¡Gracias por confiar en nosotros para ofrecerte un servicio Súper!</p>
  </span></div><span class="im">
  <div id="m_-2033190933289575797notification-footer" style="width:100%;background-color:#c7cad6;padding:0.5em 0 0.5em 0">
   <p style="font-size:0.7em;margin:0.5em 2em 0.5em 2em;text-align:center;color:#333333">
    Favor no responder este correo electrónico ya que es generado de manera automática, 
    para comunicarte con nosotros llámanos al {{ $telefonoEmpresa }} 
    o escríbenos a: <a href="mailto:{{ $correoEmpresa }}" 
    style="text-decoration:none;font-weight:bold;color:#333333" 
    target="_blank">{{ $correoEmpresa  }}</a></p>
  </div>
 </span></div>



</body>
</html>
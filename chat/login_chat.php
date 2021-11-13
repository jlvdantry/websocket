<!--<div id="back" class="back"></div>-->
<div id='login' class="login" align="center" style="display:none;">
<h1>Inicio de Sesión</h1>
    <div>
      <p><input class="edit_login" type="text" name="login"  id="username" placeholder="Usuario" onKeyPress="var keyPressed = event.keyCode || event.which; if(keyPressed==13){$('#password').focus();}else{return Alfanumerico(event)}"></p>
      <p><input class="edit_login" type="password" name="password" id="password" placeholder="Contraseña" onKeyPress="var keyPressed = event.keyCode || event.which; if(keyPressed==13){Validar_Sesion();}else{return Alfanumerico(event)}"></p>
      <p><input type="submit" id="submit" name="commit" onclick=" Validar_Sesion()" value="Entrar"></p><br  />
      <div id="Resultado" style="width:310px;text-align:right; color:red; font-size:12px; font-weight:bold; border:red solid 0px; margin-top:-14px; height:30px"></div>
    </div>
</div>
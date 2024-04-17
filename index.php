<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>PAYPAL CHECKER</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>

<body>
	<br>
		<div class="row col-md-12">
		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<div class="card col-sm-8">
  <h5 class="card-body h6">PAYPAL CHECKER</h5>
  <div class="card-body">
    <center><span>XBINNER</span></center>
<div class="md-form">
	<div class="col-md-12">
  <textarea type="text" style="text-align: center;" id="lista" class="md-textarea form-control" rows="8"></textarea>
  <label for="lista"> </label>
</div>
</div>
<br>
						<div class="row">
						<h3 class="wow bounceIn collapsed card-link" data-wow-offset="50" data-wow-delay="0.3s" data-toggle="collapse" required>PAYPAL BEARER AUTH</h3>
							
							<textarea class="form-control" rows="1" id="auth" placeholder="Bearer A21AAxxxxxxxxxxxxxxx"></textarea>
						</div>
<center>
 <button class="btn btn-primary" style="width: 200px; outline: none;" id="testar" onclick="enviar()" >START</button>
</center>
</div>
<center>
<div class="card col-sm-8">
  <h5 class="card-body h6">Status:<span class="badge badge-secondary"> WATING FOR RESULT.</span>
<div class="md-form">
	<span>Approved:</span>&nbsp<span id="cLive" class="badge badge-success">0</span>
	<span>Declined:</span>&nbsp<span id="cDie" class="badge badge-danger"> 0</span>
	<span>Tested:</span>&nbsp<span id="total" class="badge badge-info">0</span>
	<span>Loaded:</span>&nbsp<span id="carregadas" class="badge badge-dark">0</span>
</center>
</div>
</div>
<br>

<div class="col-md-12">
<div class="card">
<div style="position: absolute;
        top: 0;
        right: 0;">
	<button id="mostra" class="btn btn-primary">SHOW/HIDE</button>
</div>
<center>
  <div class="card-body">
    <h6 onclick="copyToClipboard('#bode')" style="font-weight: bold;" class="btn btn-outline-success">Approved - <span  id="cLive2" class="badge badge-success">0</span></h6>
    <div id="bode"><span id=".aprovadas" class="aprovadas"></span>
    </div>
  </div>
</center>
</div>

<br>
<br>
<br>
<div class="col-md-12">
<div class="card">
	<div style="position: absolute;
        top: 0;
        right: 0;">
	<button id="mostra2" class="btn btn-primary">SHOW/HIDE</button>
</div>
<center>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="btn btn-outline-danger">Declined - <span id="cDie2" class="badge badge-danger">0</span></h6>
    <div id="bode2"><span id=".reprovadas" class="reprovadas"></span>
    </div>
  </div>
</center>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){


    $("#bode").hide();
	$("#esconde").show();
	
	$('#mostra').click(function(){
	$("#bode").slideToggle();
	});

});

</script>

<script type="text/javascript">

$(document).ready(function(){


    $("#bode2").hide();
	$("#esconde2").show();
	
	$('#mostra2').click(function(){
	$("#bode2").slideToggle();
	});

});

</script>

<script title="ajax do checker">
    function enviar() {
        var linha = $("#lista").val();
        var audio = new Audio('jail.mp3');
        audio['play']();
        var linhaenviar = linha.split("\n");
        var total = linhaenviar.length;
        var ap = 0;
        var rp = 0;
        linhaenviar.forEach(function(value, index) {
            setTimeout(
                function() {
                  var auth = $("#auth").val();
                    $.ajax({
                        url: 'paypal.php?lista=' + value + '&auth=' + auth,
                        type: 'GET',
                        async: true,
                        success: function(resultado) {
                            if (resultado.match("#LIVE")) {
                                removelinha();
                                audio['play']();
                                ap++;
                                aprovadas(resultado + "");
                            }else {
                                removelinha();
                                rp++;
                                reprovadas(resultado + "");
                            }
                            $('#carregadas').html(total);
                            var fila = parseInt(ap) + parseInt(rp);
                            $('#cLive').html(ap);
                            $('#cDie').html(rp);
                            $('#total').html(fila);
                            $('#cLive2').html(ap);
                            $('#cDie2').html(rp);
                        }
                    });
                }, 5000 * index);
        });
    }
    function aprovadas(str) {
        $(".aprovadas").append(str + "<br>");
    }
    function reprovadas(str) {
        $(".reprovadas").append(str + "<br>");
    }
    function removelinha() {
        var lines = $("#lista").val().split('\n');
        lines.splice(0, 1);
        $("#lista").val(lines.join("\n"));
    }
    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }
</script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/js/mdb.min.js"></script>
</body>
<br>
<footer >


    <div class="footer-copyright text-center py-3">EDITED BY XBINNER;:
      <a href="https://t.me/bin_verse/">CHANNEL</a>
    </div>


  </footer>
</html>

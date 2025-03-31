<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo</title>
    
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6" align="center">
                <label>Capturer l'étudiant(e)</label>
                <div id="my_camera" class="pre_capture_frame"></div>
                <input type="hidden" name="captured_image_data" id="captured_image_data">
                <br>
                <input type="button" class="btn btn-primary btn-round btn-file" value="Prendre une photo"
                    onClick="take_snapshot()">
            </div>
            <div class="col-lg-6" align="center">
                <label>Résultat</label>
                <div id="results">
                    <img src="../../images/default.png" style="width: 350px;" class="after_capture_frame" >
                </div>
                <br>
                <button type="button" class="btn btn-primary" onclick="saveSnap()">Enregistrer</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <script language="JavaScript">
	 // Configure a few settings and attach camera 250x187
	 Webcam.set({
	  width: 350,
	  height: 287,
	  image_format: 'jpeg',
	  jpeg_quality: 90
	 });	 
	 Webcam.attach( '#my_camera' );
	
	function take_snapshot() {
	 // play sound effect
	 //shutter.play();
	 // take snapshot and get image data
	 Webcam.snap( function(data_uri) {
	 // display results in page
	 document.getElementById('results').innerHTML = 
	  '<img class="after_capture_frame" src="../../captures_images/'+data_uri+'"/>';
	 $("#captured_image_data").val(data_uri);
	 });	 
	}

	function saveSnap(){
	var base64data = $("#captured_image_data").val();
    var urlParams = new URLSearchParams(window.location.search);
    var matricule = urlParams.get('matricule');
	 $.ajax({
			type: "POST",
			dataType: "json",
			url: "capture_image_upload.php",
			data: {image: base64data,matricule:matricule},
			success: function(data) { 
				alert(data);
			}
		});
	}
</script>

</body>

</html>
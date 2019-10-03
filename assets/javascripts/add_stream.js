function add_stream_reset() {
	$('#new_stream_modal').removeClass("modal-wide");
	
	$('#add_stream_form_1').removeClass("hidden");
	$('#add_stream_working').addClass("hidden");
	$('#add_stream_results').addClass("hidden");
	$('#add_stream_reset').addClass("hidden");
	$('#add_stream_url').val("");

	$('#add_stream_step_2').addClass("hidden");
	$('#add_stream_step_3').addClass("hidden");

	$('#add_stream_step_1').addClass("col-lg-12");
	$('#add_stream_step_1').removeClass("col-lg-4");

	document.getElementById('analyse_stream_results').innerHTML = '';

	$("#encode_to_sd").prop("checked", false);
	$("#encode_to_hd").prop("checked", false);
	$("#encode_to_fhd").prop("checked", false);
	$("#encode_to_uhd").prop("checked", false);


	// $("#encode_to_sd").prop("disabled", false);
	// $("#encode_to_hd").prop("disabled", false);
	// $("#encode_to_fhd").prop("disabled", false);
	// $("#encode_to_uhd").prop("disabled", false);
}

$('input[name="encode_to_uhd"]').on('click', function(){
    if ( $(this).is(':checked') ) {
        $('#encode_to_uhd_bitrate').removeClass("hidden");
    }else{
        $('#encode_to_uhd_bitrate').addClass("hidden");
    }
});

$('input[name="encode_to_fhd"]').on('click', function(){
    if ( $(this).is(':checked') ) {
        $('#encode_to_fhd_bitrate').removeClass("hidden");
    }else{
        $('#encode_to_fhd_bitrate').addClass("hidden");
    }
});

$('input[name="encode_to_hd"]').on('click', function(){
    if ( $(this).is(':checked') ) {
        $('#encode_to_hd_bitrate').removeClass("hidden");
    }else{
        $('#encode_to_hd_bitrate').addClass("hidden");
    }
});

$('input[name="encode_to_sd"]').on('click', function(){
    if ( $(this).is(':checked') ) {
        $('#encode_to_sd_bitrate').removeClass("hidden");
    }else{
        $('#encode_to_sd_bitrate').addClass("hidden");
    }
});

function add_stream_1() {
	$('#add_stream_form_1').addClass("hidden");
	$('#add_stream_form_1_working').removeClass("hidden");
	
	var url = $('#add_stream_url').val();

	console.log("URL: " + url);

	$("#add_stream_form_1_working_text").delay(2000).innerHTML = 'Inspecting URL. <br>';
	$("#add_stream_form_1_working_text").delay(1000).innerHTML += 'Connecting to Server. <br>';
	$("#add_stream_form_1_working_text").delay(1000).innerHTML += 'Inspecting Stream. <br>';
	$("#add_stream_form_1_working_text").delay(1000).innerHTML += 'Gathering Stream Data. <br>';

	$.ajax({
		cache: false,
		type: "GET",
        url:'actions.php?a=analyse_stream&url='+url,
		success: function(stream) {
			$('#add_stream_form_1_working').addClass("hidden");
			$('#add_stream_results').removeClass("hidden");
			$('#add_stream_reset').removeClass("hidden");
			
			console.log("Job finished.");

			for (i in stream) {

				document.getElementById('add_stream_results').innerHTML = '<strong>Stream URL:</strong> ' + url + '<br>';
				if(stream[i].status == 'online') {
					$('#add_stream_step_1').removeClass("col-lg-12");
					$('#add_stream_step_1').addClass("col-lg-4");

					$('#new_stream_modal').addClass("modal-wide");
					$('#add_stream_step_2').removeClass("hidden");
					$('#add_stream_step_3').removeClass("hidden");
				}else{
					document.getElementById('add_stream_results').innerHTML += '<strong>Status:</strong> <font color="red">Offline, Firewall Blocked or Geo Located.</font><hr>';
				}

				if(stream[i].status == 'online') {
					stream[i].screen_resolution = stream[i].stream_data[0].width+'x'+stream[i].stream_data[0].height;

					if(stream[i].stream_data[0].height > 0) {
						$("#encode_to_sd").prop("checked", true);
						
						// $("#encode_to_hd").prop("disabled", true);
						// $("#encode_to_fhd").prop("disabled", true);
						// $("#encode_to_uhd").prop("disabled", true);

						$("#encode_to_sd_bitrate").removeClass("hidden");

						stream[i].sd_hd = 'SD';
					}
					if(stream[i].stream_data[0].height > 719) {
						$("#encode_to_sd").prop("checked", true);
						$("#encode_to_hd").prop("checked", true);
						
						// $("#encode_to_fhd").prop("disabled", true);
						// $("#encode_to_uhd").prop("disabled", true);

						$("#encode_to_sd_bitrate").removeClass("hidden");
						$("#encode_to_hd_bitrate").removeClass("hidden");

						stream[i].sd_hd = 'HD';
					}
					if(stream[i].stream_data[0].height > 1079) {
						$("#encode_to_sd").prop("checked", true);
						$("#encode_to_hd").prop("checked", true);
						$("#encode_to_fhd").prop("checked", true);

						// $("#encode_to_uhd").prop("disabled", true);

						$("#encode_to_sd_bitrate").removeClass("hidden");
						$("#encode_to_hd_bitrate").removeClass("hidden");
						$("#encode_to_fhd_bitrate").removeClass("hidden");

						stream[i].sd_hd = 'FHD';
					}
					if(stream[i].stream_data[0].height > 1081) {
						$("#encode_to_sd").prop("checked", true);
						$("#encode_to_hd").prop("checked", true);
						$("#encode_to_fhd").prop("checked", true);
						$("#encode_to_uhd").prop("checked", true);

						$("#encode_to_sd_bitrate").removeClass("hidden");
						$("#encode_to_hd_bitrate").removeClass("hidden");
						$("#encode_to_fhd_bitrate").removeClass("hidden");
						$("#encode_to_uhd_bitrate").removeClass("hidden");

						stream[i].sd_hd = 'UHD';
					}

					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-12"><h4><u>Video Details</u></h4></div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Definition:</strong></div><div class="col-lg-9">'+stream[i].sd_hd+'</div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Codec:</strong></div><div class="col-lg-9">'+stream[i].stream_data[0].codec_long_name+'</div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Profile:</strong></div><div class="col-lg-9">'+stream[i].stream_data[0].profile+'</div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Resolution:</strong></div><div class="col-lg-9">'+stream[i].screen_resolution+'</div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Frame Rate:</strong></div><div class="col-lg-9">'+stream[i].stream_data[0].avg_frame_rate+'</div>';

					document.getElementById('add_stream_results').innerHTML += '<hr>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-12"><h4><u>Audio Details</u></h4></div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Codec:</strong></div><div class="col-lg-9">'+stream[i].stream_data[1].codec_long_name+'</div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Channel Layout:</strong></div><div class="col-lg-9">'+stream[i].stream_data[1].channel_layout+'</div>';
					document.getElementById('add_stream_results').innerHTML += '<div class="col-lg-3"><strong>Sample Rate:</strong></div><div class="col-lg-9">'+stream[i].stream_data[1].sample_rate+'</div>';
				}
			}
		}
	});
}
<!--
<button type="button" class="btn btn-primary btn-xs btn-flat" data-toggle="modal" data-target="#new_output_stream_modal">New Output Stream</button>
-->

<div class="modal fade" id="sample_help_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Title_Goes_Here</h4>
            </div>
            <div class="modal-body">
            	Body Here
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_server_info" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					The details on this view are gathered from your server every 1-2 minutes. There are for reference only.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_server_settings" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					1. Give your server a friendly name. <br>
					2. Enter a HTTP port number to use. If your server is behind a NAT firewall then this would be the public facing port only. SlipStream will run on port 1202 regardless what you enter here. <br>
					3. Enter a valid FQDN hostname here if you like.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_server_sources" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This view shows any DVB sources found on your server. If the headend software you are using is configured correctly and SlipStream can talk to it, then we will also display stream / channel information as well.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_server_gpus" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This view shows any NVIDIA GPU cards that were found on your server. We have provided you with a summary of the usage / stats of each card.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_server_stats" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This view shows real time stats for your CPU, RAM and Bandwidth. They are updated every 1-2 seconds.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_server_stats" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This view shows real time stats for your CPU, RAM and Bandwidth. They are updated every 1-2 seconds.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_dashboard_map" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This view shows the estimated location on your servers on a global map.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_streams_source_summary" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This is an overview of the different sources you use. They are groups by the top level domain name / IP address and they the total number of streams from each source / domain / IP. This is for your reference only.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="help_streams" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
				<p>
					This view provides you with a summary and stats for all your streams. Information is updated every 1-2 minutes. <br><br>

					Your source streams are listed and then by clicking on the green + symbol on the left hand side will reveal additional information including your putput streams.
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
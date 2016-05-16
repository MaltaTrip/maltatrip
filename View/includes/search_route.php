<div class="row" style="margin-left: 70px; margin-right: 70px; margin-top: 70px">
    <div class="col-sm-4" style="padding: 15px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Trip Details</b></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="dest_from" class="col-sm-2 control-label">From:</label>
                        <div class="col-sm-10">
                            <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-circle-o" style="color:green"></i>
									</span>
                                <input type="text" class="form-control" id="from">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dest_to" class="col-sm-2 control-label">To:</label>
                        <div class="col-sm-10">
                            <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-circle-o" style="color:red"></i>
									</span>
                                <input type="text" class="form-control" id="to">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-2 control-label">Date:</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="date">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-calendar"></i>
									</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-7 col-sm-offset-1 text-center" style="padding: 15px; background-color: #F2F2F2;">
        <h2>Trip Summary</h2>
        <div id="showMap" class="show-map">

        </div>
    </div>
</div>
<div class="row" style="margin-left: 70px; margin-right: 70px; margin-top: 30px;">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="routeList">

                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-form" title="Request a Ride">
    <p class="validateTips">You can make changes to your request e-mail before sending it.</p>

    <form>
        <fieldset>
            <textarea rows="20" cols="48" name="emailBody" id="emailBody" class="text ui-widget-content ui-corner-all">
            </textarea>
            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>

<!-- Controller Script -->
<script src="Controller/ViewController/search_route.js"></script>
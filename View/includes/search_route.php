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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Driver Details</b></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="driver_name" class="col-sm-2 control-label">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="driver_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver_rating" class="col-sm-2 control-label">Rating:</label>
                        <input id="input-2c" class="rating" min="0" max="5" step="0.5" data-size="xs" data-symbol="&#xf005;" data-glyphicon="false" data-rating-class="rating-fa" data-show-clear="false">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-7 col-sm-offset-1 text-center" style="padding: 15px; background-color: #F2F2F2;">
        <h2>This is were matching routes will be shown</h2>
    </div>
</div>
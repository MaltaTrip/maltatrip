<div class="row" style="margin-left: 70px; margin-right: 70px; margin-top: 70px">
    <div class="col-sm-6" style="padding: 15px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><b>Trip Details:</b></h4>
            </div>
            <br>
            <div class="panel-body">
                <form class="form-horizontal" name="createTrip" id="createTrip">
                    <div class="form-group">
                        <label for="dest_from" class="col-sm-4 control-label">From:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-circle-o" style="color:green"></i>
									</span>
                                <input type="text" class="form-control" id="from">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dest_to" class="col-sm-4 control-label">To:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-circle-o" style="color:red"></i>
									</span>
                                <input type="text" class="form-control" id="to">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-4 control-label">Trip Date & Time:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="pickup_date">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-calendar"></i>
									</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-4 control-label">Return Date & Time:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="return_date">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-calendar"></i>
									</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frequency" class="col-sm-4 control-label">Frequency:</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="once" value="once" checked>Once
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="workdays" value="workdays">Monday-Friday
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="daily" value="daily">Daily
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nPass" class="col-sm-4 control-label">Number of Passengers:</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="nPass">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" style="float: right"><b>Submit Trip</b></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-5 col-sm-offset-1 text-center" style="padding: 15px; background-color: #F2F2F2;">
        <h2>Trip Summary</h2>
        <div id="showMap" class="show-map">

        </div>
    </div>
</div>

<!-- Controller Script -->
<script src="Controller/ViewController/create_route.js"></script>
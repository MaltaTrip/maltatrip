<?php session_start(); ?>
<div class="container-fluid head">
    <div class="col-xs-12 jumbotron text-center">
        <div style="background-color: transparent">
            <font face="Impact"><p style="font-size: 100px; font-weight: bold; color:white;">Malta Trip</p></font>
            <font face="Impact"><p style="font-size: 40px; font-weight: bold; color: white">#1 Car Pooling System</p></font>
        </div>
        <br>
        <br>
        <form class="form-inline">
            <input type="text" class="form-control" id="from_place" size="40" placeholder="Destination From:">
            <input type="text" class="form-control" id="to_place" size="40" placeholder="Destination To:">
            <input class="form-control" id="date" name="date" size="35" placeholder="DD/MM/YYYY" type="text"/>
            <button type="button" class="btn btn-warning" id="btnSearchTrip">Search</button>
        </form>
        <br>
        <br>
        <button type="button" class="btn btn-danger" style="font-size: 25px" id="btnOfferTrip">Offer a Trip</button>
    </div>
</div>
<div class="container-fluid advantages">
    <font face="Helvetica"><p style="font-size: 40px; color:#424242;">Why Malta Trip?</p></font>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Traffic_Jam.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Less Traffic</p></font>
        </div>
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Time.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Save Time</p>
            </font>
        </div>
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Environment.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Help the Environment</p></font>
        </div>
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Fuel.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Reduce Fuel Costs</p></font>
        </div>
    </div>
</div>
<div class="container-fluid how">
    <font face="Helvetica"><p style="font-size: 40px; color:#424242;">How it Works</p></font>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Login.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Log In</p></font>
        </div>
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Details.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Enter Details</p>
            </font>
        </div>
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Path.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Find a Match</p></font>
        </div>
        <div class="col-xs-6 col-sm-3">
            <img src="../../assets/images/Carpool.png" class="center-block" style="width:75px; height:75px;">
            <br>
            <font face="Helvetica"><p class="text-center" style="font-size: 20px; color:#424242">Car Pool</p></font>
        </div>
    </div>
</div>
<div class="container-fluid" style="padding: 75px 100px 75px; background-color: #F2F2F2;">
    <font face="Helvetica"><p style="font-size: 40px; color:#424242; text-align: center;">Successful User Stories</p>
    </font>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="well well-lg" style="background-color: white;">
                <p class="text-center" style="font-size: 27px; color:#424242;"><i>Best Experience Ever<i></p>
                <p class="text-center" style="font-size: 18px; color:#424242;">- John Borg</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="well well-lg" style="background-color: white;">
                <p class="text-center" style="font-size: 27px; color:#424242;"><i>Recommend Malta Trip 100%<i></p>
                <p class="text-center" style="font-size: 18px; color:#424242;">- Lucy Attard</p>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid social">
    <div class="row">
        <div class="col-xs-1 col-xs-offset-1" style="padding: 10px;">
            <i class="fa fa-facebook-official fa-3x"></i>
            <i class="fa fa-twitter-square fa-3x"></i>
        </div>
        <div class="col-xs-8 text-right">
            <i class="fa fa-copyright fa-2x" style="color:white"></i>&nbsp <font face="Georgia"><font color="white"><b>Malta
                        Trip 2016</b></font></font>
        </div>
    </div>
</div>

<!-- Controller Script -->
<script src="Controller/ViewController/welcome.js"></script>
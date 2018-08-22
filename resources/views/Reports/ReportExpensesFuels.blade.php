<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">                                                                                                                                                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <style>
         body {
             font-family: "italic";
         }
         .wrapper {
             margin: 0 -25px 0;
             padding: 0 15px;
         }
         .middle {
             text-align: center;
             margin-top: -100px;
         }
         .title {
             font-size: 22px;
         }
         .pb-10 {
             padding-bottom: 10px;
         }
         table .left {
             text-align: left;
         }
         .pb-5 {
             padding-bottom: 5px;
         }
         .head-content{
             padding-bottom: 2px;
             border-style: none none ridge none;
             font-size: 18px;
         }
         table.table {
             font-size: 13px;
             border-collapse: collapse;
         }
         .page-break {
             page-break-after: always;
             page-break-inside: avoid;
         }
         tr.even {
             background-color: #1D1DD499;
         }
         .luis {
             font-size: 12px;
             position:fixed;
             left:0px;
             bottom:0px;
             height:30px;
             width:100%;
         }
     </style>                                                                                                                                                                                                                                                                                                                                                                                      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper">
    <div class="pb-5">
        <div class="middle pb-10 title">

        </div>

        <div class="head-content">
        </div>

    </div>
    <br/>
    <div class="content">
            <table width="%100" class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Operador</th>
                        <th>Vehiculo</th>
                        <th>Conductor</th>
                        <th>Fecha</th>
                        <th>Dispensado</th>
                        <th>Combustible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($query as $select)
                        <tr>
                            <th class="left">{{$select->exp_id}}</th>
                            <th class="left">{{$select->use_nic}}</th>
                            <th class="left">{{$select->veh_pla}}</th>
                            <th class="left">{{$select->name}}</th>
                            <th class="left">{{$select->created_at->format('d-m-Y')}}</th>
                            <th class="left">{{$select->dex_qua}}</th>
                            <th class="left">{{$select->fue_oct}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
    <div class="luis"><b>Usuario: </b>jaime <b>Fecha:</b> <?php use Carbon\Carbon;echo Carbon::now()->format('l j F Y H:i');?></div>
</body>
</html>




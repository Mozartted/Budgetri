<?php
include "../app/Controllers/SessionController.php";
use App\Controllers\SessionController;
use App\Model\Budget;
use App\Model\Account;

require_once '../vendor/autoload.php';

$session=SessionController::checkSessionKey();

$errorList=[];

if(isset($_GET['key'])){

    if($session==$_GET['key']){

    }else{
        header("Location:login.php");
    }
}

//getting all in budget
$budgetList=Budget::getAllBudget();
$collectAccount=Account::getAllAccount();

?>


<!DOCTYPE html>
<html class="" lang="en"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Management</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <meta class="foundation-mq"></head>
<body>
<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
    <div class="container topnav">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand topnav" href="#">Budget Management</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <div>
                        <form method="POST" action="../app/Controllers/createAccount.php" accept-charset="UTF-8">
                            <input class="btn btn-success" type="submit" name="logout" value="Logout">
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!--creating profile section-->
<div class="container">
    <div class="row" style="margin-top:50px;">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <div id="generalTabContent" class="tab-content responsive">
                <div id="alert-tab" class="tab-pane fade in active">
                    <div class="row">
                        <div class="panel panel-green">
                            <div class="panel-heading" style="color:#202020;">Accounts</div>
                            <div class="panel-body">
                                <!--Displays the users and their levels Admin or writer-->

                                <div class="well panel-default">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <a href="accountcreate.php" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-sign-in"></i> Create Account
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-heading">

                                    </div>


                                    <ul class="list-group">
                                        <?php
                                        foreach($collectAccount as $account ){
                                            $id=$account['id'];
                                            $name=$account['name'];
                                            $amount=$account['balance'];

                                            $output=<<<OUTPUT
<div class="list-group-item row">
                                                                  <div class="col-md-4">
                                                                      <a href="accountsView.php?account=$id">
                                                                            $name
                                                                      </a>
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                    <div class="col-md-3">
                                                                    $amount
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="col-md-6">
                                                                            <a href="account_edit.php?account=$id">
                                                                                 <input class="btn btn-danger" type="submit" value="Edit">
                                                                            </a>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <form method="POST" action="../app/Controllers/operationDelete.php?account=$id" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="Tb1joOhAxBhrqAhPk45HfAWgYbTRoNfbqjRD4P5y">
                                                                                 <input class="btn btn-danger" type="submit" value="Delete" name="DeleteAccount">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                             </div>
                                                        </div>

OUTPUT;
                                            echo($output);

                                        }
                                        ?>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Blog Categories Well -->
            <div class="well">
                <h4>Accounts</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <?php
                            foreach($budgetList as $budget ){
                                $id=$budget['id'];
                                $name=$budget['name'];
                                $balance=$budget['balance'];
                                $output=<<<OUTPUT
                                              <li><a href="budgetview.php?budget=$id">$name</a><p>$balance</p>
                                </li>
OUTPUT;
                                echo($output);

                            }
                            ?>
                        </ul>
                        <div class="row"><p>Total Balance</p><p>
                                <?php
                                $total=null;
                                foreach($collectAccount as $account ){
                                    $balance=$account['balance'];
                                    $total=$total+$balance;
                                }

                                echo($total);
                                ?></p>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>

        </div>

    </div>

</div>



<script src="js/vendor/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body></html>
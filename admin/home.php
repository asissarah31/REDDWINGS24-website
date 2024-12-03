<?php require_once("./db_connect.php"); ?>
<style>
    /* Styling for the Custom Menu */
    .custom-menu {
        z-index: 1000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #0000001c;
        border-radius: 5px;
        padding: 8px;
        min-width: 13vw;
    }
    a.custom-menu-list {
        width: 100%;
        display: flex;
        color: #4c4b4b;
        font-weight: 600;
        font-size: 1em;
        padding: 1px 11px;
    }
    a.custom-menu-list:hover, .file-item:hover, .file-item.active {
        background: #80808024;
    }
    /* Custom Style for Card Icons */
    span.card-icon {
        position: absolute;
        font-size: 3em;
        bottom: .2em;
        color: #ffffff80;
    }

    /* Candidate Card Styling */
    .candidate {
        margin: auto;
        width: 23vw;
        padding: 0 10px;
        border-radius: 20px;
        margin-bottom: 1em;
        display: flex;
        border: 30px solid #00000008;
        background: red;
    }
    .candidate_name {
        margin: 8px;
        margin-left: 3.4em;
        margin-right: 3em;
        width: 100%;
    }
    .img-field {
        display: flex;
        height: 8vh;
        width: 4.3vw;
        padding: .3em;
        background: #80808047;
        border-radius: 50%;
        position: absolute;
        left: -.7em;
        top: -.7em;
    }
    .candidate img {
        height: 100%;
        width: 100%;
        margin: auto;
        border-radius: 50%;
    }

    /* Custom Voting Field */
    .vote-field {
        position: absolute;
        right: 0;
        bottom: -.4em;
    }

    /* Custom Card Styling with Colors */
    .card {
        border-radius: 5.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background: skyblue;
        color: black; 
    }

    .card-active {
        background: #f44336; /* Red */
        color: white; /* Text color */
    }

    .card-inactive {
        background: #f44336; /* Red */
        color: white; /* Text color */
    }

    .card-verification {
        background: #ff9800; /* Orange */
        color: white; /* Text color */
    }

    .card-confirmed {
        background: #2196f3; /* Blue */
        color: white; /* Text color */
    }

    h5 {
        font-size: 1.2em;
        font-weight: 500;
        color: #000000;
    }

    /* Number Styling */
    h2 {
        color: #2c3e50;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: right;
    }

    /* Specific Section Colors */
    .total-menu-active {
        background: #f44336;
        color: red;
    }

    .total-menu-inactive {
        background: #f44336;
        color: blue;
    }

    .orders-verification {
        background: gray;
        color: white;
    }

    .confirmed-orders {
        background: #4caf50;
        color: skyblue; 
    }

    .completed-orders {
        background: #009688;
        color: white;
    }

    .orders-on-the-way {
        background: #ff9800; /* Yellow */
        color: black;
    }
</style>

<div class="container-fluid">
    <div class="row mt-3 ml-3 mr-3 mb-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back " . $_SESSION['login_name'] . "!" ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-3">
        <!-- Total Active Menu -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
            <div class="card rounded-0 shadow total-menu-active"> 
                <div class="card-body">
                    <h5 class="tex-muted">Total Menu</h5>
                    <?php $menu_a = $conn->query("SELECT * FROM `product_list` where `status` = 1")->num_rows; ?>
                    <h2><b><?= number_format($menu_a) ?></b></h2>
                </div>
            </div>
        </div>
		
       
        <!-- Orders for Verification -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
            <div class="card rounded-0 shadow orders-verification">
                <div class="card-body">
                    <h5 class="tex-muted">Orders for Verification</h5>
                    <?php $o_fv = $conn->query("SELECT * FROM `orders` where `status` = 0")->num_rows; ?>
                    <h2><b><?= number_format($o_fv) ?></b></h2>
                </div>
            </div>
        </div>

        <!-- Confirmed Orders -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
            <div class="card rounded-0 shadow confirmed-orders">
                <div class="card-body">
                    <h5 class="tex-muted">Confirmed Orders</h5>
                    <?php $o_c = $conn->query("SELECT * FROM `orders` where `status` = 1")->num_rows; ?>
                    <h2><b><?= number_format($o_c) ?></b></h2>
                </div>
            </div>
        </div>

        

        <!-- Orders on the Way -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
            <div class="card rounded-0 shadow orders-on-the-way">
                <div class="card-body">
                    <h5 class="tex-muted">Out for Delivery Orders</h5>
                    <?php $o_ontheway = $conn->query("SELECT * FROM `orders` where `status` = 2")->num_rows; ?>
                    <h2><b><?= number_format($o_ontheway) ?></b></h2>
                </div>
				     </div>
        </div>
				
				<!-- Delivered Orders -->
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
            <div class="card rounded-0 shadow completed-orders">
                <div class="card-body">
                    <h5 class="tex-muted">Delivered Orders</h5>
                    <?php $o_comp = $conn->query("SELECT * FROM `orders` where `status` = 3")->num_rows; ?>
                    <h2><b><?= number_format($o_comp) ?></b></h2>
                </div>
            </div>
        </div>
		
            </div>
        </div>
    </div>
</div>

<?php $conn->close() ?>

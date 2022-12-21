<!-- Body for student Page -->
<body>
<?php
require 'inc/navigation.php';
?>
<!-- Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <h1 class="my-4"></h1>
            <!--Navigation Tab-->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <!--			  <a class="nav-link active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">Item</a>-->
                <!--			  <a class="nav-link" id="v-pills-purchase-tab" data-toggle="pill" href="#v-pills-purchase" role="tab" aria-controls="v-pills-purchase" aria-selected="false">Purchase</a>-->
                <!--			  <a class="nav-link" id="v-pills-vendor-tab" data-toggle="pill" href="#v-pills-vendor" role="tab" aria-controls="v-pills-vendor" aria-selected="false">Vendor</a>-->

                <a class="nav-link active" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="true">Search</a>
                <a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false">Sale</a>
                <a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
                <!--			  <a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a>-->
            </div>
        </div>
        <div class="col-lg-10">
            <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
                    <!--left panel "Search"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Search Inventory
                            <button id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#itemSearchTab">Item</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#saleSearchTab">Sale</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#customerSearchTab">Customer</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="itemSearchTab" class="container-fluid tab-pane active">
                                    <br>
                                    <p>Use the grid below to search all details of items</p>
                                    <!-- <a href="#" class="itemDetailsHover" data-toggle="popover" id="10">wwwee</a> -->
                                    <div class="table-responsive" id="itemDetailsTableDiv"></div>
                                </div>
                                <div id="customerSearchTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <p>Use the grid below to search all details of customers</p>
                                    <div class="table-responsive" id="customerDetailsTableDiv"></div>
                                </div>
                                <div id="saleSearchTab" class="container-fluid tab-pane fade">
                                    <br>
                                    <p>Use the grid below to search sale details</p>
                                    <div class="table-responsive" id="saleDetailsTableDiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-sale" role="tabpanel" aria-labelledby="v-pills-sale-tab">
                    <!--left panel "Sale"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Sale Details</div>
                        <div class="card-body">
                            <div id="saleDetailsMessage"></div>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="saleDetailsItemNumber">Item Number<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="saleDetailsItemNumber" name="saleDetailsItemNumber" autocomplete="off">
                                        <div id="saleDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="saleDetailsCustomerID">Customer ID<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="saleDetailsCustomerID" name="saleDetailsCustomerID" autocomplete="off">
                                        <div id="saleDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="saleDetailsCustomerName">Customer Name</label>
                                        <input type="text" class="form-control" id="saleDetailsCustomerName" name="saleDetailsCustomerName" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="saleDetailsSaleID">Sale ID</label>
                                        <input type="text" class="form-control invTooltip" id="saleDetailsSaleID" name="saleDetailsSaleID" title="This will be auto-generated when you add a new record" autocomplete="off">
                                        <div id="saleDetailsSaleIDSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="saleDetailsItemName">Item Name</label>
                                        <!--<select id="saleDetailsItemNames" name="saleDetailsItemNames" class="form-control chosenSelect"> -->
                                        <?php
                                        //require('model/item/getItemDetails.php');
                                        ?>
                                        <!-- </select> -->
                                        <input type="text" class="form-control invTooltip" id="saleDetailsItemName" name="saleDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="saleDetailsSaleDate">Sale Date<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control datepicker" id="saleDetailsSaleDate" value="2018-05-24" name="saleDetailsSaleDate" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="saleDetailsTotalStock">Total Stock</label>
                                        <input type="text" class="form-control" name="saleDetailsTotalStock" id="saleDetailsTotalStock" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="saleDetailsDiscount">Discount %</label>
                                        <input type="text" class="form-control" id="saleDetailsDiscount" name="saleDetailsDiscount" value="0">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="saleDetailsQuantity">Quantity<span class="requiredIcon">*</span></label>
                                        <input type="number" class="form-control" id="saleDetailsQuantity" name="saleDetailsQuantity" value="0">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="saleDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="saleDetailsUnitPrice" name="saleDetailsUnitPrice" value="0">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="saleDetailsTotal">Total</label>
                                        <input type="text" class="form-control" id="saleDetailsTotal" name="saleDetailsTotal">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <div id="saleDetailsImageContainer"></div>
                                    </div>
                                </div>
                                <button type="button" id="addSaleButton" class="btn btn-success">Add Sale</button>
                                <button type="button" id="updateSaleDetailsButton" class="btn btn-primary">Update</button>
                                <button type="reset" id="saleClear" class="btn">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
                    <!--left panel "Customer"-->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Customer Details</div>
                        <div class="card-body">
                            <!-- Div to show the ajax message from validations/db submission -->
                            <div id="customerDetailsMessage"></div>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="customerDetailsCustomerFullName">Full Name<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerFullName" name="customerDetailsCustomerFullName">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="customerDetailsStatus">Status</label>
                                        <select id="customerDetailsStatus" name="customerDetailsStatus" class="form-control chosenSelect">
                                            <?php include('inc/statusList.html'); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="customerDetailsCustomerID">Customer ID</label>
                                        <input type="text" class="form-control invTooltip" id="customerDetailsCustomerID" name="customerDetailsCustomerID" title="This will be auto-generated when you add a new customer" autocomplete="off">
                                        <div id="customerDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="customerDetailsCustomerMobile">Phone (mobile)<span class="requiredIcon">*</span></label>
                                        <input type="text" class="form-control invTooltip" id="customerDetailsCustomerMobile" name="customerDetailsCustomerMobile" title="Do not enter leading 0">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="customerDetailsCustomerPhone2">Phone 2</label>
                                        <input type="text" class="form-control invTooltip" id="customerDetailsCustomerPhone2" name="customerDetailsCustomerPhone2" title="Do not enter leading 0">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="customerDetailsCustomerEmail">Email</label>
                                        <input type="email" class="form-control" id="customerDetailsCustomerEmail" name="customerDetailsCustomerEmail">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customerDetailsCustomerAddress">Address<span class="requiredIcon">*</span></label>
                                    <input type="text" class="form-control" id="customerDetailsCustomerAddress" name="customerDetailsCustomerAddress">
                                </div>
                                <div class="form-group">
                                    <label for="customerDetailsCustomerAddress2">Address 2</label>
                                    <input type="text" class="form-control" id="customerDetailsCustomerAddress2" name="customerDetailsCustomerAddress2">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="customerDetailsCustomerCity">City</label>
                                        <input type="text" class="form-control" id="customerDetailsCustomerCity" name="customerDetailsCustomerCity">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="customerDetailsCustomerDistrict">District</label>
                                        <select id="customerDetailsCustomerDistrict" name="customerDetailsCustomerDistrict" class="form-control chosenSelect">
                                            <?php include('inc/districtList.html'); ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" id="addCustomer" name="addCustomer" class="btn btn-success">Add Customer</button>
                                <button type="button" id="updateCustomerDetailsButton" class="btn btn-primary">Update</button>
                                <button type="button" id="deleteCustomerButton" class="btn btn-danger">Delete</button>
                                <button type="reset" class="btn">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
require 'inc/footer.php';
?>
</body>